<?php

namespace App\Http\Controllers;

use App\Models\Offer; // Importation du modèle "Offer" pour accéder aux offres dans la base de données.
use App\Models\User; // Importation du modèle "User" pour accéder aux utilisateurs dans la base de données.
use App\Models\Status; // Importation du modèle "Status" pour accéder aux statuts des candidatures.
use Illuminate\Http\Request; // Importation de la classe "Request" pour manipuler les requêtes HTTP.
use Illuminate\Support\Facades\Auth; // Importation de la classe "Auth" pour gérer l'authentification des utilisateurs.
use App\Models\Application; // Importation du modèle "Application" pour gérer les candidatures.
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Importation de la classe "AuthorizesRequests" pour gérer les autorisations.

class ApplicationController extends Controller
{
    use AuthorizesRequests; // On utilise le trait AuthorizesRequests pour faciliter la gestion des autorisations.

    public function showApplicationRegister($offer_id) 
    {
        $this->authorize('apply_for_offer'); // Vérifie si l'utilisateur est autorisé à postuler à une offre.

        $offer = Offer::findOrFail($offer_id); // Vérifie si l'offre existe, sinon renvoie une erreur 404.

        return view('applications.apply', compact('offer')); // Retourne la vue "applications.apply" avec l'offre en paramètre pour afficher le formulaire de candidature.
    }

    public function applicationRegister(Request $request, $offer_id) 
    {
        $user = Auth::user(); // Récupère l'utilisateur actuellement authentifié.
        $this->authorize('apply_for_offer'); // Vérifie si l'utilisateur est autorisé à postuler à l'offre.

        // Vérifie si l'utilisateur a déjà postulé à cette offre en consultant la table "applications".
        $existingApplication = Application::where('user_id', $user->id)
            ->where('offer_id', $offer_id)
            ->first(); // Recherche une candidature existante.

        if ($existingApplication) { // Si une candidature existe déjà.
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre.'); // Redirige l'utilisateur avec un message d'erreur.
        }

        // Validation des fichiers reçus dans la requête (CV et lettre de motivation).
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048', // Le fichier CV doit être requis et de type PDF, DOC, DOCX avec une taille maximale de 2 Mo.
            'cover_letter' => 'nullable|string', // La lettre de motivation est optionnelle et doit être une chaîne de caractères.
        ]);

        // Sauvegarde du CV si un fichier est uploadé
        $cvPath = null; // Initialisation du chemin du CV à null.
        if ($request->hasFile('cv')) { // Si un fichier CV est présent dans la requête.
            $cvPath = $request->file('cv')->store('cv', 'public'); // Enregistre le fichier dans le dossier "cv" du stockage public et obtient le chemin du fichier.
        }

        // Création de la candidature dans la base de données.
        Application::create([
            'user_id' => $user->id, // L'ID de l'utilisateur qui postule.
            'offer_id' => $offer_id, // L'ID de l'offre pour laquelle l'utilisateur postule.
            'cv' => $cvPath, // Le chemin du fichier CV.
            'cover_letter' => $request->cover_letter, // La lettre de motivation (si présente).
            'status_id' => 1, // Le statut de la candidature (1 signifie probablement "en attente").
        ]);

        return redirect()->route('offer_list')->with('success', 'Candidature envoyée avec succès.'); // Redirige vers la liste des offres avec un message de succès.
    }

    public function showApplicationInfo($user_id, $offer_id) 
    {
        $user = User::findOrFail($user_id); // Récupère l'utilisateur avec l'ID fourni. Si l'utilisateur n'est pas trouvé, une erreur 404 est renvoyée.

        // Vérifie si l'utilisateur est admin ou pilote.
        if (!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Pilote')) {
            // Si l'utilisateur n'est pas admin ou pilote, il doit être l'utilisateur connecté.
            if ($user_id != auth()->id()) { // Vérifie si l'ID de l'utilisateur correspond à l'utilisateur connecté.
                return redirect()->route('offer_list')->with('error', 'Vous n\'êtes pas autorisé à voir cette candidature.'); // Redirige avec un message d'erreur si ce n'est pas le cas.
            }
        }

        // Vérifie si une candidature existe pour cet utilisateur et cette offre.
        $application = Application::where('offer_id', $offer_id)
            ->where('user_id', $user_id)
            ->first(); // Recherche la candidature dans la base de données.

        if (!$application) { // Si aucune candidature n'est trouvée.
            return redirect()->route('home')->with('error', 'Aucune candidature trouvée pour cette offre.'); // Redirige avec un message d'erreur.
        }

        return view('applications.info', compact('application', 'user')); // Retourne la vue "applications.info" avec les informations de la candidature et de l'utilisateur.
    }

    public function show($user_id) 
    {
        $user = User::findOrFail($user_id); // Récupère l'utilisateur en fonction de l'ID, renvoie une erreur 404 si l'utilisateur n'est pas trouvé.

        // Vérifie si l'utilisateur est admin ou pilote.
        if (!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Pilote')) {
            // Si l'utilisateur n'est pas admin ou pilote, il doit être l'utilisateur connecté.
            if ($user_id != auth()->id()) { // Vérifie si l'ID de l'utilisateur correspond à l'utilisateur connecté.
                return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à voir les candidatures de cet utilisateur.'); // Redirige avec un message d'erreur si ce n'est pas le cas.
            }
        }

        // Récupère les candidatures de l'utilisateur avec une pagination de 10 résultats par page.
        $applications = $user->applications()->with('offer')->paginate(10); // Récupère les candidatures associées à l'utilisateur et les offres correspondantes.

        return view('applications.list', compact('applications', 'user')); // Retourne la vue "applications.list" avec les candidatures et l'utilisateur.
    }

    public function showApplicationUpdate($user_id, $offer_id) 
    {
        if (!auth()->user()->hasRole('Admin')) { // Si l'utilisateur n'est pas un administrateur.
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à voir les candidatures de cet utilisateur.'); // Redirige avec un message d'erreur.
        }

        // Recherche de la candidature pour un utilisateur et une offre spécifiques.
        $application = Application::where('user_id', $user_id)
            ->where('offer_id', $offer_id)
            ->first(); // Recherche une candidature spécifique.

        if (!$application) { // Si aucune candidature n'est trouvée.
            return redirect()->back()->with('error', 'Candidature introuvable.'); // Redirige avec un message d'erreur.
        }

        $statuses = Status::all(); // Récupère tous les statuts disponibles dans la table "statuses".

        return view('applications.update', compact('application', 'statuses')); // Retourne la vue "applications.update" avec la candidature et les statuts disponibles.
    }

    public function updateApplication(Request $request, $user_id, $offer_id) 
    {
        // Recherche de la candidature spécifique pour un utilisateur et une offre.
        $application = Application::where('user_id', $user_id)
            ->where('offer_id', $offer_id); // Recherche une candidature spécifique.

        // Validation des données envoyées dans la requête.
        $request->validate([
            'status_id' => 'required|exists:statuses,id', // Vérifie que le statut existe dans la base de données.
        ]);
    // Vérifier si la candidature existe
    if (!$application) {
        return redirect()->back()->with('error', 'Candidature introuvable.');
    }

        // Mise à jour du statut de la candidature.
        $application->update([
            'status_id' => $request->status_id, // Mise à jour du statut de la candidature.
        ]);

        return redirect()->route('applications_info', ['user_id' => $user_id, 'offer_id' => $offer_id]) // Redirige vers la page des informations de la candidature avec un message de succès.
            ->with('success', 'Statut de la candidature mis à jour avec succès.');
    }
}
