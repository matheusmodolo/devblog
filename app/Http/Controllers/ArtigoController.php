<?php

namespace App\Http\Controllers;

use App\Models\Artigo;
use App\Models\Desenvolvedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtigoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $artigos = Artigo::when($request->search, function ($query, $search) {
            return $query->where('titulo', 'like', "%{$search}%")
                ->orWhere('conteudo', 'like', "%{$search}%");
        })->orderBy('data_publicacao', 'desc')->paginate(5);
        return view('artigos.index', compact('artigos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $artigo = new Artigo();
        $desenvolvedores = Desenvolvedor::orderBy('nome')->get();
        return view('artigos.create', compact('desenvolvedores', 'artigo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $feedback = [
            'required' => 'O campo "' . ucfirst(':attribute') . '" é obrigatório',
            'min' => 'O campo "' . ucfirst(':attribute') . '" deve ter no mínimo :min caracteres',
            'max' => 'O campo "' . ucfirst(':attribute') . '" deve ter no máximo :max caracteres',
            'image' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem',
            'mimes' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem do tipo: jpeg, png, jpg, gif, svg',
        ];

        $regras = [
            'titulo' => 'required|string|min:3|max:255',
            'conteudo' => 'required|string|min:10',
            'foto_capa' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'desenvolvedores' => 'required|array|min:1',
            'desenvolvedores.*' => 'exists:desenvolvedores,id',
        ];

        $dados = $request->validate($regras, $feedback);

        $path = $request->file('foto_capa')
            ->store('fotos_artigos', 'public');

        $dados['foto_capa'] = $path;

        $dados['data_publicacao'] = now();

        $artigo = Artigo::create($dados);

        $artigo->desenvolvedores()->sync($dados['desenvolvedores']);

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artigo $artigo)
    {
        $artigo->load('desenvolvedores');
        return view('artigos.show', ['artigo' => $artigo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artigo $artigo)
    {
        $desenvolvedores = Desenvolvedor::orderBy('nome')->get();
        return view('artigos.edit', ['artigo' => $artigo, 'desenvolvedores' => $desenvolvedores]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artigo $artigo)
    {
        $feedback = [
            'required' => 'O campo "' . ucfirst(':attribute') . '" é obrigatório',
            'min' => 'O campo "' . ucfirst(':attribute') . '" deve ter no mínimo :min caracteres',
            'max' => 'O campo "' . ucfirst(':attribute') . '" deve ter no máximo :max caracteres',
            'image' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem',
            'mimes' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem do tipo: jpeg, png, jpg, gif, svg',
        ];

        $regras = [
            'titulo' => 'required|string|min:3|max:255',
            'conteudo' => 'required|string|min:10',
            'foto_capa' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'desenvolvedores' => 'required|array|min:1',
            'desenvolvedores.*' => 'exists:desenvolvedores,id',
        ];

        $dados = $request->validate($regras, $feedback);

        if ($request->hasFile('foto_capa')) {
            if ($artigo->foto_capa) {
                Storage::disk('public')->delete($artigo->foto_capa);
            }

            $dados['foto_capa'] = $request->file('foto_capa')
                ->store('fotos_artigos', 'public');
        }

        $dados['data_publicacao'] = $artigo->data_publicacao;

        $artigo->update($dados);

        $artigo->desenvolvedores()->detach();

        $artigo->desenvolvedores()->sync($dados['desenvolvedores']);

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artigo $artigo)
    {
        if (file_exists(public_path('storage/' . $artigo->foto_capa))) {
            unlink(public_path('storage/' . $artigo->foto_capa));
        }

        $artigo->desenvolvedores()->detach();

        $artigo->delete();

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo removido com sucesso!');
    }
}
