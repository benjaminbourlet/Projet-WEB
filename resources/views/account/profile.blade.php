@extends('layouts.app')

@section('title', 'Votre Profile')


@section('content')
    <main>
        <div class="container mx-auto max-w-2xl p-6 bg-white rounded-lg shadow-md mt-10 mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Profil de {{ $user->name }} {{ $user->first_name }}</h1>

            <div class="mt-4">
                <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Logo">
            </div>

            <div class="space-y-3">
                <p class="text-gray-700"><strong class="font-semibold">Email :</strong> {{ $user->email }}</p>
                @if ($user->hasRole('Etudiant'))
                    <p class="text-gray-700"><strong class="font-semibold">Rôle :</strong> Etudiant</p>
                @elseif ($user->hasRole('Pilote'))
                    <p class="text-gray-700"><strong class="font-semibold">Rôle :</strong> Pilote</p>
                @elseif ($user->hasRole('Admin'))
                    <p class="text-gray-700"><strong class="font-semibold">Rôle :</strong> Admin</p>
                @endif

                <p class="text-gray-700"><strong class="font-semibold">Date de naissance :</strong>
                    {{ \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') ?? 'Non défini' }}
                </p>
                @if ($user->hasRole('Etudiant'))
                    <p class="text-gray-700"><strong class="font-semibold">Classe :</strong>
                        {{ $user->classe ? $user->classe->name : 'Aucune classe' }}
                    </p>
                @elseif ($user->hasRole('Pilote'))
                    <p class="text-gray-700"><strong class="font-semibold">Classe :</strong>
                        {{ $user->classesPilots->isNotEmpty() ? $user->classesPilots->pluck('name')->implode(', ') : 'Aucune classe' }}
                    </p>
                @endif
                <p class="text-gray-700"><strong class="font-semibold">Région :</strong>
                    {{ $user->city->region->name ?? 'Non défini' }} </p>
                <p class="text-gray-700"><strong class="font-semibold">Ville :</strong>
                    {{ ($user->city)->name ?? 'Non défini' }}</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition">Retour</a>
            </div>
        </div>
    </main>
@endsection