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
        $regras = [
            'titulo' => 'required|string|min:3|max:255',
            'conteudo' => 'required|string|min:10',
            'foto_capa' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'desenvolvedores' => 'required|array|min:1',
            'desenvolvedores.*' => 'exists:desenvolvedores,id',
        ];

        $feedback = [
            'required' => 'O campo "' . ucfirst(':attribute') . '" é obrigatório',
            'min' => 'O campo "' . ucfirst(':attribute') . '" deve ter no mínimo :min caracteres',
            'max' => 'O campo "' . ucfirst(':attribute') . '" deve ter no máximo :max caracteres',
            'image' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem',
            'mimes' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem do tipo: jpeg, png, jpg, gif, svg',
            'foto_capa.uploaded' => 'O upload da imagem falhou. Verifique seu tamanho e tente novamente.',
        ];

        $dados = $request->validate($regras, $feedback);

        // Faz o upload da imagem
        $path = $request->file('foto_capa')
            ->store('fotos_artigos', 'public');

        // Armazena o caminho da imagem
        $dados['foto_capa'] = $path;

        // Armazena a data de publicação
        $dados['data_publicacao'] = now();

        // Cria o artigo
        $artigo = Artigo::create($dados);

        // Associa os desenvolvedores
        $artigo->desenvolvedores()->sync($dados['desenvolvedores']);

        // Chama a função global para exibir um toast
        toast('Sucesso', 'Artigo criado!', 'success');

        return redirect()->route('artigos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artigo $artigo)
    {
        // Carrega os desenvolvedores
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
        $regras = [
            'titulo' => 'required|string|min:3|max:255',
            'conteudo' => 'required|string|min:10',
            'foto_capa' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'desenvolvedores' => 'required|array|min:1',
            'desenvolvedores.*' => 'exists:desenvolvedores,id',
        ];

        $feedback = [
            'required' => 'O campo "' . ucfirst(':attribute') . '" é obrigatório',
            'min' => 'O campo "' . ucfirst(':attribute') . '" deve ter no mínimo :min caracteres',
            'max' => 'O campo "' . ucfirst(':attribute') . '" deve ter no máximo :max caracteres',
            'image' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem',
            'mimes' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem do tipo: jpeg, png, jpg, gif, svg',
            'foto_capa.uploaded' => 'O upload da imagem falhou. Verifique seu tamanho e tente novamente.',
        ];

        $dados = $request->validate($regras, $feedback);

        // Verifica se foi enviado uma nova imagem
        if ($request->hasFile('foto_capa')) {
            // Remove a imagem antiga
            if ($artigo->foto_capa) {
                Storage::disk('public')->delete($artigo->foto_capa);
            }

            // Faz o upload da nova imagem
            $dados['foto_capa'] = $request->file('foto_capa')
                ->store('fotos_artigos', 'public');
        }

        // Armazena a data de publicação
        $dados['data_publicacao'] = $artigo->data_publicacao;

        // Atualiza o artigo
        $artigo->update($dados);

        // Desassocia os desenvolvedores
        $artigo->desenvolvedores()->detach();

        // Associa os desenvolvedores
        $artigo->desenvolvedores()->sync($dados['desenvolvedores']);

        // Chama a função global para exibir um toast
        toast('Sucesso', 'Artigo atualizado!', 'success');

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artigo $artigo)
    {
        // Remove a imagem, se existir
        if (file_exists(public_path('storage/' . $artigo->foto_capa))) {
            unlink(public_path('storage/' . $artigo->foto_capa));
        }

        // Desassocia os desenvolvedores
        $artigo->desenvolvedores()->detach();

        // Exclui o artigo
        $artigo->delete();

        // Chama a função global para exibir um toast
        toast('Sucesso', 'Artigo excluído!', 'success');

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo removido com sucesso!');
    }
}
