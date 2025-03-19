<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Region;
use App\Models\City;
use App\Models\Sector;


class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function companyCarrousel()
    {
        $topCompanies = Company::withCount('offers') // Compte les offres liées à chaque entreprise
            ->orderByDesc('offers_count') // Trie par le plus grand nombre d'offres
            ->take(5) // Garde seulement les 5 premières
            ->get();

        return view('welcome', compact('topCompanies'));
    }


    public function show()
    {
        $this->authorize('search_company');
        $companies = Company::paginate(9);
        $cities = City::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();
        return view('companies.list', compact('companies','sectors','cities'));
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
            'siret' => 'required|string|max:14',
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

        return view('companies.info', compact('company', 'cities'));
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
            'siret' => 'required|string|max:14',
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
        // On effectue une suppression douce
        $company->delete();

        return redirect()->route('company_list')->with('success', 'Entreprise supprimée avec succès');
    }

    private function getCompanyBySectorId($query, $request) {
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

    private function getCompanyByCityId($query, $request){
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        return $query;
    }

    private function getCompanyByName($query, $request){
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }
        return $query;
    }
    
    private function sortCompanyResults($query, $request){
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
}