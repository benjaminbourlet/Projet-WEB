<?php

namespace App\Http\Controllers;

use App\Models\User; // Inclusion du modèle User pour interagir avec les utilisateurs
use App\Models\Company; // Inclusion du modèle Company pour interagir avec les entreprises
use Illuminate\Http\Request; // Inclusion de la classe Request pour gérer les requêtes HTTP
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Inclusion pour l'autorisation d'accès (policy)
use Illuminate\Support\Facades\Auth; // Inclusion de la façade Auth pour gérer l'authentification de l'utilisateur
use Illuminate\Support\Facades\DB; // Inclusion de la façade DB pour effectuer des requêtes SQL complexes

class EvaluationController extends Controller
{
    use AuthorizesRequests; // Utilisation du trait AuthorizesRequests pour l'autorisation des actions
    
    /**
     * Afficher les évaluations d'une entreprise.
     */
    public function index($companyId)
    {
        $company = Company::findOrFail($companyId); // Recherche de l'entreprise par son ID
        $evaluations = $company->evaluations()->withTrashed()->get(); // Récupère toutes les évaluations de l'entreprise, y compris celles supprimées

        return response()->json($evaluations); // Retourne les évaluations sous forme de réponse JSON
    }

    // Afficher la vue de création d'évaluation pour une entreprise
    public function showEvaluationsCreate($company_id)
    {
        $this->authorize('evaluate_company'); // Vérifie si l'utilisateur est autorisé à évaluer l'entreprise

        $company = Company::findOrFail($company_id); // Recherche de l'entreprise par son ID

        return view('evaluations.create', compact('company')); // Retourne la vue pour la création de l'évaluation avec l'entreprise
    }

    /**
     * Ajouter une évaluation.
     */
    public function evaluationsCreate(Request $request, $company_id)
    {
        // Validation des données envoyées par la requête
        $request->validate([
            'user_id' => 'required|exists:users,id', // Vérifie que l'ID de l'utilisateur existe dans la table users
            'company_id' => 'required|exists:companies,id', // Vérifie que l'ID de l'entreprise existe dans la table companies
            'grade' => 'required|numeric|between:1,5', // Vérifie que la note (grade) est un nombre entre 1 et 5
            'comment' => 'nullable|string', // Le commentaire est facultatif et doit être une chaîne de caractères
        ]);

        $user = Auth::user(); // Récupère l'utilisateur connecté
        $user->evaluations()->attach($request->company_id, [ // Attache une évaluation à l'entreprise
            'grade' => $request->grade, // Ajoute la note
            'comment' => $request->comment, // Ajoute le commentaire
        ]);

        return redirect()->route('company_list')->with('success', 'Avis enregistré avec succès.'); // Redirige vers la liste des entreprises avec un message de succès
    }

    // Afficher les évaluations d'une entreprise spécifique
    public function showEvaluationsCompany($company_id)
    {
        $company = Company::with('evaluations')->findOrFail($company_id); // Recherche l'entreprise avec ses évaluations
        $evaluations = $company->evaluations()->paginate(10); // Récupère les évaluations paginées de l'entreprise

        return view('evaluations.list', compact('evaluations', 'company')); // Retourne la vue des évaluations de l'entreprise
    }

    // Afficher toutes les évaluations des entreprises
    public function showAllEvaluations()
    {
        $evaluations = DB::table('evaluations') // Requête SQL sur la table evaluations
            ->join('companies', 'evaluations.company_id', '=', 'companies.id') // Jointure avec la table companies
            ->join('users', 'evaluations.user_id', '=', 'users.id') // Jointure avec la table users
            ->select( // Sélectionne les colonnes spécifiques
                'evaluations.grade',
                'evaluations.comment',
                'evaluations.created_at',
                'companies.name as company_name',
                'companies.id as company_id',
                'users.name as user_name',
                'users.first_name as user_first_name',
            )
            ->paginate(10); // Paginera les résultats par 10 éléments par page

        return view('evaluations.all', compact('evaluations')); // Retourne la vue avec toutes les évaluations
    }

    /**
     * Supprimer une évaluation (Soft Delete).
     */
    public function remove($userId, $companyId)
    {
        $user = User::findOrFail($userId); // Recherche de l'utilisateur par son ID
        $user->evaluations()->wherePivot('company_id', $companyId)->detach(); // Supprime l'évaluation de l'entreprise pour cet utilisateur

        return response()->json(['message' => 'Évaluation supprimée avec succès']); // Retourne une réponse JSON avec un message de succès
    }

}
