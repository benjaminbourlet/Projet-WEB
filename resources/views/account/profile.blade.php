@extends('layouts.app')
{{-- Ce fichier étend le layout principal de l'application --}}

{{-- Section du titre de la page du profil de l'utilisateur --}}
@section('title', 'Votre Profile')

{{-- Contenu principal de la page de profil --}}
@section('content')

    {{-- Conteneur principal avec un fond dégradé pour un visuel attrayant --}}
    <main class="min-h-screen bg-gradient-to-br from-[#5A8E95] to-[#5DE0E6] py-10">
        
        {{-- Conteneur de la carte de profil avec un effet d'ombre et de transition --}}
        <div class="container mx-auto max-w-3xl p-8 bg-white rounded-xl shadow-lg transform transition duration-500 hover:scale-105">
            
            {{-- Titre affichant le nom complet de l'utilisateur --}}
            <h1 class="text-4xl font-bold text-center text-gray-900 mb-6 animate-fadeIn">
                Profil de {{ $user->name }} {{ $user->first_name }}
            </h1>
            
            {{-- Section pour l'affichage de la photo de profil de l'utilisateur --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-40 h-40 rounded-full ring-4 ring-indigo-300 shadow-lg transition-transform duration-300 hover:scale-110" alt="Logo">
            </div>
            
            {{-- Grille affichant les informations principales de l'utilisateur --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-lg font-medium text-gray-800">{{ $user->email }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Rôle</p>
                    <p class="text-lg font-medium text-gray-800">
                        @if ($user->hasRole('Etudiant'))
                            Etudiant
                        @elseif ($user->hasRole('Pilote'))
                            Pilote
                        @elseif ($user->hasRole('Admin'))
                            Admin
                        @endif
                    </p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Date de naissance</p>
                    <p class="text-lg font-medium text-gray-800">{{ \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') ?? 'Non défini' }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Région</p>
                    <p class="text-lg font-medium text-gray-800">{{ $user->city->region->name ?? 'Non défini' }}</p>
                </div>
            </div>
            
            {{-- Section affichant la ville de l'utilisateur --}}
            <div class="p-4 bg-gray-50 rounded-lg shadow items-center text-center mt-4">
                <p class="text-sm text-gray-600">Ville</p>
                <p class="text-lg font-medium text-gray-800">{{ ($user->city)->name ?? 'Non défini' }}</p>
            </div>
            
            {{-- Bouton de retour à la page d'accueil --}}
            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-[#5A8E95] text-white font-semibold rounded-full shadow-md hover:bg-[#5DE0E6] transition duration-300">
                    Retour
                </a>
            </div>
        </div>
    </main>
@endsection