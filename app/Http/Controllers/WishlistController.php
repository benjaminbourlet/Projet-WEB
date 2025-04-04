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
        $this->authorize('search_offer');

        $user = User::findOrFail($user_id);
        $wishlistOfferIds = $user->wishlists()->pluck('offers.id')->toArray();

        $query = Offer::whereIn('id', $wishlistOfferIds);

        // Filtres
        $this->applySearchFilter($query, $request);
        $this->applySalaryFilter($query, $request);
        $this->applyDurationFilter($query, $request);
        $this->applyStartDateFilter($query, $request);
        $this->applyCompanyFilter($query, $request);
        $this->applyCityFilter($query, $request);
        $this->applyRegionFilter($query, $request);

        $offers = $query->paginate(9)->appends($request->all());

        $companies = Company::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();

        // Récupérer les offres avec pagination
        $wishlists = $query->paginate(9);
    
        $wishlists->appends($request->all());

        return view('wishlists.list', compact('offers', 'companies', 'cities', 'regions', 'wishlists', 'user'));
    }

    protected function applySearchFilter($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
    }

    protected function applySalaryFilter($query, Request $request)
    {
        if ($request->filled('min_salaire')) {
            $query->where('salary', '>=', (int) $request->min_salaire);
        }
        if ($request->filled('max_salaire')) {
            $query->where('salary', '<=', (int) $request->max_salaire);
        }
    }

    protected function applyDurationFilter($query, Request $request)
    {
        if ($request->filled('duration_min')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) >= ?', [(int) $request->duration_min]);
        }
        if ($request->filled('duration_max')) {
            $query->whereRaw('DATEDIFF(end_date, start_date) <= ?', [(int) $request->duration_max]);
        }
    }

    protected function applyStartDateFilter($query, Request $request)
    {
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
    }

    protected function applyCompanyFilter($query, Request $request)
    {
        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }
    }

    protected function applyCityFilter($query, Request $request)
    {
        if ($request->filled('city')) {
            $query->whereHas('company.city', function ($q) use ($request) {
                $q->where('id', $request->city);
            });
        }
    }

    protected function applyRegionFilter($query, Request $request)
    {
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


}
