<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Offer;
use App\Models\User;
use Faker\Factory as Faker;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Récupération des IDs des offres et des utilisateurs ayant le rôle 'étudiant'
        $offerIds = Offer::pluck('id')->toArray();
        $studentUserIds = User::role('étudiant')->pluck('id')->toArray();

        // Vérification de la présence de données suffisantes
        if (empty($offerIds) || empty($studentUserIds)) {
            $this->command->warn('❌ Pas assez de données en base. Vérifiez les offres et les utilisateurs avec le rôle "étudiant".');
            return;
        }

        // Préparation des données à insérer
        $wishlists = [];
        foreach ($studentUserIds as $userId) {
            $userOffers = (array) $faker->randomElements($offerIds, rand(1, 20), false);
            foreach ($userOffers as $offerId) {
                $wishlists[] = [
                    'user_id' => $userId,
                    'offer_id' => $offerId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insertion des données dans la table pivot 'wishlists'
        DB::table('wishlists')->insert($wishlists);
    }
}