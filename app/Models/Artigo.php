<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artigo extends Model
{
    protected $fillable = [
        'titulo',
        'conteudo',
        'foto_capa',
        'data_publicacao'
    ];
}
