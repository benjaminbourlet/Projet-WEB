<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder {
    public function run(): void 
    {
        $departments = [
            'Informatique',
            'Ressources Humaines',
            'Finance',
            'Marketing',
            'Ventes',
            'Support Client',
            'Logistique',
            'Production',
            'Recherche et Développement',
            'Qualité',
            'Juridique',
            'Communication',
            'Achats',
            'Gestion de Projet',
            'Administration',
        ];
        foreach ($departments as $departement) {
            Department::create(['name' => $departement]);
        }
    }
}

// Seeder 6