<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artigo;

class ArtigoDesenvolvedorSeeder extends Seeder
{
    public function run()
    {
        $artigos = Artigo::all();
        $desenvolvedores = \App\Models\Desenvolvedor::all();

        foreach ($artigos as $artigo) {
            // Anexa de 1 a 3 desenvolvedores aleatórios por artigo
            $ids = $desenvolvedores->random(rand(1, 3))->pluck('id')->toArray();
            $artigo->desenvolvedores()->attach($ids);
        }
    }
}
