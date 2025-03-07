@extends('layouts.app')

@section('title', 'Informations de ' . $user->name)

@include('partials.header')

<main class="flex-grow container mx-auto p-6 min-h-screen">
<div class="flex mt-10 bg-[#EEEEEE]">
    <div class="w-1/3 bg-[#387077] rounded-lg shadow-lg">
        <div class="max-w-md mx-auto mt-6 p-6">
        
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold">Profil de {{ $user->name }}</h1>

            <div class="mt-4">
                <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Logo">
            </div>

            <div class="mb-4">
                <label class="block font-bold"> Nom :</label>
                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">{{ $user->name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Prenom :</label>
                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">{{ $user->first_name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Adresse mail :</label>
                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">{{ $user->email ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Date de naissance :</label>
                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                    {{ \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') ?? 'Non défini' }}
                </p>
            </div>

            @if ($role === 'Etudiant')
                <div class="mb-4">
                    <label class="block font-bold">Classe (Promo) :</label>
                    <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                        {{ $user->classe ? $user->classe->name : 'Aucune classe' }}
                    </p>
                </div>
            @elseif ($role === 'Pilote')
                <div class="mb-4">
                    <label class="block font-bold">Classes :</label>
                    <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                        {{ $user->classesPilots->isNotEmpty() ? $user->classesPilots->pluck('name')->implode(', ') : 'Aucune classe' }}
                    </p>
                </div>
            @endif


            <div class="mb-4">
                <label class="block font-bold">Région :</label>
                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">{{ $user->city->region->name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Ville :</label>
                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">{{ ($user->city)->name ?? 'Non défini' }}</p>
            </div>
        </div>
        <!-- Boutons de modification et de suppression -->
        <div class="mb-4 flex justify-between">
            <!-- Bouton Modifier -->
            <a href="{{ route('user_edit', ['role' => $role === 'Etudiant' ? 'students' : 'pilots', 'id' => $user->id]) }}"
                class="bg-[#3D9DA9] text-white px-4 py-2 rounded-lg hover:bg-[#3D8A8F]">
                Modifier
            </a>

            <form action="{{ route('user_delete', ['id' => $user->id]) }}" method="POST"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-[#8C3740] text-white px-4 py-2 rounded-lg hover:bg-[#70383E]">
                    Supprimer
                </button>
            </form>

        </div>
        </div>
    </div>
    <div class="w-2/3">
        /* À modifier pour afficher les stats */
        <div class="max-w-md mx-auto mt-10 bg-gray p-6 rounded-lg shadow-lg">
        
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold">Profil de {{ $user->name }}</h1>

            <div class="mt-4">
                <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Logo">
            </div>

            <div class="mb-4">
                <label class="block font-bold"> Nom :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $user->name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Prenom :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $user->first_name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Adresse mail :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $user->email ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Date de naissance :</label>
                <p class="border p-2 w-full bg-gray-100">
                    {{ \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') ?? 'Non défini' }}
                </p>
            </div>

            @if ($role === 'Etudiant')
                <div class="mb-4">
                    <label class="block font-bold">Classe (Promo) :</label>
                    <p class="border p-2 w-full bg-gray-100">
                        {{ $user->classe ? $user->classe->name : 'Aucune classe' }}
                    </p>
                </div>
            @elseif ($role === 'Pilote')
                <div class="mb-4">
                    <label class="block font-bold">Classes :</label>
                    <p class="border p-2 w-full bg-gray-100">
                        {{ $user->classesPilots->isNotEmpty() ? $user->classesPilots->pluck('name')->implode(', ') : 'Aucune classe' }}
                    </p>
                </div>
            @endif


            <div class="mb-4">
                <label class="block font-bold">Région :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $user->city->region->name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Ville :</label>
                <p class="border p-2 w-full bg-gray-100">{{ ($user->city)->name ?? 'Non défini' }}</p>
            </div>
        </div>
        <!-- Boutons de modification et de suppression -->
        <div class="mb-4 flex justify-between">
            <!-- Bouton Modifier -->
            <a href="{{ route('user_edit', ['role' => $role === 'Etudiant' ? 'students' : 'pilots', 'id' => $user->id]) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Modifier
            </a>

            <form action="{{ route('user_delete', ['id' => $user->id]) }}" method="POST"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Supprimer
                </button>
            </form>

        </div>
        </div>
    </div>
</div>
</main>

@include('partials.footer')