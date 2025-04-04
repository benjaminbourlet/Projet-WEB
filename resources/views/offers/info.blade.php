@extends('layouts.app')

@section('title', 'Informations sur ' . $offer->title)

@section('content')
<div class="flex gap-6 px-2 mt-4">
    <!-- Conteneur principal de l'offre -->
    <div class="bg-[#5A8E95] shadow-md rounded-2xl flex flex-col justify-between items-center border border-[#5A8E95] gap-2 p-2 mb-4 max-w-3/4 mx-auto">

        <!-- Section titre et wishlist -->
        <div class="flex items-center">
            @if (auth()->user()->wishlists->contains($offer->id))
            <!-- Formulaire pour retirer l'offre de la wishlist -->
            <form action="{{ route('wishlist_remove', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}" method="POST" class="flex items-center h-auto mr-2">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                    <!-- Icône de cœur plein -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" stroke="black" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>
            </form>
            @else
            <!-- Formulaire pour ajouter l'offre à la wishlist -->
            <form action="{{ route('wishlist_add', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}" method="POST" class="flex items-center h-auto">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-gray-700 focus:outline-none mr-2">
                    <!-- Icône de cœur vide -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" stroke="black" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3c3.08 0 5.5 2.42 5.5 5.5 0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>
            </form>
            @endif
            <!-- Titre de l'offre -->
            <h4 class="text-xl text-white font-bold text-center md:text-left">
                {{ $offer->title }}
            </h4>
        </div>

        <!-- Informations sur l'entreprise et la période du stage -->
        <div class="flex flex-row items-center justify-between">
            <h6 class="text-white text-center flex-1">
                {{ $offer->company->name }} <!-- Nom de l'entreprise -->
            </h6>
            <span class="mx-2 w-[1px] bg-white self-stretch"></span> <!-- Séparateur -->
            <p class="text-white mx-2 text-center flex-1">
                {{ \Carbon\Carbon::parse($offer->start_date)->translatedFormat('d F Y') }} to {{ \Carbon\Carbon::parse($offer->end_date)->translatedFormat('d F Y') }}
            </p> <!-- Dates de début et fin -->
        </div>

        <!-- Informations supplémentaires : localisation, salaire -->
        <div class="flex justify-center flex-col md:flex-row px-4 gap-4">
            <div class="flex items-center">
                <!-- Icône localisation -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-6 h-6">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 10.5c-1.93 0-3.5-1.57-3.5-3.5S10.07 5.5 12 5.5s3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z" />
                </svg>
                <p class="text-white text-lg">{{ $offer->company->city->name }}</p> <!-- Ville -->
            </div>
            <div class="flex items-center">
                <p class="text-white">
                    <span class="font-bold">Salaire :</span>
                    <span>{{ $offer->salary}}</span> € <!-- Salaire -->
                </p>
            </div>
        </div>

        <!-- Département concerné -->
        <div class="text-white flex justify-start items-center inline-block">
            <label class="block font-bold">Département :</label>
            <p class="px-2 max-w-max">
                {{ $offer->departments->isNotEmpty() ? $offer->departments->pluck('name')->implode(', ') : 'Aucun département' }}
            </p>
        </div>

        <!-- Description de l'offre -->
        <div class="mb-4">
            <label class="block font-bold text-white">Description de l'offre :</label>
            <p class="text-white px-4">{{ $offer->description ?? 'Non défini' }}</p>
        </div>

        <!-- Compétences requises -->
        <div class="px-4">
            <label class="block font-bold text-white">Compétences :</label>
            <div class="flex flex-wrap gap-2 mt-2 justify-center items-center">
                @foreach ($offer->skills as $skill)
                <p class="inline-block bg-[#387077] text-white text-sm px-4 py-1.5 rounded-full border border-white">
                    {{ $skill->name }}
                </p>
                @endforeach
            </div>
        </div>

        <!-- Statistiques -->
        <div class="m-4 text-gray-200 text-center">
            <p>Nombre d'étudiants ayant postulé : {{ $applicationsCount }}</p>
            <p>Nombre d'étudiants ayant mis en wishlist : {{ $wishlistsCount }}</p>
        </div>

        <!-- Bouton de candidature (visible pour les rôles Admin et Étudiant) -->
        @role('Admin|Etudiant')
        <div class="flex gap-6">
            <a href="{{ route('offer_apply', [$offer->id, 'title' => Str::slug($offer->title)]) }}"
                class="bg-[#3D9DA9] text-white text-lg px-4 py-1.5 rounded-full hover:bg-[#3D8A8F] border border-white cursor-pointer">
                Candidater
            </a>
        </div>
        @endrole

        <!-- Bouton de retour -->
        <a href="javascript:window.history.back();" class="inline-block text-gray-200 hover:underline">
            Retour
        </a>

        <!-- Boutons Modifier/Supprimer pour Admin et Pilote -->
        @role('Admin|Pilote')
        <div class="flex gap-6">
            <a href="{{ route('offer_edit', [$offer->id, 'title' => Str::slug($offer->title)]) }}"
                class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">
                Modifier
            </a>

            <form action="{{ route('offer_delete', ['id' => $offer->id]) }}" method="POST"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-900">
                    Supprimer
                </button>
            </form>
        </div>
        @endrole

    </div>
</div>
@endsection