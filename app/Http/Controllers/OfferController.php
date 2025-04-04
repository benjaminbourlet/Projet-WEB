<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\City;
use App\Models\Sector;
use App\Models\Offer;
use App\Models\Skill;
use App\Models\Department;
use App\Models\Region;
use Illuminate\Support\Facades\DB;





class OfferController extends Controller
{
    use AuthorizesRequests;

    public function show(Request $request)
    {
        $companies = Company::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $regions = Region::orderBy('name', 'asc')->get();

        $this->authorize('search_offer');

        // Récupérer les offres avec pagination
        $offers = Offer::paginate(9);

        return view('offers.list', compact('offers', 'cities', 'companies', 'regions'));
    }

    public function search(Request $request)
    {
        $companies = Company::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $regions = Region::orderBy('name', 'asc')->get();

        $this->authorize('search_offer');

        $query = Offer::query();

        // Appliquer les filtres un par un
        $this->applySearchFilter($query, $request);
        $this->applySalaryFilter($query, $request);
        $this->applyDurationFilter($query, $request);
        $this->applyStartDateFilter($query, $request);
        $this->applyCompanyFilter($query, $request);
        $this->applyCityFilter($query, $request);
        $this->applyRegionFilter($query, $request);

        // Récupérer les offres avec pagination
        $offers = $query->paginate(9);

        $offers->appends($request->all());

        return view('offers.list', compact('offers', 'companies', 'cities', 'regions'));
    }

    // Applique un filtre de recherche sur le titre et la description
    protected function applySearchFilter($query, Request $request)
    {
        // Vérifie si un terme de recherche est fourni dans la requête
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                // Recherche dans le titre ou la description en utilisant LIKE pour une correspondance partielle
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        }
    }

    // Applique un filtre sur le salaire minimum et maximum
    protected function applySalaryFilter($query, Request $request)
    {
        // Vérifie et applique un salaire minimum
        if ($request->filled('min_salaire')) {
            $query->where('salary', '>=', (int) $request->min_salaire);
        }
        // Vérifie et applique un salaire maximum
        if ($request->filled('max_salaire')) {
            $query->where('salary', '<=', (int) $request->max_salaire);
        }
    }

    // Applique un filtre sur la durée (calculée en jours entre la date de début et la date de fin)
    protected function applyDurationFilter($query, Request $request)
    {
        // Vérifie et applique une durée minimale
        if ($request->filled('duration_min')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) >= ?', [(int) $request->duration_min]);
        }
        // Vérifie et applique une durée maximale
        if ($request->filled('duration_max')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) <= ?', [(int) $request->duration_max]);
        }
    }

    // Applique un filtre sur la date de début de l'offre
    protected function applyStartDateFilter($query, Request $request)
    {
        // Vérifie si une date de début est fournie et filtre les offres qui commencent à partir de cette date
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
    }

    // Applique un filtre sur l'entreprise
    protected function applyCompanyFilter($query, Request $request)
    {
        // Vérifie si un identifiant d'entreprise est fourni et filtre les offres correspondantes
        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }
    }

    // Applique un filtre sur la ville en vérifiant la relation entre l'offre et la ville de l'entreprise
    protected function applyCityFilter($query, Request $request)
    {
        // Vérifie si une ville est spécifiée et filtre les offres en fonction de la ville de l'entreprise
        if ($request->filled('city')) {
            $query->whereHas('company.city', function ($q) use ($request) {
                $q->where('id', $request->city);
            });
        }
    }

    // Applique un filtre sur la région en vérifiant la relation entre l'offre et la région de la ville de l'entreprise
    protected function applyRegionFilter($query, Request $request)
    {
        // Vérifie si une région est spécifiée et filtre les offres en fonction de la région de la ville de l'entreprise
        if ($request->filled('region')) {
            $query->whereHas('company.city.region', function ($q) use ($request) {
                $q->where('id', $request->region);
            });
        }
    }

    public function showOfferRegister()
    {

        $this->authorize('create_offer');
        $companies = Company::all();
        $skills = Skill::all();
        $departments = Department::all();
        return view('offers.create', compact('companies', 'skills', 'departments'));
    }

    public function offerRegister(Request $request)
    {
        $this->authorize('create_offer');

        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after:today|before:' . now()->addYear()->format('Y-m-d'),
            'end_date' => [
                'required',
                'date',
                'after:start_date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->start_date) {
                        $maxEndDate = \Carbon\Carbon::parse($request->start_date)->addMonths(6)->format('Y-m-d');
                        if ($value > $maxEndDate) {
                            $fail("La date de fin doit être au maximum 6 mois après la date de début (jusqu'au $maxEndDate).");
                        }
                    }
                },
            ],
            'salary' => 'required|integer',
            'company_id' => 'required|exists:companies,id',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'departments' => 'nullable|array',
            'departments.*' => 'exists:departments,id',
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 150 caractères.',

            'description.string' => 'La description doit être une chaîne de caractères.',

            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.date' => 'La date de début doit être une date valide.',
            'start_date.after' => 'La date de début doit être après aujourd’hui.',
            'start_date.before' => 'La date de début ne peut pas dépasser un an à partir d’aujourd’hui.',

            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.date' => 'La date de fin doit être une date valide.',
            'end_date.after' => 'La date de fin doit être après la date de début.',

            'salary.required' => 'Le salaire est obligatoire.',
            'salary.integer' => 'Le salaire doit être un nombre entier.',

            'company_id.required' => 'L’identifiant de l’entreprise est obligatoire.',
            'company_id.exists' => 'L’entreprise sélectionnée n’existe pas.',

            'skills.array' => 'Les compétences doivent être sous forme de tableau.',
            'skills.*.exists' => 'L’une des compétences sélectionnées n’existe pas.',

            'departments.array' => 'Les départements doivent être sous forme de tableau.',
            'departments.*.exists' => 'L’un des départements sélectionnés n’existe pas.',
        ]);


        // Création de l'entreprise
        $offer = Offer::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'salary' => $request->salary,
            'publication_date' => $request->publication_date,
            'company_id' => $request->company_id,
        ]);

        if ($request->has('skills')) {
            $offer->skills()->attach($request->skills);
        }

        if ($request->has('departments')) {
            $offer->departments()->attach($request->departments);
        }

        return redirect()->route('offer_list')->with('success', 'Offre créée avec succès');
    }

    public function showOfferInfo($id)
    {
        $offer = Offer::findOrFail($id);

        // Récupérer le nombre d'étudiants ayant postulé
        $applicationsCount = $offer->user()->count();

        // Récupérer le nombre d'étudiants ayant mis l'offre en wishlist
        $wishlistsCount = $offer->users()->count();

        return view('offers.info', compact('offer', 'applicationsCount', 'wishlistsCount'));
    }

    public function showOfferUpdate($id)
    {

        $this->authorize('edit_offer');
        $offer = Offer::findOrFail($id);
        $companies = Company::all();
        $skills = Skill::all();
        $departments = Department::all();

        return view('offers.update', compact('offer', 'companies', 'skills', 'departments'));
    }

    public function updateOffer(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $this->authorize('edit_offer');

        // Validation des données
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after:today|before:' . now()->addYear()->format('Y-m-d'),
            'end_date' => [
                'required',
                'date',
                'after:start_date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->start_date) {
                        $maxEndDate = \Carbon\Carbon::parse($request->start_date)->addMonths(6)->format('Y-m-d');
                        if ($value > $maxEndDate) {
                            $fail("La date de fin doit être au maximum 6 mois après la date de début (jusqu'au $maxEndDate).");
                        }
                    }
                },
            ],
            'salary' => 'required|integer',
            'company_id' => 'required|exists:companies,id',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'departments' => 'nullable|array',
            'departments.*' => 'exists:departments,id',
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 150 caractères.',

            'description.string' => 'La description doit être une chaîne de caractères.',

            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.date' => 'La date de début doit être une date valide.',
            'start_date.after' => 'La date de début doit être après aujourd’hui.',
            'start_date.before' => 'La date de début ne peut pas dépasser un an à partir d’aujourd’hui.',

            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.date' => 'La date de fin doit être une date valide.',
            'end_date.after' => 'La date de fin doit être après la date de début.',

            'salary.required' => 'Le salaire est obligatoire.',
            'salary.integer' => 'Le salaire doit être un nombre entier.',

            'company_id.required' => 'L’identifiant de l’entreprise est obligatoire.',
            'company_id.exists' => 'L’entreprise sélectionnée n’existe pas.',

            'skills.array' => 'Les compétences doivent être sous forme de tableau.',
            'skills.*.exists' => 'L’une des compétences sélectionnées n’existe pas.',

            'departments.array' => 'Les départements doivent être sous forme de tableau.',
            'departments.*.exists' => 'L’un des départements sélectionnés n’existe pas.',
        ]);

        // Mise à jour des informations de l'offre
        $offer->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'salary' => $request->salary,
            'publication_date' => $request->publication_date,
            'company_id' => $request->company_id,
        ]);

        // Mise à jour des compétences associées (secteurs)
        if ($request->has('skills')) {
            $offer->skills()->sync($request->skills); // Utilisation de sync pour mettre à jour les compétences
        } else {
            $offer->skills()->detach(); // Si aucun secteur n'est sélectionné, on les supprime
        }

        // Mise à jour des départements associés
        if ($request->has('departments')) {
            $offer->departments()->sync($request->departments); // Utilisation de sync pour mettre à jour les départements
        } else {
            $offer->departments()->detach(); // Si aucun département n'est sélectionné, on les supprime
        }

        // Redirection avec message de succès
        return redirect()->route('offer_list')->with('success', 'Offre mise à jour avec succès');
    }

    public function deleteOffer($id)
    {
        $offer = Offer::findOrFail($id); // Trouve l'offre ou génère une erreur 404

        // Marquer les candidatures (applications) comme supprimées avec SoftDeletes
        DB::table('applications')
            ->where('offer_id', $offer->id)
            ->update(['deleted_at' => now()]);

        // Supprime les utilisateurs associés dans la table wishlists
        $offer->users()->detach();

        // Effectuer une suppression douce de l'offre
        $offer->delete();

        return redirect()->route('offer_list')->with('success', 'Offre supprimée avec succès');
    }

    public function dashboard()
    {

        // Répartition des offres par compétence
        $skillsDistribution = Skill::withCount('offers')->orderByDesc('offers_count')->get();

        // Répartition des offres par durée de stage
        $durationDistribution = Offer::selectRaw('
            CASE 
                WHEN DATEDIFF(end_date, start_date) <= 30 THEN "Moins d\'1 mois"
                WHEN DATEDIFF(end_date, start_date) BETWEEN 31 AND 90 THEN "1 à 3 mois"
                WHEN DATEDIFF(end_date, start_date) BETWEEN 91 AND 180 THEN "3 à 6 mois"
                ELSE "Plus de 6 mois"
            END as duration_range, COUNT(*) as count
        ')
            ->groupBy('duration_range')
            ->get();

        // Récupération des offres les plus mises en wishlist
        $topWishlistedOffers = Offer::withCount('users')->orderByDesc('users_count')->take(5)->get();

        return view('offers.dashboard', compact('skillsDistribution', 'durationDistribution', 'topWishlistedOffers'));
    }


}