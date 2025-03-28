<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApplicationController extends Controller
{
    use AuthorizesRequests;
    public function showApplicationRegister($offer_id)
    {
        $this->authorize('apply_for_offer');
        // Vérifier si l'offre existe, sinon erreur 404
        $offer = Offer::findOrFail($offer_id);

        return view('applications.apply', compact('offer'));
    }
    public function applicationRegister(Request $request, $offer_id)
    {
        $user = Auth::user();
        $this->authorize('apply_for_offer');

        // Vérifier si l'utilisateur a déjà postulé
        $existingApplication = Application::where('user_id', $user->id)
            ->where('offer_id', $offer_id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        // Validation des fichiers
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        // Sauvegarde du CV si un fichier est uploadé
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public');
        }

        // Création de la candidature
        Application::create([
            'user_id' => $user->id,
            'offer_id' => $offer_id,
            'cv' => $cvPath,
            'cover_letter' => $request->cover_letter,
            'status_id' => 1, // Statut par défaut
        ]);

        return redirect()->route('offer_list')->with('success', 'Candidature envoyée avec succès.');
    }

    public function showApplicationInfo($user_id, $offer_id)
    {
        $user = User::findOrFail($user_id);

        // Vérifier si l'utilisateur est admin ou pilote
        if (!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Pilote')) {
            // Si l'utilisateur n'est pas admin ou pilote, il doit être l'utilisateur connecté
            if ($user_id != auth()->id()) {
                return redirect()->route('offer_list')->with('error', 'Vous n\'êtes pas autorisé à voir cette candidature.');
            }
        }

        // Vérifier si l'utilisateur a une candidature pour cette offre
        $application = Application::where('offer_id', $offer_id)
            ->where('user_id', $user_id)
            ->first();

        // Vérifier si une candidature existe
        if (!$application) {
            return redirect()->route('home  ')->with('error', 'Aucune candidature trouvée pour cette offre.');
        }

        return view('applications.info', compact('application', 'user'));
    }

    public function show($user_id)
    {
        $user = User::findOrFail($user_id);

        // Vérifier si l'utilisateur est admin ou pilote
        if (!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Pilote')) {
            // Si l'utilisateur n'est pas admin ou pilote, il doit être l'utilisateur connecté
            if ($user_id != auth()->id()) {
                return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à voir les candidatures de cet utilisateur.');
            }
        }

        // Récupérer les candidatures de l'utilisateur avec pagination
        $applications = $user->applications()->with('offer')->paginate(10);

        return view('applications.list', compact('applications', 'user'));
    }

    public function showApplicationUpdate($user_id, $offer_id)
    {
        if (!auth()->user()->hasRole('Admin')) {
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à voir les candidatures de cet utilisateur.');
        }

        // Recherche spécifique à l'utilisateur et à l'offre
        $application = Application::where('user_id', $user_id)
            ->where('offer_id', $offer_id)
            ->first();

        // Vérification que la candidature existe
        if (!$application) {
            return redirect()->back()->with('error', 'Candidature introuvable.');
        }

        $statuses = Status::all();

        return view('applications.update', compact('application', 'statuses'));
    }

    public function updateApplication(Request $request, $user_id, $offer_id)
    {
        // Vérifier que la requête récupère bien UNE SEULE candidature
        $application = Application::where('user_id', $user_id)
            ->where('offer_id', $offer_id);

        // Vérification des données envoyées
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        // Mise à jour du statut de la candidature spécifique
        $application->update([
            'status_id' => $request->status_id,
        ]);

        return redirect()->route('applications_info', ['user_id' => $user_id, 'offer_id' => $offer_id])
            ->with('success', 'Statut de la candidature mis à jour avec succès.');
    }

}