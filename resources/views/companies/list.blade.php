@extends('layouts.app')

@section('title', 'Entreprises')

@section('content')

{{--  Verification de la présence d'une entreprise.  --}}

@if ($companies->isEmpty())
        <p class="text-gray-500">Aucune entreprise n'est sur le site</p>
    @else

    <div class="container mx-auto p-4">

        {{-- Message de succès --}}
        @if(session('success'))
            <div id="success-message" class="bg-green-500 text-white p-3 rounded-md mb-4 max-w-sm mx-auto inline-block">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold">Entreprises</h1>

        <div>
            @role('Admin|Pilote')
            <div class="mt-4 w-min h-auto">
                <a href="{{ route('company_register') }}">
                    <button
                        class="bg-blue-700 hover:bg-blue-400 text-white px-4 py-2 rounded-lg flex items-center justify-center w-max">Ajouter
                        une entreprise
                    </button>
                </a>
            </div>
            @endrole

            {{-- Formulaire de recherche --}}
            <form method="GET" action="{{ route('company_search') }}"
                class="flex flex-wrap gap-4 border p-4 rounded-md w-full m-2">
                <div class="flex w-full items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher une entreprise..." class="flex-1 border p-2 rounded-md">
                    <button type="submit"
                        class="bg-blue-700 hover:bg-blue-400 text-white px-4 py-2 rounded-md flex-none">Rechercher</button>
                </div>

                <div class="flex flex-col space-between w-full h-min p-2 m-2">
                    <div id="selected-sectors" class="flex flex-wrap flex-none gap-2"></div>
                    <div class="flex flex-wrap gap-2 w-full">
                        <select id="sector-select" class="border p-2 rounded-md m-2 w-min h-min">
                            <option value="">Sélectionner un secteur</option>
                            @foreach ($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                        <select name="city" class="border p-2 rounded-md m-2 w-min h-min">
                            <option value="">Toutes les villes</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}</option>
                            @endforeach
                        </select>
                        <select name="region" class="border p-2 rounded-md m-2 w-min h-min">
                            <option value="">Toutes les régions</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="sector" id="sector-input">
                        <select name="sort" class="border p-2 rounded-md m-2 ml-auto w-min">
                            <option value="">Trier par</option>
                            <option value="name_asc">Nom A-Z</option>
                            <option value="name_desc">Nom Z-A</option>
                            <option value="date_recent">Date récente</option>
                            <option value="date_old">Date ancienne</option>
                        </select>
                        <a href="{{ route('company_search') }}"
                            class="bg-blue-700 hover:bg-blue-400 text-white border text-center p-2 rounded-md m-2">Réinitialiser</a>
                    </div>
                </div>
            </form>


        </div>
        
        {{-- Conteneur des entreprises  --}}
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($companies as $company)
                <div
                    class="bg-white p-4 shadow-md rounded-lg border border-gray-200 hover:shadow-xl hover:scale-105 transition-transform duration-300 ease-in-out">
                    <a href="{{ route('company_info', ['id' => $company->id]) }}"
                        class="flex flex-col items-center text-center space-y-3">

                        <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-12 h-12 rounded-full" alt="Company">

                        <div>
                            <p class="text-lg font-semibold"><strong>Nom :</strong> {{ $company->name }}</p>
                            <p class="text-sm text-gray-600"><strong>Email :</strong> {{ $company->email }}</p>
                            <p class="text-sm text-gray-600"><strong>Téléphone :</strong>
                                {{ $company->tel_number ?? 'Non renseigné' }}</p>
                            <p class="text-sm text-gray-600"><strong>Secteurs :</strong>
                                {{ $company->sectors->isNotEmpty() ? $company->sectors->pluck('name')->implode(', ') : 'Aucun secteur' }}
                            </p>
                            <p class="text-sm text-gray-600"><strong>Adresse :</strong>
                                {{ $company->address ?? 'Non renseigné' }}</p>
                            <p class="text-sm text-gray-600"><strong>Région :</strong>
                                {{ optional($company->city->region)->name ?? 'Non défini' }}</p>
                            <p class="text-sm text-gray-500"><strong>Ville :</strong> {{ $company->city->name }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>
    </main>
    @endif
@endsection