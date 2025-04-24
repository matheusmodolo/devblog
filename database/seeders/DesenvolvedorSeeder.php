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
        // Assuma que você tenha colocado imagens em database/seeders/imagens/desenvolvedores
        $images = File::files(database_path('seeders/imagens/desenvolvedores'));

        foreach (range(1, 10) as $index) {
            $image = $faker->randomElement($images);
            $filename = time() . '_' . $image->getFilename();
            Storage::disk('public')->putFileAs('fotos', $image, $filename);

            Desenvolvedor::create([
                'nome'      => $faker->name,
                'email'     => $faker->unique()->safeEmail,
                'biografia' => $faker->paragraph,
                'foto'      => 'fotos/' . $filename,
            ]);
        }
    }
}
