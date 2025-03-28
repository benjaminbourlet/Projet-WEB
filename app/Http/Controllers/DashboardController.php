<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Skill;
use App\Models\Application;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard($id)
    {
        // Vérifier que l'utilisateur connecté correspond bien à l'ID donné
        if (auth()->id() != $id) {
            abort(403, 'Accès non autorisé.');
        }

        // Nombre total de candidatures de l'utilisateur
        $totalApplications = Application::where('user_id', $id)->count();

        // Candidatures acceptées, refusées et en attente de l'utilisateur via la relation statusable
        $acceptedApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Acceptée');
            })->count();

        $rejectedApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Refusée');
            })->count();

        $pendingApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'En attente');
            })->count();

        $traitementApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'En cours de traitement');
            })->count();

        $interviewApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Entretien programmé');
            })->count();

        // Les compétences les plus demandées pour les offres auxquelles l'utilisateur a postulé
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
            'topSkills','traitementApplications','interviewApplications'
        ));
    }
}
