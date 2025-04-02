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




class OfferController extends Controller
{
    use AuthorizesRequests;

        public function show(Request $request)
    {

        $companies = Company::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();

        $this->authorize('search_offer');

        $query = Offer::query();

        /*
        // Filtrer par secteur
        if ($request->filled('sector')) {
            $query->whereHas('company.sectors', function ($q) use ($request) {
                $q->where('name', $request->sector);
            });
        }
        */

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('description', 'LIKE', "%{$search}%");
        }
        // Filtrer par ville
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%');
        }

        /*
        if ($request->filled('skills')) {
            $skills = explode(',', $request->skills);
            $query->whereHas('skills', function ($q) use ($skills) {
                $q->whereIn('name', $skills);
            });
        }
        */
        // Filtrer par salaire
        if ($request->filled('min_salaire')) {
            $query->where('salary', '>=', $request->min_salaire);
        }
        if ($request->filled('max_salaire')) {
            $query->where('salary', '<=', $request->max_salaire);
        }

        // Filtrer par durée
        if ($request->filled('duree_min')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) >= ?', [$request->duree_min]);
        }
        if ($request->filled('duree_max')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) <= ?', [$request->duree_max]);
        }

        // Filtrer par date de début
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }

        //Filtrer par entreprise
        if ($request->filled('company')) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->company . "%");
            });
        }

        // Récupérer les offres avec pagination
        $offers = $query->paginate(9);

        return view('offers.list', compact('offers', 'cities', 'companies'));
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
            'end_date' => 'required|date|after:start_date|before:' . now()->addYear()->format('Y-m-d'),
            'salary' => 'nullable',
            'company_id' => 'required|exists:companies,id',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'departments' => 'nullable|array',
            'departments.*' => 'exists:departments,id',
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
        return view('offers.info', compact('offer'));
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
            'end_date' => 'required|date|after:start_date|before:' . now()->addYear()->format('Y-m-d'),
            'salary' => 'nullable|numeric',
            'company_id' => 'required|exists:companies,id',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'departments' => 'nullable|array',
            'departments.*' => 'exists:departments,id',
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
        $offer = Offer::findOrFail($id);
        // On effectue une suppression douce
        $offer->delete();

        return redirect()->route('offer_list')->with('success', 'Offre supprimée avec succès');
    }
}