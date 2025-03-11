<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesSeeder extends Seeder 
{
    public function run(): void 
    {
        // Ajout de status
        $statuses = [
            'En attente',
            'En cours de traitement',
            'Entretien programmé',
            'Acceptée',
            'Refusée',
        ];
        foreach ($statuses as $status) {
            Status::create(['name' => $status]);
        }
    }
}

// Seeder 8