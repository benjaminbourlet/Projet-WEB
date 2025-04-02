<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use App\Models\City;
use App\Models\Sector;
use App\Models\Skill;
use App\Models\Offer;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function show()
    {
        $this->authorize('search_company');
        $companies = Company::paginate(9);
        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();
        return view('companies.list', compact('companies', 'sectors', 'cities'));
    }

    public function showCompanyRegister()
    {
        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $this->authorize('create_company');
        return view('companies.create', compact('cities', 'sectors'));
    }

    public function companyRegister(Request $request)
    {
        $this->authorize('create_company');

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
            'sectors' => 'nullable|array', // Ajouter la validation pour le tableau des secteurs
            'sectors.*' => 'exists:sectors,id', // Vérifier que chaque secteur existe dans la table 'sectors'
        ]);

        // Gestion de l'upload du logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('images', 'public');
        } else {
            $logoPath = 'images/enterprise_picture.png';
        }

        // Création de l'entreprise
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

        // Si des secteurs sont sélectionnés, les associer à l'entreprise
        if ($request->has('sectors')) {
            $company->sectors()->attach($request->sectors);
        }

        return redirect()->route('company_list')->with('success', 'Entreprise créée avec succès');
    }

    public function showCompanyInfo($id)
    {
        $company = Company::findOrFail($id);
        $cities = City::all();

        // Récupérer les 5 compétences les plus demandées
        $topSkills = Skill::select('skills.name')
            ->join('offers_skills', 'skills.id', '=', 'offers_skills.skill_id')
            ->join('offers', 'offers_skills.offer_id', '=', 'offers.id')
            ->where('offers.company_id', $id)
            ->groupBy('skills.name')
            ->orderByDesc(\DB::raw('COUNT(skills.id)'))
            ->limit(5)
            ->pluck('skills.name')
            ->toArray();

        // Calculer le salaire moyen des offres
        $averageSalary = round(Offer::where('company_id', $id)
            ->whereNotNull('salary')
            ->avg('salary') ?? 0);

        // Calculer la durée moyenne des offres en jours
        $averageDuration = round(Offer::where('company_id', $id)
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->selectRaw('AVG(DATEDIFF(end_date, start_date)) as avg_duration')
            ->value('avg_duration') ?? 0);

        $applicationsCount = Application::whereHas('offer', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->count();

        return view('companies.info', compact('company', 'cities', 'topSkills', 'averageSalary', 'averageDuration', 'applicationsCount'));
    }


    public function showCompanyUpdate($id)
    {

        $this->authorize('edit_company');
        $company = Company::findOrFail($id);

        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();
        return view('companies.update', compact('company', 'cities', 'sectors'));
    }

    public function updateCompany(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $this->authorize('edit_company');

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
                Rule::unique('companies', 'siret')->ignore($company->id), // $companyId est l'ID de l'entreprise en cours d'édition
            ],
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'sectors' => 'nullable|array', // Vérification du tableau des secteurs
            'sectors.*' => 'exists:sectors,id', // Vérification que chaque secteur existe dans la table 'sectors'
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
            $company->sectors()->detach(); // Si aucun secteur n'est sélectionné, on les supprime
        }

        return redirect()->route('company_list')->with('success', 'Entreprise mise à jour avec succès');
    }

    public function deleteCompany($id)
    {
        $this->authorize('delete_company');
        $company = Company::findOrFail($id);

        foreach ($company->offers as $offer) {
            // Supprime les entrées dans la table pivot applications (candidatures)
            //$offer->user()->detach();

            DB::table('applications')
            ->where('offer_id', $offer->id)
            ->update(['deleted_at' => now()]);
        
            // Supprime les entrées dans la table pivot wishlists (souhaits)
            $offer->users()->detach();
        }
        
        // Supprime les offres associées à l'entreprise
        $company->offers()->delete();
        
        DB::table('evaluations')
        ->where('company_id', $company->id)
        ->update(['deleted_at' => now()]);
        
        // Suppression douce de l'entreprise
        $company->delete();        

        return redirect()->route('company_list')->with('success', 'Entreprise supprimée avec succès');
    }

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

    private function getCompanyByCityId($query, $request)
    {
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        return $query;
    }

    private function getCompanyByName($query, $request)
    {
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }
        return $query;
    }

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

    public function search(Request $request)
    {
        $query = Company::query();

        // Filtre par Nom/secteur/ville
        $query = $this->getCompanyByName($query, $request);
        $query = $this->getCompanyBySectorId($query, $request);
        $query = $this->getCompanyByCityId($query, $request);

        // Trie
        $query = $this->sortCompanyResults($query, $request);

        $companies = $query->paginate(9);

        // Envoyer les données des filtres
        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();

        return view('companies.list', compact('companies', 'sectors', 'cities'));
    }

    public function showOffers($company_id)
    {
        $company = Company::findOrFail($company_id);

        $offers = $company->offers()->paginate(10);

        return view('companies.offers', compact('offers', 'company'));
    }

}