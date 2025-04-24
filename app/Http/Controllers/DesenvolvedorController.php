<?php

namespace App\Http\Controllers;

use App\Models\Desenvolvedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DesenvolvedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $desenvolvedores = Desenvolvedor::when($request->search, function ($query, $search) {
            return $query->where('nome', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->orderBy('nome')->paginate(5);
        return view('desenvolvedores.index', compact('desenvolvedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('desenvolvedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $feedback = [
            'required' => 'O campo "' . ucfirst(':attribute') . '" é obrigatório',
            'unique' => 'Já existe um desenvolvedor com este email',
            'email' => 'Email inválido',
            'min' => 'O campo "' . ucfirst(':attribute') . '" deve ter no mínimo :min caracteres',
            'max' => 'O campo "' . ucfirst(':attribute') . '" deve ter no máximo :max caracteres',
            'image' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem',
            'mimes' => 'O campo "' . ucfirst(':attribute') . '" deve ser uma imagem do tipo: jpeg, png, jpg, gif, svg',
        ];

        $regras = [
            'nome' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:desenvolvedores,email',
            'biografia' => 'required|string|min:5|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $dados = $request->validate($regras, $feedback);

        $path = $request->file('foto')
            ->store('fotos_desenvolvedores', 'public');

        $dados['foto'] = $path;

        Desenvolvedor::create($dados);

        toast('Sucesso', 'Desenvolvedor criado!', 'success');

        return redirect()->route('desenvolvedores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Desenvolvedor $desenvolvedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desenvolvedor $desenvolvedor)
    {
        return view('desenvolvedores.edit', ['desenvolvedor' => $desenvolvedor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desenvolvedor $desenvolvedor)
    {
        $feedback = [
            'required' => 'O campo "' . ucfirst(':attribute') . '" é obrigatório',
            'unique' => 'Já existe um desenvolvedor com este email',
            'email' => 'Email inválido',
            'min' => 'O campo "' . ucfirst(':attribute') . '" deve ter no mínimo :min caracteres',
            'max' => 'O campo "' . ucfirst(':attribute') . '" deve ter no máximo :max caracteres',
        ];

        $regras = [
            'nome'      => ['required', 'string', 'min:2', 'max:255'],
            'email'     => [
                'required',
                'email',
                Rule::unique('desenvolvedores', 'email')
                    ->ignore($desenvolvedor->id),
            ],
            'biografia' => ['required', 'string', 'min:5', 'max:255'],
            'foto'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        $dados = $request->validate($regras, $feedback);

        if ($request->hasFile('foto')) {
            if ($desenvolvedor->foto) {
                Storage::disk('public')->delete($desenvolvedor->foto);
            }

            $dados['foto'] = $request->file('foto')
                ->store('fotos_desenvolvedores', 'public');
        }

        $desenvolvedor->update($dados);

        toast('Sucesso', 'Desenvolvedor atualizado!', 'success');

        return redirect()->route('desenvolvedores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desenvolvedor $desenvolvedor)
    {
        if (file_exists(public_path('storage/' . $desenvolvedor->foto))) {
            unlink(public_path('storage/' . $desenvolvedor->foto));
        }

        $desenvolvedor->artigos()->detach();

        $desenvolvedor->delete();

        toast('Sucesso', 'Desenvolvedor excluído!', 'success');

        return redirect()->route('desenvolvedores.index');
    }
}
