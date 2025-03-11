<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Postal_Code;

class PostalsCodesSeeder extends Seeder
{
    public function run(): void 
   {
    $postals_codes = [
        '75000',
        '78000',
        '92000',
        '92100',
        '93000',
        '93200',
        '93100',
        '13000',
        '06000',
        '83000',
        '13100',
        '06600',
        '69000',
        '38000',
        '42000',
        '63000',
        '74000',
        '33000',
        '87000',
        '86000',
        '17000',
        '64000',
        '31000',
        '34000',
        '30000',
        '66000',
        '11000',
        '21000',
        '25000',
        '71100',
        '58000',
        '25200',
        '67000',
        '51100',
        '54000',
        '57000',
        '68100',
        '59000',
        '80000',
        '59100',
        '59200',
        '62100',
        '14000',
        '76600',
        '76000',
        '27000',
        '76200',
        '35000',
        '29200',
        '29000',
        '56000',
        '56100',
        '44000',
        '49000',
        '72000',
        '85000',
        '44600',
        '45000',
        '37000',
        '18000',
        '36000',
        '41000',
    ];

    // Génération automatique des codes postaux pour les villes ayant plusieurs codes
    $multi_postals_codes = [
        '75' => range(75001, 75020), // Paris (75001 à 75020)
        '13' => range(13001, 13016), // Marseille (13001 à 13016)
        '31' => range(31100, 31900, 100), // Toulouse (31100 à 31900)
        '69' => range(69001, 69009), // Lyon (69001 à 69009)
        '59' => range(59300, 59800, 100), // Lille et Nord (59000, 59100, ..., 59800)
        '92' => range(92200, 92130, 10), // Hauts-de-Seine
        '94' => range(94000, 94170, 10), // Val-de-Marne
        '91' => range(91000, 91980, 10), // Essonne
    ];

    foreach ($multi_postals_codes as $ranges) {
        foreach ($ranges as $postal_code) {
            $postals_codes[] = strval($postal_code);
        }
    }

    // Tri des codes pour l'organisation
    sort($postals_codes);

    // Insertion en base de données
    foreach ($postals_codes as $postal_code) {
        Postal_Code::create(['num' => $postal_code]);
    }
   } 
}

// Seeder 3 en théorie (encore en commentaire dans le code DatabaseSeeder.php)