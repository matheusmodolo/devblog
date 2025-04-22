<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desenvolvedor extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'biografia',
        'foto',
    ];
}
