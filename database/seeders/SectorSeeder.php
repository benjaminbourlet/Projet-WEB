<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder {
    public function run(): void 
    {
        $sectors = [
            'Agriculture',
            'Automobile',
            'Bâtiment et construction',
            'Banque et services financiers',
            'Communication',
            'Édition et impression',
            'Éducation et formation',
            'Environnement',
            'Industrie pharmaceutique',
            'Informatique et technologies',
            'Logistique et transport',
            'Marketing',
            'Santé et services médicaux',
            'Sécurité et défense',
            'Services à la personne',
            'Services juridiques',
            'Tourisme et hôtellerie',
            'Restauration',
            'Immobilier',
            'Services professionnels (consulting, audit)',
            'Arts, culture et divertissement',
            'Sport et loisirs',
            'Biotechnologie',
            'Aéronautique et spatial',
            'Technologies de l\'information',
            'Services de nettoyage et entretien',
            'Équipements électroniques et électroménagers',
            'Services informatiques et logiciels',
        ];
        foreach ($sectors as $sector) {
            Sector::create(['name' => $sector]);
        }
    }
}

// Seeder 5