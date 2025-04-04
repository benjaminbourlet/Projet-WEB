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

    /**
     * Affiche la liste des entreprises et des villes pour un utilisateur donné.
     *
     * @param int $user_id L'identifiant de l'utilisateur.
     * @return \Illuminate\Http\RedirectResponse|void Redirige si l'utilisateur n'est pas autorisé ou affiche les données.
     */
    public function index($user_id)
    {
        // Récupère l'utilisateur correspondant à l'ID fourni ou renvoie une erreur 404 si non trouvé.
        $user = User::findOrFail($user_id);

        // Vérifie si l'utilisateur connecté a le rôle d'Admin.
        if (!auth()->user()->hasRole('Admin')) {
            // Si l'utilisateur n'est pas Admin, il doit être l'utilisateur connecté.
            if ($user_id != auth()->id()) {
                return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à voir les candidatures de cet utilisateur.');
            }
        }

        // Récupère toutes les entreprises triées par nom en ordre croissant.
        $companies = Company::orderBy('name', 'asc')->get();

        // Récupère toutes les villes triées par nom en ordre croissant.
        $cities = City::orderBy('name', 'asc')->get();

        // Récupère toutes les régions triées par nom en ordre croissant.
        $regions = Region::orderBy('name', 'asc')->get();

        // Récupère les wishlists de l'utilisateur avec pagination.
        $wishlists = $user->wishlists()->paginate(10);

        return view('wishlists.list', compact('wishlists', 'companies', 'cities', 'user', 'regions'));
    }

    /**
     * Ajoute une offre à la wishlist d'un utilisateur.
     *
     * @param int $user_id L'identifiant de l'utilisateur.
     * @param int $offer_id L'identifiant de l'offre.
     * @return \Illuminate\Http\RedirectResponse Redirige avec un message de succès.
     */
    public function addToWishlist($user_id, $offer_id)
    {
        // Autorise l'action d'ajout d'une offre à la wishlist.
        $this->authorize('add_offer_to_wishlist');

        // Récupère l'utilisateur correspondant à l'ID fourni ou renvoie une erreur 404 si non trouvé.
        $user = User::findOrFail($user_id);

        // Vérifie si l'offre n'est pas déjà dans la wishlist de l'utilisateur.
        if (!$user->wishlists()->where('offer_id', $offer_id)->exists()) {
            // Ajoute l'offre à la wishlist de l'utilisateur avec la date de création.
            $user->wishlists()->attach($offer_id, ['created_at' => now()]);
        }

        return redirect()->back()->with('success', 'Offre ajoutée à votre wishlist');
    }

    /**
     * Retire une offre de la wishlist d'un utilisateur.
     *
     * @param int $user_id L'identifiant de l'utilisateur.
     * @param int $offer_id L'identifiant de l'offre.
     * @return \Illuminate\Http\RedirectResponse Redirige avec un message de succès.
     */
    public function removeFromWishlist($user_id, $offer_id)
    {
        // Autorise l'action de suppression d'une offre de la wishlist.
        $this->authorize('remove_offer_from_wishlist');

        // Récupère l'utilisateur correspondant à l'ID fourni ou renvoie une erreur 404 si non trouvé.
        $user = User::findOrFail($user_id);

        // Retire l'offre de la wishlist de l'utilisateur.
        $user->wishlists()->detach($offer_id);

        return redirect()->back()->with('success', 'Offre retirée de votre wishlist');
    }

    /**
     * Recherche des offres dans la wishlist d'un utilisateur en fonction de filtres.
     *
     * @param \Illuminate\Http\Request $request Les données de la requête.
     * @param int $user_id L'identifiant de l'utilisateur.
     * @return \Illuminate\View\View La vue avec les résultats de la recherche.
     */
    public function search(Request $request, $user_id)
    {
        // Autorise l'action de recherche d'une offre.
        $this->authorize('search_offer');

        // Récupère l'utilisateur correspondant à l'ID fourni ou renvoie une erreur 404 si non trouvé.
        $user = User::findOrFail($user_id);

        // Récupère les identifiants des offres dans la wishlist de l'utilisateur.
        $wishlistOfferIds = $user->wishlists()->pluck('offers.id')->toArray();

        // Crée une requête pour récupérer les offres correspondant aux identifiants.
        $query = Offer::whereIn('id', $wishlistOfferIds);

        // Applique les filtres de recherche.
        $this->applySearchFilter($query, $request);
        $this->applySalaryFilter($query, $request);
        $this->applyDurationFilter($query, $request);
        $this->applyStartDateFilter($query, $request);
        $this->applyCompanyFilter($query, $request);
        $this->applyCityFilter($query, $request);
        $this->applyRegionFilter($query, $request);

        // Récupère les offres avec pagination et ajoute les paramètres de la requête.
        $offers = $query->paginate(9)->appends($request->all());

        // Récupère les entreprises, villes et régions triées par nom.
        $companies = Company::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();

        // Récupère les wishlists avec pagination et ajoute les paramètres de la requête.
        $wishlists = $query->paginate(9);
        $wishlists->appends($request->all());

        return view('wishlists.list', compact('offers', 'companies', 'cities', 'regions', 'wishlists', 'user'));
    }

    /**
     * Applique un filtre de recherche sur les titres et descriptions des offres.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query La requête en cours.
     * @param \Illuminate\Http\Request $request Les données de la requête.
     */
    protected function applySearchFilter($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
    }

    /**
     * Applique un filtre sur le salaire minimum et maximum des offres.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query La requête en cours.
     * @param \Illuminate\Http\Request $request Les données de la requête.
     */
    protected function applySalaryFilter($query, Request $request)
    {
        if ($request->filled('min_salaire')) {
            $query->where('salary', '>=', (int) $request->min_salaire);
        }
        if ($request->filled('max_salaire')) {
            $query->where('salary', '<=', (int) $request->max_salaire);
        }
    }

    /**
     * Applique un filtre sur la durée minimum et maximum des offres.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query La requête en cours.
     * @param \Illuminate\Http\Request $request Les données de la requête.
     */
    protected function applyDurationFilter($query, Request $request)
    {
        if ($request->filled('duration_min')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) >= ?', [(int) $request->duration_min]);
        }
        if ($request->filled('duration_max')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) <= ?', [(int) $request->duration_max]);
        }
    }

    /**
     * Applique un filtre sur la date de début des offres.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query La requête en cours.
     * @param \Illuminate\Http\Request $request Les données de la requête.
     */
    protected function applyStartDateFilter($query, Request $request)
    {
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
    }

    /**
     * Applique un filtre sur l'entreprise des offres.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query La requête en cours.
     * @param \Illuminate\Http\Request $request Les données de la requête.
     */
    protected function applyCompanyFilter($query, Request $request)
    {
        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }
    }

    /**
     * Applique un filtre sur la ville des entreprises des offres.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query La requête en cours.
     * @param \Illuminate\Http\Request $request Les données de la requête.
     */
    protected function applyCityFilter($query, Request $request)
    {
        if ($request->filled('city')) {
            $query->whereHas('company.city', function ($q) use ($request) {
                $q->where('id', $request->city);
            });
        }
    }

    /**
     * Applique un filtre sur la région des villes des entreprises des offres.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query La requête en cours.
     * @param \Illuminate\Http\Request $request Les données de la requête.
     */
    protected function applyRegionFilter($query, Request $request)
    {
        if ($request->filled('region')) {
            $query->whereHas('company.city.region', function ($q) use ($request) {
                $q->where('id', $request->region);
            });
        }
    }

    /**
     * Affiche le formulaire de création d'une offre.
     *
     * @return \Illuminate\View\View La vue avec les données nécessaires pour créer une offre.
     */
    public function showOfferRegister()
    {
        // Autorise l'action de création d'une offre.
        $this->authorize('create_offer');

        // Récupère toutes les entreprises, compétences et départements.
        $companies = Company::all();
        $skills = Skill::all();
        $departments = Department::all();

        return view('offers.create', compact('companies', 'skills', 'departments'));
    }
}
