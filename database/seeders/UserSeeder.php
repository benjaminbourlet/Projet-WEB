<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
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

        // Création de 50 utilisateurs avec le rôle "Etudiant"
        foreach (range(1, 20) as $index) {
            $user = User::create([
                'name' => $faker->lastName,
                'first_name' => $faker->firstName,
                'email' => $faker->unique()->safeEmail,
                'password' => "AaBb123._!", // mot de passe par défaut
                'pp_path' => "images/profile_picture.jpg",
                'region_id' => 5, // Remplace par une région existante
                'city_id' => 4,   // Remplace par une ville existante
            ]);

            // Assigner le rôle "Etudiant" à cet utilisateur
            $user->assignRole('Pilote');
        }
    }
}
