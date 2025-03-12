@extends('layouts.app')

@section('title', 'Entreprises')

    @include('partials.header')

    <main class="flex-grow container mx-auto p-4 flex gap-6">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold">Entreprises</h1>

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
            
            <form method="GET" action="{{ route('company.search') }}" class="mb-4 space-y-2">
                @csrf
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher une entreprise..." class="border p-2 rounded-md w-full">
            
                <!-- Filtre par secteur -->
                <select name="sector" class="border p-2 rounded-md w-full">
                    <option value="">Tous les secteurs</option>
                    @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}" {{ request('sector') == $sector->id ? 'selected' : '' }}>
                            {{ $sector->name }}
                        </option>
                    @endforeach
                </select>
            
                <!-- Filtre par ville -->
                <select name="city" class="border p-2 rounded-md w-full">
                    <option value="">Toutes les villes</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-md w-full">Filtrer</button>
            </form>
            

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($companies as $company)
                    <div
                        class="bg-white p-4 shadow-md rounded-lg border border-gray-200 hover:shadow-xl hover:scale-105 transition-transform duration-300 ease-in-out">
                        <a href="{{ route('company_info', ['id' => $company->id]) }}"
                            class="flex flex-col items-center text-center space-y-3">

                            <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-12 h-12 rounded-full"
                                alt="Company">

                            <div>
                                <p class="text-lg font-semibold"><strong>Nom :</strong> {{ $company->name }}</p>
                                <p class="text-sm text-gray-600"><strong>ID :</strong> {{ $company->id }}</p>
                                <p class="text-sm text-gray-600"><strong>Siret :</strong> {{ $company->siret }}</p>
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

@include('partials.footer')