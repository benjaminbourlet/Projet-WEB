<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $offers = [
            // 3 premières offres de tests
            ['title' => 'Stage en élevage de lapin des eaux', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio.', 'start_date' => '2025-04-07', 'end_date' => '2025-07-31', 'salary' => 1000, 'company_id' => 3],
            ['title' => 'Stage en élevage de lapin des montagnes', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio.', 'start_date' => '2025-04-07', 'end_date' => '2025-07-31', 'salary' => 1500, 'company_id' => 5],
            ['title' => 'Stage en élevage de lapin des plaines', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio.', 'start_date' => '2025-04-07', 'end_date' => '2025-07-31', 'salary' => 500, 'company_id' => 1],
        ];
        $locations = ['forêt', 'marais', 'prairie', 'montagne', 'caverne', 'ferme', 'village', 'rivière', 'lac', 'plaine'];
        $company_ids = range(1, 10);
        $salaries = [500, 1000, 1500, 2000, 2500];

        for ($i = 4; $i <= 100; $i++) {
            $title = "Stage en élevage de lapin " . $locations[array_rand($locations)];
            $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut nunc nec odio.";
            $start_date = '2025-04-07';
            $end_date = '2025-07-31';
            $salary = $salaries[array_rand($salaries)];
            $company_id = $company_ids[array_rand($company_ids)];

            $offers[] = [
                'title' => $title,
                'description' => $description,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'salary' => $salary,
                'company_id' => $company_id,
            ];
        }

        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}
