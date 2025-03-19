<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Department;

class OffersDepartmentSeeder extends Seeder
{
    public function run()
    {
        // Récupération de toutes les offres et départements
        $offers = Offer::all();
        $departments = Department::all();

        // Vérification que les départements existent
        if ($departments->isEmpty()) {
            $this->command->warn("Aucun département trouvé. Veuillez exécuter le seeder des départements d'abord.");
            return;
        }

        // Association aléatoire des départements aux offres
        foreach ($offers as $offer) {
            // Sélection d'un nombre aléatoire de départements (1 par offre)
            $randomDepartments = $departments->random(1)->pluck('id');

            // Association dans la table pivot
            $offer->departments()->sync($randomDepartments);
        }
    }
}
