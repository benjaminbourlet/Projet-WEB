<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\City;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Skill;
use App\Models\Department;
use App\Models\Region;



class WishlistController extends Controller
{
    use AuthorizesRequests;
    public function index($user_id)
    {

        $user = User::findOrFail($user_id);
        // Vérifier si l'utilisateur est admin ou pilote
        if (!auth()->user()->hasRole('Admin')) {
            // Si l'utilisateur n'est pas admin ou pilote, il doit être l'utilisateur connecté
            if ($user_id != auth()->id()) {
                return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à voir les candidatures de cet utilisateur.');
            }
        }
        $companies = Company::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $regions = Region::orderBy('name', 'asc')->get();

        $wishlists = $user->wishlists()->paginate(10);

        return view('wishlists.list', compact('wishlists', 'companies', 'cities', 'user', 'regions'));
    }

    public function addToWishlist($user_id, $offer_id)
    {

        $this->authorize('add_offer_to_wishlist');
        $user = User::findOrFail($user_id);

        if (!$user->wishlists()->where('offer_id', $offer_id)->exists()) {
            $user->wishlists()->attach($offer_id, ['created_at' => now()]);
        }

        return redirect()->back()->with('success', 'Offre ajoutée à votre wishlist');
    }

    public function removeFromWishlist($user_id, $offer_id)
    {
        $this->authorize('remove_offer_from_wishlist');
        $user = User::findOrFail($user_id);
        $user->wishlists()->detach($offer_id);

        return redirect()->back()->with('success', 'Offre retirée de votre wishlist');
    }

    public function search(Request $request, $user_id)
    {
        // Vérifie si l'utilisateur a la permission de rechercher une offre
        $this->authorize('search_offer');

        // Récupère l'utilisateur correspondant à l'ID fourni, ou renvoie une erreur 404 s'il n'existe pas
        $user = User::findOrFail($user_id);

        // Récupère les ID des offres enregistrées dans la liste de souhaits de l'utilisateur
        $wishlistOfferIds = $user->wishlists()->pluck('offers.id')->toArray();

        // Initialise la requête avec les offres correspondant aux ID de la liste de souhaits
        $query = Offer::whereIn('id', $wishlistOfferIds);

        // Applique les filtres de recherche en fonction des paramètres de la requête
        $this->applySearchFilter($query, $request);
        $this->applySalaryFilter($query, $request);
        $this->applyDurationFilter($query, $request);
        $this->applyStartDateFilter($query, $request);
        $this->applyCompanyFilter($query, $request);
        $this->applyCityFilter($query, $request);
        $this->applyRegionFilter($query, $request);

        // Récupère les offres paginées (9 offres par page) en conservant les paramètres de la requête
        $offers = $query->paginate(9)->appends($request->all());

        // Récupère les listes d'entreprises, de villes et de régions pour les filtres
        $companies = Company::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();

        // Répétition inutile : les offres sont déjà paginées dans $offers
        $wishlists = $query->paginate(9);
        $wishlists->appends($request->all());

        // Retourne la vue avec les offres et les informations nécessaires pour l'affichage
        return view('wishlists.list', compact('offers', 'companies', 'cities', 'regions', 'wishlists', 'user'));
    }

    // Applique un filtre de recherche sur le titre et la description des offres
    protected function applySearchFilter($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
    }

    // Applique un filtre sur le salaire minimum et maximum
    protected function applySalaryFilter($query, Request $request)
    {
        if ($request->filled('min_salaire')) {
            $query->where('salary', '>=', (int) $request->min_salaire);
        }
        if ($request->filled('max_salaire')) {
            $query->where('salary', '<=', (int) $request->max_salaire);
        }
    }

    // Applique un filtre sur la durée du contrat
    protected function applyDurationFilter($query, Request $request)
    {
        if ($request->filled('duration_min')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) >= ?', [(int) $request->duration_min]);
        }
        if ($request->filled('duration_max')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) <= ?', [(int) $request->duration_max]);
        }
    }

    // Applique un filtre sur la date de début du contrat
    protected function applyStartDateFilter($query, Request $request)
    {
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
    }

    // Filtre les offres par entreprise
    protected function applyCompanyFilter($query, Request $request)
    {
        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }
    }

    // Filtre les offres par ville de l'entreprise
    protected function applyCityFilter($query, Request $request)
    {
        if ($request->filled('city')) {
            $query->whereHas('company.city', function ($q) use ($request) {
                $q->where('id', $request->city);
            });
        }
    }

    // Filtre les offres par région de la ville de l'entreprise
    protected function applyRegionFilter($query, Request $request)
    {
        if ($request->filled('region')) {
            $query->whereHas('company.city.region', function ($q) use ($request) {
                $q->where('id', $request->region);
            });
        }
    }

}
