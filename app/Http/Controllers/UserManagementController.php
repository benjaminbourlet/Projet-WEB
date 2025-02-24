<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserManagementController extends Controller
{
    // Afficher la liste des étudiants ou des pilotes
    public function show()
    {
        if (!auth()->user()->hasAnyRole(['Admin', 'Pilote'])) {
            return redirect()->route('home'); // Redirection si l'utilisateur n'a pas les droits
        }

        // Vérification du rôle demandé (Étudiant ou Pilote)
        $role = request()->routeIs('students_list') ? 'Etudiant' : 'Pilote'; //Si la route est students-list alors etudiant sinon pilote
        $users = User::role($role)->get(); //Recup de tous les users avec le role

        if ($users->isEmpty()) {
            return back()->with('error', "Aucun $role trouvé !");
        }

        return view('account.users.list', compact('users', 'role'));
    }

    // Afficher le formulaire d'inscription (Étudiant ou Pilote)
    public function showUserRegister($role)
    {
        // Associer les slugs anglais aux rôles français
        $roles = ['students' => 'Etudiant', 'pilots' => 'Pilote'];
    
        $role = $roles[$role];
    
        return view('account.users.create', compact('role'));
    }
    
    
    // Traiter l'inscription d'un étudiant ou d'un pilote
    public function userRegister(Request $request)
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
            'pp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'region_id' => 'required|exists:regions,id',
            'city_id' => 'required|exists:cities,id',
            'role' => 'required|in:Etudiant,Pilote'
        ]);

        if ($request->hasFile('pp')) {
            $pp = $request->file('pp');
            $ppPath = $pp->store('images', 'public');
        }
        else {
            // Utiliser l'image par défaut si aucune photo de profil n'est envoyée
            $ppPath = 'images/profile_picture.jpg';
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pp_path' => $ppPath ?? null,
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
        ]);

        // Attribution du rôle
        $user->assignRole($request->role);

        return redirect()->route($request->role === 'Etudiant' ? 'students_list' : 'pilots_list');
    }
}
