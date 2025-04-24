<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desenvolvedor extends Model
{
    protected $table = 'desenvolvedores';
    
    protected $fillable = [
        'nome',
        'email',
        'biografia',
        'foto',
    ];

    public function artigos()
    {
        return $this->belongsToMany(Artigo::class, 'artigos_desenvolvedores', 'desenvolvedor_id', 'artigo_id');
    }
}
