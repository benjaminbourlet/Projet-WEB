<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\Classe;
use App\Models\City;

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
        $role = $this->getRole($request->route()->getName());
        $this->authorize($role === 'Etudiant' ? 'search_student' : 'search_pilot');

        $classes = auth()->user()->hasRole('Admin') ? Classe::all() : auth()->user()->classesPilots; //()->pluck('id');

        $users = User::role($role)
            ->when($request->class_id, fn($query) => $query->where('classe_id', $request->class_id))
            ->paginate(10);

        return view('account.users.list', compact('users', 'role', 'classes'));
    }

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

        return redirect()->route($role === 'Etudiant' ? 'students_list' : 'pilots_list');
    }

    public function showUserInfo($role, $id)
    {
        $role = $role === 'students' ? 'Etudiant' : 'Pilote';
        $user = User::findOrFail($id);

        $this->authorize($role === 'Etudiant' ? 'view_student_stats' : 'edit_pilot');

        return view('account.users.info', [
            'user' => $user,
            'role' => $role,
            'cities' => City::all(),
            'classes' => Classe::all(),
            'applications' => $user->applications()->orderBy('created_at', 'desc')->take(3)->get(),
        ]);
    }

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

        return redirect()->route($role === 'Etudiant' ? 'students_list' : 'pilots_list');
    }

    public function deleteUser($id)
    {

        $user = User::findOrFail($id);
        $role = $user->hasRole('Etudiant') ? 'Etudiant' : 'Pilote';

        $this->authorize(ability: $role === 'Etudiant' ? 'delete_student' : 'delete_pilot');

        // On effectue une suppression douce
        $user->delete();

        return redirect()->route($role === 'Etudiant' ? 'students_list' : 'pilots_list');
    }

}