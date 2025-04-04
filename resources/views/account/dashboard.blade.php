@extends('layouts.app')
{{-- Ce fichier étend le layout principal de l'application et sert à afficher le tableau de bord de l'utilisateur --}}

@section('title', 'Dashboard')
{{-- Le titre de la page est défini ici en tant que "Dashboard" --}}

@section('content')
{{-- Contenu principal du tableau de bord de l'utilisateur --}}

{{-- Zone principale du dashboard avec un fond dégradé pour un visuel attrayant --}}
<main class="min-h-screen bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 py-10">
    <div class="container mx-auto max-w-5xl px-6">
        {{-- Titre principal du Dashboard --}}
        <h1 class="mb-8 text-5xl font-bold text-center text-white drop-shadow-lg">
            <!-- drop-shadow-lg : ajoute un effet d'ombre large à un élément, lui donnant une apparence de profondeur ou de relief. -->
            Tableau de Bord
        </h1>

        {{-- Carte des candidatures : affiche le nombre total de candidatures --}}
        <div class="flex flex-wrap gap-4">
            <!-- flex-wrap : permet aux éléments enfants de se répartir sur plusieurs lignes si l'espace est insuffisant. -->
            <div class="w-full md:w-1/3 bg-gradient-to-br from-green-400 to-green-600 p-6 rounded-xl shadow-xl transform transition duration-500 hover:scale-105">
                <div class="mb-2 text-lg font-semibold text-white">Nombre de candidatures</div>
                <div class="text-4xl font-bold text-white">{{ $totalApplications }}</div>
            </div>
        </div>

        {{-- Liste des compétences les plus demandées --}}
        <h2 class="mt-10 mb-4 text-3xl font-semibold text-white">
            Compétences les plus demandées
        </h2>
        <ul class="space-y-4">
            @foreach($topSkills as $skill)
                <li class="flex items-center justify-between p-4 bg-gray-800 rounded-lg shadow border border-gray-700 transform transition duration-300 hover:scale-105">
                    <span class="text-sm text-white">{{ $skill->name }}</span>
                    <span class="px-3 py-1 bg-blue-600 text-white rounded-full text-xs font-bold">
                        {{ $skill->count }}
                    </span>
                </li>
            @endforeach
        </ul>

        {{-- Graphique des candidatures : représentation visuelle des statuts des candidatures --}}
        <div class="mt-4 flex justify-center max-w-md mx-auto">
            <canvas id="applicationsChart"
                class="w-full bg-white/10 p-2 rounded-xl shadow-xl"
                data-accepted="{{ $acceptedApplications }}"
                data-rejected="{{ $rejectedApplications }}"
                data-pending="{{ $pendingApplications }}"
                data-traitement="{{ $traitementApplications }}"
                data-interview="{{ $interviewApplications }}"
                width="50" height="50">
            </canvas>
        </div>
    </div>
</main>
@endsection