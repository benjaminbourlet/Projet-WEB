<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Skill;

class OffersSkillSeeder extends Seeder
{
    public function run()
    {
        // Récupération de toutes les offres et compétences
        $offers = Offer::all();
        $skills = Skill::all();

        // Vérification que les compétences existent
        if ($skills->isEmpty()) {
            $this->command->warn("Aucune compétence trouvée. Veuillez exécuter le seeder des compétences d'abord.");
            return;
        }

        // Association aléatoire des compétences aux offres
        foreach ($offers as $offer) {
            // Sélection d'un nombre aléatoire de compétences (1 à 5 par offre)
            $randomSkills = $skills->random(rand(1, 5))->pluck('id');
            
            // Association dans la table pivot
            $offer->skills()->sync($randomSkills);
        }
    }
}