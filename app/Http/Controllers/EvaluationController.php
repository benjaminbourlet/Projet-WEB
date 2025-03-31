<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class EvaluationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Afficher les évaluations d'une entreprise.
     */
    public function index($companyId)
    {
        $company = Company::findOrFail($companyId);
        $evaluations = $company->evaluations()->withTrashed()->get();

        return response()->json($evaluations);
    }

    public function showEvaluationsCreate($company_id)
    {
        $this->authorize('evaluate_company');
        // Vérifier si l'offre existe, sinon erreur 404
        $company = Company::findOrFail($company_id);

        return view('evaluations.create', compact('company'));
    }

    /**
     * Ajouter une évaluation.
     */
    public function evaluationsCreate(Request $request, $company_id)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'grade' => 'required|numeric|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->evaluations()->attach($request->company_id, [
            'grade' => $request->grade,
            'comment' => $request->comment,
        ]);

        return redirect()->route('company_list')->with('success', 'Avis enregistré avec succès.');
    }

    public function showEvaluationsCompany($company_id)
    {
        $company = Company::with('evaluations')->findOrFail($company_id);
        $evaluations = $company->evaluations()->paginate(10);
    
        return view('evaluations.list', compact('evaluations', 'company'));
    }

    public function showAllEvaluations()
    {
        $evaluations = DB::table('evaluations')
            ->join('companies', 'evaluations.company_id', '=', 'companies.id')
            ->join('users', 'evaluations.user_id', '=', 'users.id')
            ->select(
                'evaluations.grade',
                'evaluations.comment',
                'evaluations.created_at',
                'companies.name as company_name',
                'users.name as user_name'
            )
            ->paginate(10); // Paginer les résultats
    
        return view('evaluations.all', compact('evaluations'));
    }

    /**
     * Supprimer une évaluation (Soft Delete).
     */
    public function remove($userId, $companyId)
    {
        $user = User::findOrFail($userId);
        $user->evaluations()->wherePivot('company_id', $companyId)->detach();

        return response()->json(['message' => 'Évaluation supprimée avec succès']);
    }

}
