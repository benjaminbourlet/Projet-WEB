<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

        $wishlists = $user->wishlists()->paginate(10);

        return view('wishlists.list', compact('wishlists'));
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
}
