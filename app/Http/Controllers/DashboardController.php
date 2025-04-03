<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Inclusion de la classe Request pour gérer les requêtes HTTP
use App\Models\Offer; // Inclusion du modèle Offer pour interagir avec les offres d'emploi
use App\Models\Skill; // Inclusion du modèle Skill pour interagir avec les compétences
use App\Models\Application; // Inclusion du modèle Application pour interagir avec les candidatures
use App\Models\Status; // Inclusion du modèle Status pour interagir avec les statuts des candidatures
use Illuminate\Support\Facades\DB; // Inclusion du facade DB pour effectuer des requêtes SQL complexes

class DashboardController extends Controller
{
    // Méthode dashboard pour afficher les informations sur le tableau de bord de l'utilisateur
    public function dashboard($id)
{
    if (auth()->id() != $id) {
        abort(403, 'Accès non autorisé.');
    }

    // Récupérer toutes les candidatures groupées par statut
    $applicationsByStatus = Application::where('user_id', $id)
        ->selectRaw('status_id, COUNT(*) as count')
        ->groupBy('status_id')
        ->pluck('count', 'status_id');

    // Associer les statuts aux variables correspondantes
    $totalApplications = array_sum($applicationsByStatus->toArray());
    $acceptedApplications = $applicationsByStatus[Status::where('name', 'Acceptée')->value('id')] ?? 0;
    $rejectedApplications = $applicationsByStatus[Status::where('name', 'Refusée')->value('id')] ?? 0;
    $pendingApplications = $applicationsByStatus[Status::where('name', 'En attente')->value('id')] ?? 0;
    $traitementApplications = $applicationsByStatus[Status::where('name', 'En cours de traitement')->value('id')] ?? 0;
    $interviewApplications = $applicationsByStatus[Status::where('name', 'Entretien programmé')->value('id')] ?? 0;

    // Compétences les plus demandées
    $topSkills = Skill::select('skills.name', DB::raw('COUNT(offers_skills.skill_id) as count'))
        ->join('offers_skills', 'skills.id', '=', 'offers_skills.skill_id')
        ->join('offers', 'offers.id', '=', 'offers_skills.offer_id')
        ->join('applications', 'applications.offer_id', '=', 'offers.id')
        ->where('applications.user_id', $id)
        ->groupBy('skills.name')
        ->orderByDesc('count')
        ->limit(5)
        ->get();

    return view('account.dashboard', compact(
        'totalApplications',
        'acceptedApplications',
        'rejectedApplications',
        'pendingApplications',
        'topSkills',
        'traitementApplications',
        'interviewApplications'
    ));
}

}
