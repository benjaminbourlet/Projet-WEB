<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Sector;

class CompanySectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupération de toutes les entreprises et secteurs
        $companies = Company::all();
        $sectors = Sector::all();

        // Vérification que les secteurs existent
        if ($sectors->isEmpty()) {
            $this->command->warn("Aucun secteur trouvé. Veuillez exécuter le seeder des secteurs d'abord.");
            return;
        }

        // Association aléatoire des secteurs aux entreprises
        foreach ($companies as $company) {
            // Sélection d'un nombre aléatoire de secteurs (1 à 5 par entreprise)
            $randomSectors = $sectors->random(rand(1, 5))->pluck('id');
            
            // Association dans la table pivot
            $company->sectors()->sync($randomSectors);
        }
    }
}