<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Desenvolvedor;

class Artigo extends Model
{
    protected $fillable = [
        'titulo',
        'conteudo',
        'foto_capa',
        'data_publicacao'
    ];

    public function desenvolvedores()
    {
        return $this->belongsToMany(Desenvolvedor::class, 'artigos_desenvolvedores', 'artigo_id', 'desenvolvedor_id');
    }
}
