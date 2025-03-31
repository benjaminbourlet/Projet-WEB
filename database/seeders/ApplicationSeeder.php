<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Offer;
use App\Models\User;
use App\Models\Status;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Récupération des IDs existants
        $offerIds = Offer::pluck('id')->toArray();
        $statusIds = Status::pluck('id')->toArray();

        // Récupérer uniquement les utilisateurs ayant le rôle "étudiant"
        $studentIds = User::whereHas('roles', function ($query) {
            $query->where('name', 'étudiant');
        })->pluck('id')->toArray();

        // Vérifier que les données existent
        if (empty($offerIds) || empty($studentIds) || empty($statusIds)) {
            $this->command->warn('❌ Pas assez de données en base. Vérifiez les offres, les statuts et les étudiants.');
            return;
        }

        // Stocker les candidatures déjà insérées pour éviter les doublons
        $existingApplications = Application::select('user_id', 'offer_id')->get()->map(function ($app) {
            return $app->user_id . '-' . $app->offer_id;
        })->toArray();

        $applications = [];
        while (count($applications) < 250) {
            $userId = $faker->randomElement($studentIds);
            $offerId = $faker->randomElement($offerIds);
            $key = $userId . '-' . $offerId;

            // Vérifier si cette candidature existe déjà
            if (in_array($key, $existingApplications)) {
                continue; // On saute cette itération et on en génère une nouvelle
            }

            // Ajouter au tableau des candidatures
            $applications[] = [
                'cv' => 'uploads/cvs/' . $faker->uuid . '.pdf', // Simule un fichier CV
                'cover_letter' => $faker->boolean(70) ? $faker->paragraph(5) : null, // 70% de chance d'avoir une lettre de motivation
                'offer_id' => $offerId,
                'user_id' => $userId,
                'status_id' => $faker->randomElement($statusIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Ajouter à la liste des candidatures existantes pour éviter les doublons
            $existingApplications[] = $key;
        }

        // Insérer en masse pour optimiser
        Application::insert($applications);
    }
}
