<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;

class ClassesSeeder extends Seeder 
{
    public function run(): void 
    {
        // Ajout de classes
        $classes = [
        'CPI A1 2024-2025',
        'CPI A2 2024-2025',
        'CPI A3 Informatique 2024-2025',
        'CPI A3 Généraliste 2024-2025',
        'CPI A3 BTP 2024-2025',
        'CPI A3 S3E 2024-2025',
        'CPI A4 Informatique 2024-2025',
        'CPI A4 Généraliste 2024-2025',
        'CPI A4 BTP 2024-2025',
        'CPI A4 S3E 2024-2025',
        'CPI A5 Informatique 2024-2025',
        'CPI A5 Généraliste 2024-2025',
        'CPI A5 BTP 2024-2025',
        'CPI A5 S3E 2024-2025',
        ];
            foreach ($classes as $className) {
                Classe::create(['name' => $className]);
            } 
    }
}

// Seeder 4