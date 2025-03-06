<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Utilisation de Faker pour générer des données aléatoires
        $faker = Faker::create();

        // Création de 30 entreprises
        foreach (range(1, 30) as $index) {
            Company::create([
                'name' => $faker->company,
                'description' => $faker->paragraph,
                'email' => $faker->unique()->companyEmail,
                'logo_path' => 'images/enterprise_picture.png',
                'tel_number' => $faker->numerify('+33#########'),
                'city_id' => rand(1, 60), // Génération aléatoire d'un city_id entre 1 et 60
                'address' => $faker->address,
                'siret' => $faker->numerify('##############'), // Génération d'un SIRET aléatoire
            ]);
        }
    }
}
