<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtigoDesenvolvedor extends Model
{
    protected $table = 'artigos_desenvolvedores';
    protected $fillable = ['artigo_id', 'desenvolvedor_id'];
}
