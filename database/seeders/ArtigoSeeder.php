<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artigo;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ArtigoSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Assuma que você tenha colocado imagens em database/seeders/imagens/artigos
        $images = File::files(database_path('seeders/imagens/artigos'));

        foreach (range(1, 20) as $index) {
            $image = $faker->randomElement($images);
            $filename = time() . '_' . $image->getFilename();
            Storage::disk('public')->putFileAs('fotos_capa', $image, $filename);

            Artigo::create([
                'titulo'    => $faker->sentence,
                'conteudo'  => $faker->paragraphs(3, true),
                'foto_capa' => 'fotos_capa/' . $filename,
            ]);
        }
    }
}
