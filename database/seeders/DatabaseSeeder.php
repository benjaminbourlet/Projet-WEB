<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\City;
use App\Models\Region;
use App\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**x
     * Seed the application's database.
     */
    public function run(): void
    {

        // Ajout de régions
        $regions = [
            'Île-de-France',
            'Provence-Alpes-Côte d\'Azur',
            'Auvergne-Rhône-Alpes',
            'Nouvelle-Aquitaine',
            'Occitanie'
        ];

        foreach ($regions as $region) {
            Region::create(['name' => $region]);
        }

        // Ajout de villes
        $cities = [
            ['name' => 'Paris'],
            ['name' => 'Marseille'],
            ['name' => 'Lyon'],
            ['name' => 'Toulouse'],
            ['name' => 'Bordeaux']
        ];

        foreach ($cities as $city) {
            City::create($city);
        }

        $this->call(PermissionSeeder::class);


    }
}
