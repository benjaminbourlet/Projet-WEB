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

        $wishlists = $user->wishlists()->paginate(10);

        return view('wishlists.list', compact('wishlists', 'companies', 'cities', 'user'));
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

    public function search(Request $request)
{
    $companies = Company::orderBy('name', 'asc')->get();
    $cities = City::orderBy('name', 'asc')->get();

    $this->authorize('search_offer');

    // Récupérer l'utilisateur connecté
    $user = auth()->user();

    $query = Offer::query();

    // Appliquer les filtres un par un
    $this->applySearchFilter($query, $request);
    $this->applySalaryFilter($query, $request);
    $this->applyDurationFilter($query, $request);
    $this->applyStartDateFilter($query, $request);
    $this->applyCompanyFilter($query, $request);
    $this->applyCityFilter($query, $request);

    // Ajouter un filtre pour ne récupérer que les offres de la wishlist de l'utilisateur
    $query->whereIn('id', $user->wishlists->pluck('id'));

    // Récupérer les offres avec pagination
    $offers = $query->paginate(9);

    $offers->appends($request->all());

    return view('offers.list', compact('offers', 'companies', 'cities'));
}
protected function applySearchFilter($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->search . '%');
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

    public function showOfferRegister()
    {

        $this->authorize('create_offer');
        $companies = Company::all();
        $skills = Skill::all();
        $departments = Department::all();
        return view('offers.create', compact('companies', 'skills', 'departments'));
    }


}
