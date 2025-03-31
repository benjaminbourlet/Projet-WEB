<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Company;
use Faker\Factory as Faker;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Récupération des ID des entreprises existantes
        $companyIds = Company::pluck('id')->toArray();

        // Création de 50 offres aléatoires
        foreach (range(1, 115) as $index) {
            Offer::create([
                'title' => $faker->jobTitle,
                'description' => $faker->paragraph,
                'start_date' => $startDate = $faker->dateTimeBetween('now', '+1 month'),
                'end_date' => $faker->dateTimeBetween($startDate->format('Y-m-d') . ' +1 month', $startDate->format('Y-m-d') . ' +6 months'),
                'salary' => $faker->numberBetween(600, 2500),
                'company_id' => $faker->randomElement($companyIds),
            ]);
        }
    }
}
