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
        // Imagens de capa de artigos
        $images = File::files(database_path('seeders/imagens/artigos'));

        // Cria 20 artigos
        foreach (range(1, 20) as $index) {
            // Escolhe uma imagem aleatória
            $image = $faker->randomElement($images);

            // Cria um nome único para a imagem
            $filename = time() . rand(1000, 9999) . '_' . $image->getFilename();
            // Upload da imagem
            Storage::disk('public')->putFileAs('fotos_capa', $image, $filename);

            // Cria o artigo
            Artigo::create([
                'titulo'    => $faker->sentence,
                'conteudo'  => $faker->paragraphs(4, true),
                'foto_capa' => 'fotos_capa/' . $filename,
            ]);
        }
    }
}
