<?php

namespace App\Http\Controllers;

use App\Models\Desenvolvedor;
use Illuminate\Http\Request;

class DesenvolvedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desenvolvedores = Desenvolvedor::all();
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
        ];

        $regras = [
            'nome' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:desenvolvedores,email',
            'biografia' => 'required|string|min:5|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $request->validate($regras, $feedback);

        $foto = $request->file('foto');
        $nomeFoto = time() . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('fotos'), $nomeFoto);
        $request->merge(['foto' => $nomeFoto]);

        $desenvolvedor = Desenvolvedor::create($request->all());

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
            'nome'      => 'required|string|min:2|max:255',
            'email'     => "required|email|unique:desenvolvedores,email,{$desenvolvedor->id}",
            'biografia' => 'required|string|min:5|max:255',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $dados = $request->validate($regras, $feedback);

        if ($request->hasFile('foto')) {
            // $dados['foto'] = $request->file('foto')->store('fotos');
            $foto = $request->file('foto');
            $nomeFoto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('fotos'), $nomeFoto);
            $dados['foto'] = $nomeFoto;
        } else {
            $dados['foto'] = $desenvolvedor->foto;
        }

        $desenvolvedor->update($dados);

        return redirect()->route('desenvolvedores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desenvolvedor $desenvolvedor)
    {
        $desenvolvedor->delete();

        return redirect()->route('desenvolvedores.index');
    }
}
