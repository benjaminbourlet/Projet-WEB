<?php

// Importation des namespaces nécessaires pour le fonctionnement du contrôleur
namespace App\Http\Controllers;

// Importation des classes utilisées dans le contrôleur
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use App\Models\City;
use App\Models\Sector;
use App\Models\Skill;
use App\Models\Offer;
use App\Models\Region;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

// Déclaration de la classe CompanyController qui gère les actions liées aux entreprises
class CompanyController extends Controller
{
    // Utilisation du trait AuthorizesRequests pour gérer les autorisations
    use AuthorizesRequests;

    // Méthode pour afficher la liste des entreprises avec pagination et filtres
    public function show()
    {
        // Vérifie si l'utilisateur a l'autorisation de rechercher des entreprises
        $this->authorize('search_company');

        // Récupère les entreprises, villes, secteurs et régions pour les afficher
        $companies = Company::paginate(9);
        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $regions = Region::orderBy('name', 'asc')->get();

        // Retourne la vue avec les données compactées
        return view('companies.list', compact('companies', 'sectors', 'cities', 'regions'));
    }

    // Méthode pour afficher le formulaire de création d'une entreprise
    public function showCompanyRegister()
    {
        // Récupère les villes et secteurs pour le formulaire
        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();

        // Vérifie si l'utilisateur a l'autorisation de créer une entreprise
        $this->authorize('create_company');

        // Retourne la vue avec les données compactées
        return view('companies.create', compact('cities', 'sectors'));
    }

    // Méthode pour enregistrer une nouvelle entreprise
    public function companyRegister(Request $request)
    {
        // Vérifie si l'utilisateur a l'autorisation de créer une entreprise
        $this->authorize('create_company');

        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|string|max:50|unique:companies',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:companies|max:50',
            'tel_number' => [
                'nullable',
                'string',
                'max:50',
                'unique:companies',
                'regex:/^(?:\+33|0)[1-9](?:\d{2}){4}$/',
            ],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'siret' => 'required|string|size:14|unique:companies,siret',
            'sectors' => 'nullable|array',
            'sectors.*' => 'exists:sectors,id',
        ], [
            // Messages personnalisés pour les erreurs de validation
            'name.required' => 'Le nom de l\'entreprise est obligatoire.',
            'name.max' => 'Le nom de l\'entreprise ne peut pas dépasser 50 caractères.',
            'name.unique' => 'Ce nom d\'entreprise est déjà utilisé.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé par une autre entreprise.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 50 caractères.',

            'tel_number.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'tel_number.regex' => 'Le numéro de téléphone doit être valide et au format français.',

            'logo.image' => 'Le fichier doit être une image.',
            'logo.mimes' => 'Les formats acceptés sont : jpeg, png, jpg, gif.',
            'logo.max' => 'L\'image ne doit pas dépasser 2 Mo.',

            'siret.required' => 'Le numéro SIRET est obligatoire.',
            'siret.size' => 'Le numéro SIRET doit contenir exactement 14 caractères.',
            'siret.unique' => 'Ce numéro SIRET est déjà utilisé.',

            'city_id.required' => 'La ville est obligatoire.',
            'city_id.exists' => 'La ville sélectionnée n\'existe pas.',

            'address.required' => 'L\'adresse est obligatoire.',

            'sectors.*.exists' => 'L\'un des secteurs sélectionnés n\'existe pas.'
        ]);

        // Gestion de l'upload du logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('images', 'public');
        } else {
            $logoPath = 'images/enterprise_picture.png';
        }

        // Création de l'entreprise avec les données validées
        $company = Company::create([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'tel_number' => $request->tel_number,
            'logo_path' => $logoPath,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'siret' => $request->siret,
        ]);

        // Association des secteurs à l'entreprise si sélectionnés
        if ($request->has('sectors')) {
            $company->sectors()->attach($request->sectors);
        }

        // Redirection avec un message de succès
        return redirect()->route('company_list')->with('success', 'Entreprise créée avec succès');
    }

    // Méthode pour afficher les informations détaillées d'une entreprise
    public function showCompanyInfo($id)
    {
        $company = Company::findOrFail($id);
        $cities = City::all();

        // Récupération des 5 compétences les plus demandées
        $topSkills = Skill::select('skills.name')
            ->join('offers_skills', 'skills.id', '=', 'offers_skills.skill_id')
            ->join('offers', 'offers_skills.offer_id', '=', 'offers.id')
            ->where('offers.company_id', $id)
            ->groupBy('skills.name')
            ->orderByDesc(DB::raw('COUNT(skills.id)'))
            ->limit(5)
            ->pluck('skills.name')
            ->toArray();

        // Calcul du salaire moyen des offres
        $averageSalary = round(Offer::where('company_id', $id)
            ->whereNotNull('salary')
            ->avg('salary') ?? 0);

        // Calcul de la durée moyenne des offres en jours
        $averageDuration = round(Offer::where('company_id', $id)
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->selectRaw('AVG(DATEDIFF(end_date, start_date)) as avg_duration')
            ->value('avg_duration') ?? 0);

        // Nombre total de candidatures pour les offres de l'entreprise
        $applicationsCount = Application::whereHas('offer', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->count();

        // Retourne la vue avec les données compactées
        return view('companies.info', compact('company', 'cities', 'topSkills', 'averageSalary', 'averageDuration', 'applicationsCount'));
    }

    // Méthode pour afficher le formulaire de mise à jour d'une entreprise
    public function showCompanyUpdate($id)
    {
        // Vérifie si l'utilisateur a l'autorisation de modifier une entreprise
        $this->authorize('edit_company');

        // Récupère l'entreprise, les villes et les secteurs pour le formulaire
        $company = Company::findOrFail($id);
        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();

        // Retourne la vue avec les données compactées
        return view('companies.update', compact('company', 'cities', 'sectors'));
    }

    // Méthode pour mettre à jour les informations d'une entreprise
    public function updateCompany(Request $request, $id)
    {
        // Récupère l'entreprise à mettre à jour
        $company = Company::findOrFail($id);

        // Vérifie si l'utilisateur a l'autorisation de modifier une entreprise
        $this->authorize('edit_company');

        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|string|max:50|unique:companies,name,' . $company->id,
            'description' => 'nullable|string',
            'email' => 'required|email|max:50|unique:companies,email,' . $company->id,
            'tel_number' => [
                'nullable',
                'string',
                'max:50',
                'unique:companies,tel_number,' . $company->id,
                'regex:/^(?:\+33|0)[1-9](?:\d{2}){4}$/',
            ],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'siret' => [
                'required',
                'string',
                'size:14',
                Rule::unique('companies', 'siret')->ignore($company->id),
            ],
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'sectors' => 'nullable|array',
            'sectors.*' => 'exists:sectors,id',
        ], [
            // Messages personnalisés pour les erreurs de validation
            'name.required' => 'Le nom de l\'entreprise est obligatoire.',
            'name.max' => 'Le nom de l\'entreprise ne peut pas dépasser 50 caractères.',
            'name.unique' => 'Ce nom d\'entreprise est déjà utilisé.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé par une autre entreprise.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 50 caractères.',

            'tel_number.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'tel_number.regex' => 'Le numéro de téléphone doit être valide et au format français.',

            'logo.image' => 'Le fichier doit être une image.',
            'logo.mimes' => 'Les formats acceptés sont : jpeg, png, jpg, gif.',
            'logo.max' => 'L\'image ne doit pas dépasser 2 Mo.',

            'siret.required' => 'Le numéro SIRET est obligatoire.',
            'siret.size' => 'Le numéro SIRET doit contenir exactement 14 caractères.',
            'siret.unique' => 'Ce numéro SIRET est déjà utilisé.',

            'city_id.required' => 'La ville est obligatoire.',
            'city_id.exists' => 'La ville sélectionnée n\'existe pas.',

            'address.required' => 'L\'adresse est obligatoire.',

            'sectors.*.exists' => 'L\'un des secteurs sélectionnés n\'existe pas.'
        ]);

        // Gestion de l'upload du logo
        if ($request->hasFile('logo')) {
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }
            $company->logo_path = $request->file('logo')->store('images', 'public');
        }

        // Mise à jour des informations de l'entreprise
        $company->update([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'tel_number' => $request->tel_number,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'siret' => $request->siret,
        ]);

        // Mise à jour des secteurs associés
        if ($request->has('sectors')) {
            $company->sectors()->sync($request->sectors);
        } else {
            $company->sectors()->detach();
        }

        // Redirection avec un message de succès
        return redirect()->route('company_list')->with('success', 'Entreprise mise à jour avec succès');
    }

    // Méthode pour supprimer une entreprise
    public function deleteCompany($id)
    {
        // Vérifie si l'utilisateur a l'autorisation de supprimer une entreprise
        $this->authorize('delete_company');

        // Récupère l'entreprise à supprimer
        $company = Company::findOrFail($id);

        // Supprime les candidatures et souhaits associés aux offres de l'entreprise
        foreach ($company->offers as $offer) {
            DB::table('applications')
                ->where('offer_id', $offer->id)
                ->update(['deleted_at' => now()]);
            $offer->users()->detach();
        }

        // Supprime les offres associées à l'entreprise
        $company->offers()->delete();

        // Supprime les évaluations associées à l'entreprise
        $company->evaluations()->detach();

        // Suppression douce de l'entreprise
        $company->delete();

        // Redirection avec un message de succès
        return redirect()->route('company_list')->with('success', 'Entreprise supprimée avec succès');
    }

    // Méthode pour filtrer les entreprises par secteur
    private function getCompanyBySectorId($query, $request)
    {
        if ($request->filled('sector')) {
            $sectors = explode(',', $request->sector);
            foreach ($sectors as $sectorId) {
                $query->whereHas('sectors', function ($q) use ($sectorId) {
                    $q->where('sectors.id', $sectorId);
                });
            }
        }
        return $query;
    }

    // Méthode pour filtrer les entreprises par ville
    private function getCompanyByCityId($query, $request)
    {
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        return $query;
    }

    // Méthode pour appliquer un filtre par région
    protected function applyRegionFilter($query, Request $request)
    {
        if ($request->filled('region')) {
            $query->whereHas('city.region', function ($q) use ($request) {
                $q->where('id', $request->region);
            });
        }
        return $query;
    }

    // Méthode pour rechercher les entreprises par nom
    private function getCompanyByName($query, $request)
    {
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }
        return $query;
    }

    // Méthode pour trier les résultats des entreprises
    private function sortCompanyResults($query, $request)
    {
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'date_recent':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'date_old':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        }
        return $query;
    }

    // Méthode pour rechercher les entreprises avec filtres et tri
    public function search(Request $request)
    {
        $query = Company::query();

        // Application des filtres
        $query = $this->getCompanyByName($query, $request);
        $query = $this->getCompanyBySectorId($query, $request);
        $query = $this->getCompanyByCityId($query, $request);
        $query = $this->applyRegionFilter($query, $request);

        // Application du tri
        $query = $this->sortCompanyResults($query, $request);

        // Récupération des entreprises avec pagination
        $companies = $query->paginate(9);

        // Récupération des données pour les filtres
        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $regions = Region::orderBy('name', 'asc')->get();

        // Retourne la vue avec les données compactées
        return view('companies.list', compact('companies', 'sectors', 'cities', 'regions'));
    }

    // Méthode pour afficher les offres d'une entreprise
    public function showOffers($company_id)
    {
        // Récupère l'entreprise et ses offres
        $company = Company::findOrFail($company_id);
        $offers = $company->offers()->paginate(10);

        // Retourne la vue avec les données compactées
        return view('companies.offers', compact('offers', 'company'));
    }
}