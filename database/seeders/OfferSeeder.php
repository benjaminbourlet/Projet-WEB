<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder {
    public function run(): void
    {
        $offers = [
            // 3 premières offres de tests
            ['title' => 'Stage en élevage de lapin des eaux', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio.', 'start_date' => '2025-04-07', 'end_date' => '2025-07-31', 'salary'=>1000, 'company_id'=> 3],
            ['title' => 'Stage en élevage de lapin des montagnes', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio.', 'start_date' => '2025-04-07', 'end_date' => '2025-07-31', 'salary'=>1500, 'company_id'=> 5],
            ['title' => 'Stage en élevage de lapin des plaines', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio. Donec nec nunc nec odio.', 'start_date' => '2025-04-07', 'end_date' => '2025-07-31', 'salary'=>500, 'company_id'=> 1],
        ];

        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}