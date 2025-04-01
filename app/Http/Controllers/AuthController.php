<?php

namespace App\Http\Controllers; // Déclare l'espace de noms du contrôleur.

use Illuminate\Http\Request; // Importation de la classe Request pour gérer les requêtes HTTP.
use Illuminate\Support\Facades\Auth; // Importation de la classe Auth pour gérer l'authentification des utilisateurs.
use Illuminate\Validation\ValidationException; // Importation de la classe ValidationException pour gérer les erreurs de validation.

class AuthController extends Controller
{
    // Affiche la page de connexion.
    public function showLogin()
    {
        return view('auth.login'); // Retourne la vue du formulaire de connexion.
    }

    // Gère la connexion de l'utilisateur.
    public function login(Request $request)
    {
        // Validation des champs du formulaire.
        $request->validate([
            'email' => 'required|email', // L'email est requis et doit être valide.
            'password' => 'required', // Le mot de passe est requis.
        ]);

        // Vérifie les identifiants et tente d'authentifier l'utilisateur.
        if (Auth::attempt($request->only('email', 'password'))) { 
            $request->session()->regenerate(); // Régénère la session
            return redirect()->route('home')->with('success', 'Connexion réussie !'); // Ajoute un message flash
        }        

        // Si l'authentification échoue, retourne une erreur de validation.
        throw ValidationException::withMessages([
            'email' => 'Les identifiants sont incorrects.', // Message d'erreur affiché à l'utilisateur.
        ]);
    }

    // Gère la déconnexion de l'utilisateur.
    public function logout(Request $request)
    {
        Auth::logout(); // Déconnecte l'utilisateur.

        $request->session()->invalidate(); // Invalide la session actuelle.
        $request->session()->regenerateToken(); // Régénère un nouveau jeton CSRF pour plus de sécurité.

        return redirect()->route('home'); // Redirige l'utilisateur vers la page d'accueil après déconnexion.
    }
}
