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

    private function getRole($route)
    {
        return $route === 'students_list' ? 'Etudiant' : 'Pilote';
    }

    private function getOrCreateClasse(Request $request)
    {
        if ($request->new_classe) {
            return Classe::create(['name' => $request->new_classe]);
        }
        return $request->classe_id ? Classe::findOrFail($request->classe_id) : null;
    }
    public function show(Request $request)
    {
        // Récupérer le rôle de l'utilisateur basé sur la route actuelle
        $role = $this->getRole($request->route()->getName());

        // Autoriser en fonction du rôle de l'utilisateur (étudiant ou pilote)
        $this->authorize($role === 'Etudiant' ? 'search_student' : 'search_pilot');

        // Récupérer les classes accessibles en fonction du rôle de l'utilisateur
        $classes = auth()->user()->hasRole('Admin')
            ? Classe::all()  // Si l'utilisateur est Admin, on récupère toutes les classes
            : auth()->user()->classesPilots; // Sinon, on récupère les classes liées à l'utilisateur pilote

        // Récupérer les utilisateurs avec filtre de rôle et de classe (pagination incluse)
        $users = User::role($role)
            ->when($request->class_id, fn($query) => $query->where('classe_id', $request->class_id))
            ->paginate(10);

        // Retourner la vue avec les utilisateurs, le rôle et les classes accessibles
        return view('account.users.list', compact('users', 'role', 'classes'));
    }

    public function search(Request $request)
    {
        // Récupère le rôle depuis la route et le convertit en libellé utilisé en base
        $role = $request->route('role');
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';

        // Vérifie si l'utilisateur a l'autorisation d'effectuer cette recherche
        $this->authorize($role === 'Etudiant' ? 'search_student' : 'search_pilot');

        // Récupère les classes : si l'utilisateur est un admin, il voit toutes les classes
        // Sinon, il voit seulement celles qu'il pilote
        $classes = auth()->user()->hasRole('Admin') ? Classe::all() : auth()->user()->classesPilots;

        // Crée une requête de base pour récupérer les utilisateurs ayant le rôle spécifié
        $query = User::role($role);

        // Applique les filtres de recherche et de classe
        $this->applySearchFilter($query, $request->search);
        $this->applyClassFilter($query, $request->class_id);

        // Paginer les résultats (10 résultats par page)
        $users = $query->paginate(10);

        // Retourne la vue avec les utilisateurs trouvés, le rôle et les classes associées
        return view('account.users.list', compact('users', 'role', 'classes'));
    }

    // Applique un filtre de recherche par nom, prénom ou email
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

    // Applique un filtre sur l'identifiant de la classe
    private function applyClassFilter($query, ?int $classId)
    {
        if ($classId) {
            $query->where('classe_id', $classId);
        }
    }

    public function showUserRegister($role)
    {
        // Récupère et transforme le rôle pour correspondre aux valeurs en base
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';

        // Vérifie si l'utilisateur a le droit de créer un utilisateur du rôle donné
        $this->authorize($role === 'Etudiant' ? 'create_student' : 'create_pilot');

        // Retourne la vue d'inscription avec la liste des villes et classes disponibles
        return view('account.users.create', [
            'role' => $role,
            'cities' => City::all(),
            'classes' => Classe::all(),
        ]);
    }

    public function userRegister(Request $request)
    {
        // Récupère le rôle depuis la requête et vérifie les permissions associées
        $role = $request->role;
        $this->authorize($role === 'Etudiant' ? 'create_student' : 'create_pilot');
    
        // Validation des données d'entrée
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
            // Messages d'erreur personnalisés pour la validation
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
    
        // Vérifie si une nouvelle classe doit être créée ou si une classe existante est sélectionnée
        $classe = $this->getOrCreateClasse($request);
    
        // Affecte l'ID de la classe uniquement si l'utilisateur est un étudiant
        $data['classe_id'] = $role === 'Etudiant' ? optional($classe)->id : null;
    
        // Gestion de la photo de profil (stockage dans le dossier "images" du disque public)
        $data['pp_path'] = $request->file('pp')
            ? $request->file('pp')->store('images', 'public')
            : 'images/profile_picture.jpg'; // Image par défaut si aucune n'est fournie
    
        // Hashage du mot de passe avant l'enregistrement en base de données
        $data['password'] = Hash::make($data['password']);
    
        // Création de l'utilisateur en base
        $user = User::create($data);
    
        // Attribution du rôle (étudiant ou pilote) à l'utilisateur
        $user->assignRole($role);
    
        // Si l'utilisateur est un pilote, on lui associe les classes sélectionnées
        if ($role === 'Pilote' && $request->has('classesPilots')) {
            $user->classesPilots()->attach($request->classesPilots);
        }
    
        // Redirection avec un message de succès après création du compte
        return redirect()->route($role === 'Etudiant' ? 'students_list' : 'pilots_list')
            ->with('success', "Le profil " . $role . " a bien été créé");
    }    

    public function showUserInfo($role, $id)
    {
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';
        $user = User::findOrFail($id);

        // Nombre total de candidatures de l'utilisateur
        $totalApplications = Application::where('user_id', $id)->count();

        // Candidatures acceptées, refusées et en attente de l'utilisateur via la relation statusable
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

    public function showUserUpdate($role, $id)
    {

        // Détermination du rôle
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';
        // Récupération de l'utilisateur uniquement si l'accès est autorisé

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

            // Delete the evaluations associated with the user
            $user->evaluations()->detach(); // This will remove the relationships in the pivot table

        }

        // On effectue une suppression douce
        $user->delete();

        return redirect()->route($role === 'Etudiant' ? 'students_list' : 'pilots_list');
    }

}