@extends('layouts.app')

@section('title', 'Informations sur ' . $offer->title)

@section('content')

    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold">Information sur {{ $offer->title }}</h1>

            <div class="mb-4">
                <label class="block font-bold">Description de l'offre :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $offer->description ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Date de début :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $offer->start_date ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Date de fin :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $offer->end_date ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Salaire :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $offer->salary ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Description :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $offer->description ?? 'Non renseigné' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Entreprise :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $offer->company->name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Departement :</label>
                <p class="border p-2 w-full bg-gray-100">
                    {{ $offer->departments->isNotEmpty() ? $offer->departments->pluck('name')->implode(', ') : 'Aucun departement' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Compétences :</label>
                <p class="border p-2 w-full bg-gray-100">
                    {{ $offer->skills->isNotEmpty() ? $offer->skills->pluck('name')->implode(', ') : 'Aucune compétences' }}
                </p>
            </div>
        @role('Admin|Pilote')
        <div class="flex gap-6">
            <!-- Boutons de modification et de suppression -->
            <div class="mb-4 flex justify-between">
                <!-- Bouton Modifier -->
                <a href="{{ route('offer_edit', $offer->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Modifier
                </a>

            </div>

            <!-- Bouton Supprimer -->
            <form action="{{ route('offer_delete', ['id' => $offer->id]) }}" method="POST"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Supprimer
                </button>
            </form>
        </div>
        @endrole
    </div>

@endsection