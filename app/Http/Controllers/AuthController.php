<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    // Affiche la page de connexion.
    public function showLogin()
    {
        return view('auth.login'); 
    }

    // Gère la connexion de l'utilisateur.
    public function login(Request $request)
    {
        // Validation avec messages personnalisés.
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        // Clé de limitation de tentative basée sur l'IP.
        $throttleKey = 'login:' . $request->ip();

        // Vérifier si trop de tentatives ont été faites.
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors([
                'email' => 'Trop de tentatives. Veuillez réessayer dans ' . RateLimiter::availableIn($throttleKey) . ' secondes.'
            ]);
        }

        // Tentative d'authentification.
        if (!Auth::attempt($request->only('email', 'password'))) {
            RateLimiter::hit($throttleKey, 60); // Bloque après 5 essais en 60s
            return back()->withErrors([
                'email' => 'Les identifiants sont incorrects.',
            ])->withInput();
        }

        // Si connexion réussie, réinitialiser le compteur de tentatives.
        RateLimiter::clear($throttleKey);

        // Régénérer la session pour des raisons de sécurité.
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Connexion réussie !');
    }

    // Gère la déconnexion de l'utilisateur.
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
