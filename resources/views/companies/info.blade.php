@extends('layouts.app')

@section('title', 'Informations de ' . $company->name)

@section('content')

    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">


        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold">Profil de {{ $company->name }}</h1>

            <div class="mt-4">
                <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Logo">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Numéro de Siret :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->siret ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Adresse mail :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->email ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Numéro de téléphone :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->tel_number ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Description :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->description ?? 'Non renseigné' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Numéro de téléphone :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->address ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Secteur :</label>
                <p class="border p-2 w-full bg-gray-100">
                    {{ $company->sectors->isNotEmpty() ? $company->sectors->pluck('name')->implode(', ') : 'Aucun secteur' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Région :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->city->region->name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Ville :</label>
                <p class="border p-2 w-full bg-gray-100">{{ ($company->city)->name ?? 'Non défini' }}</p>
            </div>
        </div>

        <!-- Bouton Modifier -->
        <a href="{{ route('evaluations_create', $company->id) }}"
            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
            Doner un avis
        </a>

        <!-- Bouton Modifier -->
        <a href="{{ route('evaluations_company_list', $company->id) }}"
            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
            Afficher les avis
        </a>


        @role('Admin|Pilote')
        <div class="flex gap-6">
            <!-- Boutons de modification et de suppression -->
            <div class="mb-4 flex justify-between">
                <!-- Bouton Modifier -->
                <a href="{{ route('company_edit', $company->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Modifier
                </a>

            </div>

            <!-- Bouton Supprimer -->
            <form action="{{ route('company_delete', ['id' => $company->id]) }}" method="POST"
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

    <div class="w-2/3">
        <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">Dernières Offres</h2>
            @if ($company->offers->isEmpty())
                <p>Aucune offre récente.</p>
            @else
                <ul>
                    @foreach ($company->offers->take(3) as $offer)
                        <li class="border-b py-2">
                            <strong>Offre :</strong> {{ $offer->title ?? 'Non défini' }} <br>
                            <span class="text-gray-500 text-sm">Déposée le
                                {{ optional($offer->created_at)->format('d/m/Y') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mb-4 flex justify-between">
                <!-- Bouton Modifier -->
                <a href="{{ route('company_offers', $company->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Liste des offres
                </a>

            </div>
        </div>

@endsection