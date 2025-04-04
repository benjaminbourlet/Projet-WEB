<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Offer;

class HomeController extends Controller
{
public function homeControl()
    {
        $topCompanies = Company::withCount('offers') // Compte les offres liées à chaque entreprise
            ->orderByDesc('offers_count') // Trie par le plus grand nombre d'offres
            ->take(10) // Garde seulement les 10 premières
            ->get();
    
        // Récupère le nombre total d'étudiants
        $totalStudents = User::role('Etudiant')->count(); // Récupère le nombre total d'étudiants
        $totalCompanies = Company::count(); // Récupère le nombre total d'entreprises
        $totalOffers = Offer::count(); // Récupère le nombre total d'offres

        return view('welcome', compact('topCompanies', 'totalStudents','totalCompanies','totalOffers' ));
    }

}