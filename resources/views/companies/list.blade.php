@extends('layouts.app')

@section('title', 'Entreprises')

@include('partials.header')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Entreprises</h1>

        @role('Admin|Pilote')
        <div class="mt-4">
            <a href="{{ route('company_register') }}">
                <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">+ Ajouter une entreprise</button>
            </a>
        </div>
        @endrole

        <div class="mt-4 space-y-4">
            @foreach ($companies as $company)
                <div class="bg-white p-4 shadow-md rounded-lg flex items-center justify-between border border-gray-200">
                    <a href="{{ route('company_info', ['id' => $company->id]) }}"
                        class="flex items-center space-x-4">
                        
                        <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-12 h-12 rounded-full" alt="Company">

                        <div>
                            <p><strong>ID :</strong> {{ $company->id }}</p>
                            <p><strong>Nom :</strong> {{ $company->name }}</p>
                            <p><strong>Siret :</strong> {{ $company->siret }}</p>
                            <p><strong>Email :</strong> {{ $company->email }}</p>
                            <p><strong>Téléphone :</strong> {{ $company->tel_number ?? 'Non renseigné' }}</p>
                            <p><strong>Secteurs :</strong> {{ $company->sectors->isNotEmpty() ? $company->sectors->pluck('name')->implode(', ') : 'Aucun secteur' }}</p>
                            <p><strong>Adresse :</strong> {{ $company->address ?? 'Non renseigné' }}</p>
                            <p><strong>Région :</strong> {{ optional($company->city->region)->name ?? 'Non défini' }}</p>
                            <p><strong>Ville :</strong> {{ $company->city->name }}</p>
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
@endsection
