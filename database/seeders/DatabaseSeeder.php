<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\City;
use App\Models\Region;
use App\Models\Classe;
use App\Models\Sector;
use App\Models\Postal_Code;


class DatabaseSeeder extends Seeder
{
    /** 
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ajout de régions
        $regions = [
            'Île-de-France',
            'Provence-Alpes-Côte d\'Azur',
            'Auvergne-Rhône-Alpes',
            'Nouvelle-Aquitaine',
            'Occitanie',
            'Bourgogne-Franche-Feature',
            'Grand-Est',
            'Hauts-de-France',
            'Normandie',
            'Bretagne',
            'Pays de la Loire',
            'Centre-Val de Loire'
        ];

        foreach ($regions as $region) {
            Region::create(['name' => $region]);
        }

        // Ajout de villes
        $cities = [
            // Île-de-France
            ['name' => 'Paris', 'region_id' => 1],
            ['name' => 'Versailles', 'region_id' => 1],
            ['name' => 'Boulogne-Billancourt', 'region_id' => 1],
            ['name' => 'Saint-Denis', 'region_id' => 1],
            ['name' => 'Montreuil', 'region_id' => 1],

            // Provence-Alpes-Côte d'Azur
            ['name' => 'Marseille', 'region_id' => 2],
            ['name' => 'Nice', 'region_id' => 2],
            ['name' => 'Toulon', 'region_id' => 2],
            ['name' => 'Aix-en-Provence', 'region_id' => 2],
            ['name' => 'Antibes', 'region_id' => 2],

            // Auvergne-Rhône-Alpes
            ['name' => 'Lyon', 'region_id' => 3],
            ['name' => 'Grenoble', 'region_id' => 3],
            ['name' => 'Saint-Étienne', 'region_id' => 3],
            ['name' => 'Clermont-Ferrand', 'region_id' => 3],
            ['name' => 'Annecy', 'region_id' => 3],

            // Nouvelle-Aquitaine
            ['name' => 'Bordeaux', 'region_id' => 4],
            ['name' => 'Limoges', 'region_id' => 4],
            ['name' => 'Poitiers', 'region_id' => 4],
            ['name' => 'La Rochelle', 'region_id' => 4],
            ['name' => 'Pau', 'region_id' => 4],

            // Occitanie
            ['name' => 'Toulouse', 'region_id' => 5],
            ['name' => 'Montpellier', 'region_id' => 5],
            ['name' => 'Nîmes', 'region_id' => 5],
            ['name' => 'Perpignan', 'region_id' => 5],
            ['name' => 'Carcassonne', 'region_id' => 5],

            // Bourgogne-Franche-Comté
            ['name' => 'Dijon', 'region_id' => 6],
            ['name' => 'Besançon', 'region_id' => 6],
            ['name' => 'Chalon-sur-Saône', 'region_id' => 6],
            ['name' => 'Nevers', 'region_id' => 6],
            ['name' => 'Montbéliard', 'region_id' => 6],

            // Grand-Est
            ['name' => 'Strasbourg', 'region_id' => 7],
            ['name' => 'Reims', 'region_id' => 7],
            ['name' => 'Nancy', 'region_id' => 7],
            ['name' => 'Metz', 'region_id' => 7],
            ['name' => 'Mulhouse', 'region_id' => 7],

            // Hauts-de-France
            ['name' => 'Lille', 'region_id' => 8],
            ['name' => 'Amiens', 'region_id' => 8],
            ['name' => 'Roubaix', 'region_id' => 8],
            ['name' => 'Tourcoing', 'region_id' => 8],
            ['name' => 'Calais', 'region_id' => 8],

            // Normandie
            ['name' => 'Caen', 'region_id' => 9],
            ['name' => 'Le Havre', 'region_id' => 9],
            ['name' => 'Rouen', 'region_id' => 9],
            ['name' => 'Évreux', 'region_id' => 9],
            ['name' => 'Dieppe', 'region_id' => 9],

            // Bretagne
            ['name' => 'Rennes', 'region_id' => 10],
            ['name' => 'Brest', 'region_id' => 10],
            ['name' => 'Quimper', 'region_id' => 10],
            ['name' => 'Vannes', 'region_id' => 10],
            ['name' => 'Lorient', 'region_id' => 10],

            // Pays de la Loire
            ['name' => 'Nantes', 'region_id' => 11],
            ['name' => 'Angers', 'region_id' => 11],
            ['name' => 'Le Mans', 'region_id' => 11],
            ['name' => 'La Roche-sur-Yon', 'region_id' => 11],
            ['name' => 'Saint-Nazaire', 'region_id' => 11],

            // Centre-Val de Loire
            ['name' => 'Orléans', 'region_id' => 12],
            ['name' => 'Tours', 'region_id' => 12],
            ['name' => 'Bourges', 'region_id' => 12],
            ['name' => 'Châteauroux', 'region_id' => 12],
            ['name' => 'Blois', 'region_id' => 12],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
/*

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

*/

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

        $sectors = [
            'Agriculture',
            'Automobile',
            'Bâtiment et construction',
            'Banque et services financiers',
            'Commerce de détail',
            'Communication et médias',
            'Édition et impression',
            'Énergie et ressources naturelles',
            'Éducation et formation',
            'Environnement',
            'Industrie pharmaceutique',
            'Informatique et technologies',
            'Investissement et capital-risque',
            'Logistique et transport',
            'Marketing et publicité',
            'Mode et textile',
            'Santé et services médicaux',
            'Sécurité et défense',
            'Services à la personne',
            'Services juridiques',
            'Télécommunications',
            'Tourisme et hôtellerie',
            'Restauration',
            'Immobilier',
            'Services professionnels (consulting, audit)',
            'Arts, culture et divertissement',
            'Sport et loisirs',
            'Biotechnologie',
            'Mines et métallurgie',
            'Aéronautique et spatial',
            'Technologies de l\'information',
            'Services de nettoyage et entretien',
            'Équipements électroniques et électroménagers',
            'Services informatiques et logiciels',
        ];
        
        foreach ($sectors as $sector) {
            Sector::create(['name' => $sector]);
        }
        


        // Appel du seeder pour les permissions
        $this->call(PermissionSeeder::class);



    }
}
