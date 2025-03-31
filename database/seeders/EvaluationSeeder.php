<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Company;
use Faker\Factory as Faker;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Récupération des IDs des utilisateurs et des entreprises
        $userIds = User::pluck('id')->toArray();
        $companyIds = Company::pluck('id')->toArray();

        // Vérification de la présence de données suffisantes
        if (empty($userIds) || empty($companyIds)) {
            $this->command->warn('❌ Pas assez de données en base. Vérifiez les utilisateurs et les entreprises.');
            return;
        }

        // Préparation des données à insérer
        $evaluations = [];
        for ($i = 0; $i < 300; $i++) {
            $userId = $faker->randomElement($userIds);
            $companyId = $faker->randomElement($companyIds);
            $evaluations[] = [
                'user_id' => $userId,
                'company_id' => $companyId,
                'grade' => $faker->numberBetween(1, 5),
                'comment' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertion des données dans la table 'evaluations'
        DB::table('evaluations')->insert($evaluations);
    }
}
