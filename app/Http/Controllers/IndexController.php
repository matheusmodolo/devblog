<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artigo;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $artigos = Artigo::orderBy('data_publicacao', 'desc')->paginate(5);
        return view('index', ['artigos' => $artigos]);
    }
}
