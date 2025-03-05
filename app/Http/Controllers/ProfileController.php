<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté
        return view('account.profile', compact('user')); // Passer $user à la vue
    }
    
}