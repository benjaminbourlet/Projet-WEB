<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\Application;
use App\Models\Classe;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    use AuthorizesRequests;

    /**
     * Récupère le rôle de l'utilisateur basé sur la route.
     *
     * @param string $route
     * @return string
     */
    private function getRole($route)
    {
        return $route === 'students_list' ? 'Etudiant' : 'Pilote';
    }

    /**
     * Récupère ou crée une classe en fonction de la requête.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Classe|null
     */
    private function getOrCreateClasse(Request $request)
    {
        if ($request->new_classe) {
            return Classe::create(['name' => $request->new_classe]);
        }
        return $request->classe_id ? Classe::findOrFail($request->classe_id) : null;
    }

    /**
     * Affiche la liste des utilisateurs avec filtres.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $role = $this->getRole($request->route()->getName());
        $this->authorize($role === 'Etudiant' ? 'search_student' : 'search_pilot');

        $classes = auth()->user()->hasRole('Admin')
            ? Classe::all()
            : auth()->user()->classesPilots;

        $users = User::role($role)
            ->when($request->class_id, fn($query) => $query->where('classe_id', $request->class_id))
            ->paginate(10);

        return view('account.users.list', compact('users', 'role', 'classes'));
    }

    /**
     * Recherche des utilisateurs avec filtres.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $role = $request->route('role');
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';
        
        $this->authorize($role === 'Etudiant' ? 'search_student' : 'search_pilot');
    
        $classes = auth()->user()->hasRole('Admin') ? Classe::all() : auth()->user()->classesPilots;
        
        $query = User::role($role);
    
        $this->applySearchFilter($query, $request->search);
        $this->applyClassFilter($query, $request->class_id);
    
        $users = $query->paginate(10);
    
        return view('account.users.list', compact('users', 'role', 'classes'));
    }

    /**
     * Applique un filtre de recherche sur les utilisateurs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     * @return void
     */
    private function applySearchFilter($query, ?string $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('first_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
    }

    /**
     * Applique un filtre de classe sur les utilisateurs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $classId
     * @return void
     */
    private function applyClassFilter($query, ?int $classId)
    {
        if ($classId) {
            $query->where('classe_id', $classId);
        }
    }

    /**
     * Affiche le formulaire d'enregistrement d'un utilisateur.
     *
     * @param string $role
     * @return \Illuminate\View\View
     */
    public function showUserRegister($role)
    {
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';
        $this->authorize($role === 'Etudiant' ? 'create_student' : 'create_pilot');

        return view('account.users.create', [
            'role' => $role,
            'cities' => City::all(),
            'classes' => Classe::all(),
        ]);
    }

    /**
     * Enregistre un nouvel utilisateur.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userRegister(Request $request)
    {
        $role = $request->role;
        $this->authorize($role === 'Etudiant' ? 'create_student' : 'create_pilot');

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
            'pp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birthdate' => 'required|date|before:today|after:1900-01-01',
            'city_id' => 'required|exists:cities,id',
            'classe_id' => 'nullable|exists:classes,id',
            'new_classe' => 'nullable|string|max:50|unique:classes,name',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

            'first_name.required' => 'Le prénom est obligatoire.',
            'first_name.max' => 'Le prénom ne doit pas dépasser 50 caractères.',

            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.',

            'pp.image' => 'Le fichier doit être une image.',
            'pp.mimes' => 'L\'image doit être au format jpeg, png, jpg ou gif.',
            'pp.max' => 'L\'image ne doit pas dépasser 2 Mo.',

            'birthdate.required' => 'La date de naissance est obligatoire.',
            'birthdate.date' => 'La date de naissance doit être une date valide.',
            'birthdate.before' => 'La date de naissance doit être avant aujourd\'hui.',
            'birthdate.after' => 'La date de naissance doit être après le 1er janvier 1900.',

            'city_id.required' => 'La ville est obligatoire.',
            'city_id.exists' => 'La ville sélectionnée n\'existe pas.',

            'classe_id.exists' => 'La classe sélectionnée n\'existe pas.',

            'new_classe.string' => 'Le nom de la nouvelle classe doit être une chaîne de caractères.',
            'new_classe.max' => 'Le nom de la nouvelle classe ne doit pas dépasser 50 caractères.',
            'new_classe.unique' => 'Cette classe existe déjà.',
        ]);

        $classe = $this->getOrCreateClasse($request);
        $data['classe_id'] = $role === 'Etudiant' ? optional($classe)->id : null;
        $data['pp_path'] = $request->file('pp') ? $request->file('pp')->store('images', 'public') : 'images/profile_picture.jpg';
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->assignRole($role);

        if ($role === 'Pilote' && $request->has('classesPilots')) {
            $user->classesPilots()->attach($request->classesPilots);
        }

        return redirect()->route($role === 'Etudiant' ? 'students_list' : 'pilots_list')
            ->with('success', "Le profil " . $role . " a bien été créé");
    }

    /**
     * Affiche les informations d'un utilisateur spécifique.
     *
     * @param string $role
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showUserInfo($role, $id)
    {
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';
        $user = User::findOrFail($id);

        $totalApplications = Application::where('user_id', $id)->count();

        $acceptedApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Acceptée');
            })->count();

        $rejectedApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Refusée');
            })->count();

        $pendingApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'En attente');
            })->count();

        $traitementApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'En cours de traitement');
            })->count();

        $interviewApplications = Application::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Entretien programmé');
            })->count();

        $this->authorize($role === 'Etudiant' ? 'view_student_stats' : 'edit_pilot');

        return view('account.users.info', [
            'user' => $user,
            'role' => $role,
            'cities' => City::all(),
            'classes' => Classe::all(),
            'applications' => $user->applications()->orderBy('created_at', 'desc')->take(3)->get(),
            'totalApplications' => $totalApplications,
            'acceptedApplications' => $acceptedApplications,
            'rejectedApplications' => $rejectedApplications,
            'pendingApplications' => $pendingApplications,
            'traitementApplications' => $traitementApplications,
            'interviewApplications' => $interviewApplications,
        ]);
    }

    /**
     * Affiche le formulaire de mise à jour d'un utilisateur.
     *
     * @param string $role
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showUserUpdate($role, $id)
    {
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';
        $user = User::findOrFail($id);

        $this->authorize($role === 'Etudiant' ? 'view_student_stats' : 'edit_pilot');
        if ($role === 'Etudiant')
            $this->authorize('edit_student');

        return view('account.users.update', [
            'user' => $user,
            'role' => $role,
            'cities' => City::all(),
            'classes' => Classe::all(),
        ]);
    }

    /**
     * Met à jour les informations d'un utilisateur.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $role = $user->hasRole('Etudiant') ? 'Etudiant' : 'Pilote';
        $this->authorize(ability: $role === 'Etudiant' ? 'edit_student' : 'edit_pilot');

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'pp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birthdate' => 'required|date|before:today|after:1900-01-01',
            'city_id' => 'required|exists:cities,id',
            'classe_id' => 'nullable|exists:classes,id',
            'new_classe' => 'nullable|string|max:50|unique:classes,name',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

            'first_name.required' => 'Le prénom est obligatoire.',
            'first_name.max' => 'Le prénom ne doit pas dépasser 50 caractères.',

            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.',

            'pp.image' => 'Le fichier doit être une image.',
            'pp.mimes' => 'L\'image doit être au format jpeg, png, jpg ou gif.',
            'pp.max' => 'L\'image ne doit pas dépasser 2 Mo.',

            'birthdate.required' => 'La date de naissance est obligatoire.',
            'birthdate.date' => 'La date de naissance doit être une date valide.',
            'birthdate.before' => 'La date de naissance doit être avant aujourd\'hui.',
            'birthdate.after' => 'La date de naissance doit être après le 1er janvier 1900.',

            'city_id.required' => 'La ville est obligatoire.',
            'city_id.exists' => 'La ville sélectionnée n\'existe pas.',

            'classe_id.exists' => 'La classe sélectionnée n\'existe pas.',

            'new_classe.string' => 'Le nom de la nouvelle classe doit être une chaîne de caractères.',
            'new_classe.max' => 'Le nom de la nouvelle classe ne doit pas dépasser 50 caractères.',
            'new_classe.unique' => 'Cette classe existe déjà.',
        ]);

        $classe = $this->getOrCreateClasse($request);
        $data['classe_id'] = $role === 'Etudiant' ? optional($classe)->id : $user->classe_id;

        if ($request->hasFile('pp')) {
            $data['pp_path'] = $request->file('pp')->store('images', 'public');
        }

        $user->update($data);

        if ($role === 'Pilote') {
            $user->classesPilots()->sync($request->classesPilots ?? []);
        }

        return redirect()->route($role === 'Etudiant' ? 'students_list' : 'pilots_list')
            ->with('success', "Le profil " . $role . " a bien été créé");
    }

    /**
     * Supprime un utilisateur.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $role = $user->hasRole('Etudiant') ? 'Etudiant' : 'Pilote';

        $this->authorize(ability: $role === 'Etudiant' ? 'delete_student' : 'delete_pilot');

        if ($role === 'Etudiant') {
            DB::table('applications')
                ->where('user_id', $user->id)
                ->update(['deleted_at' => now()]);

            $user->wishlists()->detach();

            $user->evaluations()->detach();
        }

        $user->delete();

        return redirect()->route($role === 'Etudiant' ? 'students_list' : 'pilots_list');
    }

}