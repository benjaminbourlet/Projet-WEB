@extends('layouts.app')
{{--
    Fichier : list.blade.php
    Description : Affichage de la liste des utilisateurs en fonction du rôle (Étudiant ou Pilote)
--}}

@section('title', $role . 's')
{{-- Définir le titre de la page en fonction du rôle de l'utilisateur --}}

@section('content')
{{-- Début du contenu principal de la page --}}

{{-- Si la liste des utilisateurs est vide, afficher un message --}}
@if ($users->isEmpty())
        <p class="text-gray-500">Aucun avis n'a été publié</p>
    @else

{{-- Sinon, afficher la liste des utilisateurs --}}
<main>
    {{-- Zone principale pour l'affichage de la liste des utilisateurs --}}
    <div class="container mx-auto p-4 flex flex-col gap-6">
        
        {{-- Message de succès (si disponible) --}}
        @if(session('success'))
            <div id="success-message" class="bg-green-500 text-white p-3 rounded-md mb-4 max-w-sm mx-auto">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- Titre de la page (Liste des utilisateurs) --}}
        <h1 class="text-2xl font-bold">{{ $role }}s</h1>

        {{-- Bouton pour ajouter un nouvel utilisateur --}}
        <div class="flex space-x-2">
            <a href="{{ route('user_register', [$role === 'Etudiant' ? 'students' : 'pilots']) }}">
                <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">+</button>
            </a>
        </div>

        {{-- Formulaire de recherche et filtres --}}
        <form method="GET" action="{{ route('user_search', ['role' => $role === 'Etudiant' ? 'students' : 'pilots']) }}" class="mt-4 flex items-center space-x-2">
            {{-- Champ de recherche pour trouver un utilisateur --}}
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un utilisateur..." class="w-full border p-2 rounded-md">
            
            @if ($role === 'Etudiant')
                {{-- Bouton pour afficher/masquer la liste des classes (filtre par Promo) --}}
                <button type="button" onclick="toggleClassList()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">📁</button>
                <a href="{{ route('user_search', ['role' => $role === 'Etudiant' ? 'students' : 'pilots']) }}" class="bg-blue-700 hover:bg-blue-400 text-white p-2 rounded-md">Réinitialiser</a>
            @endif
        </form>

        {{-- Liste des classes pour filtrer les utilisateurs (affiché pour les étudiants) --}}
        @if ($role === 'Etudiant')
        <div id="classList" class="mt-4 hidden bg-white p-4 shadow-md rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold">Filtrer par Promo</h2>
            <ul class="mt-2">
                @foreach ($classes as $class)
                    <li>
                        <a href="{{ route('user_search', ['students', 'class_id' => $class->id, 'search' => request('search')]) }}" class="text-blue-500 hover:underline">
                            {{ $class->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        {{-- Fonction JavaScript pour basculer l'affichage de la liste des classes --}}
        <script>
            function toggleClassList() {
                document.getElementById('classList').classList.toggle('hidden');
            }
        </script>
        @endif

        {{-- Boucle pour afficher chaque utilisateur --}}
        <div class="mt-4 space-y-4">
            @foreach ($users as $user)
                <div class="bg-white shadow-md rounded-lg flex items-center justify-between border p-4">
                    <a href="{{ route('user_info', ['role' => $role === 'Etudiant' ? 'students' : 'pilots', 'id' => $user->id]) }}" class="flex items-center space-x-4 w-full">
                        <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-12 h-12 rounded-full" alt="Avatar">
                        <div class="flex gap-4 items-center w-full">
                            {{-- Affichage des informations de l'utilisateur --}}
                            <p><strong>Id :</strong> {{ $user->id }}</p>
                            <div>
                                <p><strong>Nom :</strong> {{ $user->name }}</p>
                                <p><strong>Prénom :</strong> {{ $user->first_name }}</p>
                            </div>
                            <p><strong>Email :</strong> {{ $user->email }}</p>
                            @if ($role === 'Etudiant')
                                <p><strong>Promo :</strong> {{ $user->classe ? $user->classe->name : 'Aucune classe' }}</p>
                            @else
                                <p><strong>Classes :</strong> {{ $user->classesPilots->isNotEmpty() ? $user->classesPilots->pluck('name')->implode(', ') : 'Aucune classe' }}</p>
                            @endif
                            <p><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') ?? 'Non défini' }}</p>
                        </div>
                    </a>
                    {{-- Formulaire pour supprimer l'utilisateur --}}
                    <form action="{{ route('user_delete', ['id' => $user->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1.5 bg-red-500 text-white rounded-lg">X</button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Pagination de la liste des utilisateurs --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</main>
@endif
@endsection