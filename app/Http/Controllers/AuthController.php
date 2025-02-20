<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Afficher la page de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Afficher la page d'inscription
    public function showRegister()
    {
        return view('auth.register');
    }

    // Traiter l'inscription
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/'
            ],
            'region_id' => 'required|exists:regions,id',
            'city_id' => 'required|exists:cities,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
            'role_id' => $request->role_id,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        throw ValidationException::withMessages([
            'email' => 'Les identifiants sont incorrects.',
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
