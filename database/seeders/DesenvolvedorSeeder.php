<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Desenvolvedor;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DesenvolvedorSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Imagens de cdesenvolvedores
        $images = File::files(database_path('seeders/imagens/desenvolvedores'));

        // Cria 10 desenvolvedores
        foreach (range(1, 10) as $index) {
            $image = $faker->randomElement($images);

            // Cria um nome único para a imagem
            $filename = time() . rand(1000, 9999) . '_' . $image->getFilename();

            // Upload da imagem
            Storage::disk('public')->putFileAs('fotos', $image, $filename);

            // Cria o desenvolvedor
            Desenvolvedor::create([
                'nome'      => $faker->name,
                'email'     => $faker->unique()->safeEmail,
                'biografia' => $faker->paragraph,
                'foto'      => 'fotos/' . $filename,
            ]);
        }
    }
}
