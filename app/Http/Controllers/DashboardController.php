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
        // Vérification que l'utilisateur connecté est bien celui dont l'ID est passé en paramètre
        if (auth()->id() != $id) {
            abort(403, 'Accès non autorisé.'); // Si ce n'est pas le cas, on retourne une erreur 403 (accès interdit)
        }

        // Nombre total de candidatures de l'utilisateur
        $totalApplications = Application::where('user_id', $id)->count(); 

        // Candidatures acceptées de l'utilisateur via la relation statusable
        $acceptedApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Acceptée'); // Vérifie que le statut de la candidature est "Acceptée"
            })->count(); // Compte le nombre de candidatures acceptées

        // Candidatures refusées de l'utilisateur
        $rejectedApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Refusée'); // Vérifie que le statut de la candidature est "Refusée"
            })->count(); // Compte le nombre de candidatures refusées

        // Candidatures en attente de l'utilisateur
        $pendingApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'En attente'); // Vérifie que le statut de la candidature est "En attente"
            })->count(); // Compte le nombre de candidatures en attente

        // Candidatures en cours de traitement
        $traitementApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'En cours de traitement'); // Vérifie que le statut de la candidature est "En cours de traitement"
            })->count(); // Compte le nombre de candidatures en cours de traitement

        // Candidatures avec entretien programmé
        $interviewApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Entretien programmé'); // Vérifie que le statut de la candidature est "Entretien programmé"
            })->count(); // Compte le nombre de candidatures avec entretien programmé

        // Les compétences les plus demandées pour les offres auxquelles l'utilisateur a postulé
        $topSkills = Skill::select('skills.name', DB::raw('COUNT(offers_skills.skill_id) as count')) 
            ->join('offers_skills', 'skills.id', '=', 'offers_skills.skill_id') // Jointure entre les compétences et les offres
            ->join('offers', 'offers.id', '=', 'offers_skills.offer_id') // Jointure entre les offres et les compétences des offres
            ->join('applications', 'applications.offer_id', '=', 'offers.id') // Jointure entre les candidatures et les offres
            ->where('applications.user_id', $id) // Filtrage pour les candidatures de l'utilisateur spécifique
            ->groupBy('skills.name') // Groupement des résultats par nom de compétence
            ->orderByDesc('count') // Tri par nombre de fois qu'une compétence apparaît, en ordre décroissant
            ->limit(5) // Limite les résultats aux 5 compétences les plus demandées
            ->get(); // Exécution de la requête et récupération des résultats

        // Retourner la vue du tableau de bord avec les données nécessaires
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
