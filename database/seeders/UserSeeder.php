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

        // Création de 20 utilisateurs avec le rôle "Pilote"
        foreach (range(1, 50) as $index) {
            $user = User::create([
                'name' => $faker->lastName,
                'first_name' => $faker->firstName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt("AaBb123._!"), // Mot de passe sécurisé
                'pp_path' => "images/profile_picture.jpg",
                'classe_id' => rand(1, 14),
                'city_id' => rand(1, 60), // Génération aléatoire d'un city_id entre 1 et 14
                'birthdate' => $faker->dateTimeBetween('2000-01-01', '2006-12-31')->format('Y-m-d'),
            ]);

            // Assigner le rôle "Etudiant" à cet utilisateur
            $user->assignRole('Etudiant');
        }

        // Création de 20 utilisateurs avec le rôle "Pilote"
        foreach (range(1, 11) as $index) {
            $user = User::create([
                'name' => $faker->lastName,
                'first_name' => $faker->firstName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt("AaBb123._!"), // Mot de passe sécurisé
                'pp_path' => "images/profile_picture.jpg",
                'city_id' => rand(1, 14), // Génération aléatoire d'un city_id entre 1 et 14
                'birthdate' => $faker->dateTimeBetween('1975-01-01', '1996-12-31')->format('Y-m-d'),
            ]);

            // Assigner le rôle "Etudiant" à cet utilisateur
            $user->assignRole('Pilote');
        }

        foreach (range(1, 1) as $index) {
            $user = User::create([
                'name' => "Da Costa",
                'first_name' => "Argan",
                'email' => "argan.dacosta@stagefinder.com",
                'password' => bcrypt("aBcDEF1223._!!"), // Mot de passe sécurisé
                'pp_path' => "images/profile_picture.jpg",
                'city_id' => 21, // Génération d'un city_id (ici, un exemple statique)
                'birthdate' => '2006-10-04', // Format de date corrigé
            ]);

            // Assigner le rôle "Admin" à cet utilisateur
            $user->assignRole('Admin');
        }
        foreach (range(1, 1) as $index) {
            $user = User::create([
                'name' => "Bourlet",
                'first_name' => "Benjamin",
                'email' => "benjamin.bourlet@stagefinder.com",
                'password' => bcrypt("aBcDEF1223._!!"), // Mot de passe sécurisé
                'pp_path' => "images/profile_picture.jpg",
                'city_id' => 21, // Génération d'un city_id (ici, un exemple statique)
                'birthdate' => '2005-03-07', // Format de date corrigé
            ]);

            // Assigner le rôle "Admin" à cet utilisateur
            $user->assignRole('Admin');
        }
        foreach (range(1, 1) as $index) {
            $user = User::create([
                'name' => "Bortolussi",
                'first_name' => "Diego",
                'email' => "diego.bortolussi@stagefinder.com",
                'password' => bcrypt("aBcDEF1223._!!"), // Mot de passe sécurisé
                'pp_path' => "images/profile_picture.jpg",
                'city_id' => 21, // Génération d'un city_id (ici, un exemple statique)
                'birthdate' => '2005-10-27', // Format de date corrigé
            ]);

            // Assigner le rôle "Admin" à cet utilisateur
            $user->assignRole('Admin');
        }
    }
}
