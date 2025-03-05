<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Postal_Code;
use Illuminate\Support\Facades\DB;

class CitiesPostalsCodesSeeder extends Seeder
{
    public function run()
    {
        // Liste des codes postaux multiples pour certaines villes
        $multi_postal_codes = [
            'Paris' => range(75001, 75020),
            'Marseille' => range(13001, 13016),
            'Toulouse' => range(31100, 31900, 100),
            'Lyon' => range(69001, 69009),
            'Lille' => range(59000, 59800, 100),
        ];

        // Liste des codes postaux uniques par ville
        $cities_postals = [
            'Versailles' => '78000',
            'Boulogne-Billancourt' => '92100',
            'Saint-Denis' => '93200',
            'Montreuil' => '93100',
            'Nice' => '06000',
            'Toulon' => '83000',
            'Aix-en-Provence' => '13100',
            'Antibes' => '06600',
            'Grenoble' => '38000',
            'Saint-Étienne' => '42000',
            'Clermont-Ferrand' => '63000',
            'Annecy' => '74000',
            'Bordeaux' => '33000',
            'Limoges' => '87000',
            'Poitiers' => '86000',
            'La Rochelle' => '17000',
            'Pau' => '64000',
            'Montpellier' => '34000',
            'Nîmes' => '30000',
            'Perpignan' => '66000',
            'Carcassonne' => '11000',
            'Dijon' => '21000',
            'Besançon' => '25000',
            'Chalon-sur-Saône' => '71100',
            'Nevers' => '58000',
            'Montbéliard' => '25200',
            'Strasbourg' => '67000',
            'Reims' => '51100',
            'Nancy' => '54000',
            'Metz' => '57000',
            'Mulhouse' => '68100',
            'Amiens' => '80000',
            'Roubaix' => '59100',
            'Tourcoing' => '59200',
            'Calais' => '62100',
            'Caen' => '14000',
            'Le Havre' => '76600',
            'Rouen' => '76000',
            'Évreux' => '27000',
            'Dieppe' => '76200',
            'Rennes' => '35000',
            'Brest' => '29200',
            'Quimper' => '29000',
            'Vannes' => '56000',
            'Lorient' => '56100',
            'Nantes' => '44000',
            'Angers' => '49000',
            'Le Mans' => '72000',
            'La Roche-sur-Yon' => '85000',
            'Saint-Nazaire' => '44600',
            'Orléans' => '45000',
            'Tours' => '37000',
            'Bourges' => '18000',
            'Châteauroux' => '36000',
            'Blois' => '41000',
        ];

        // Associer chaque ville à ses codes postaux
        foreach (City::all() as $city) {
            $postalCodes = [];

            if (isset($multi_postal_codes[$city->name])) {
                foreach ($multi_postal_codes[$city->name] as $code) {
                    $postal = Postal_Code::firstOrCreate(['num' => strval($code)]);
                    $postalCodes[] = $postal->id;
                }
            } elseif (isset($cities_postals[$city->name])) {
                $postal = Postal_Code::firstOrCreate(['num' => strval($cities_postals[$city->name])]);
                $postalCodes[] = $postal->id;
            }

            if (!empty($postalCodes)) {
                $city->postalCodes()->sync($postalCodes);
            }
        }
    }
}