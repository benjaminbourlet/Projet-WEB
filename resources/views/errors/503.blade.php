@extends('layouts.app')

@section('title', 'Erreur 503 - Service Indisponible')


@section('content')
<main class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-10 max-w-3xl text-center">
    <img src="#" alt="Erreur 503" class="mx-auto rounded-lg">
    <h1 class="text-4xl font-bold text-red-600 mt-6">Oups ! Service Indisponible</h1>
    <p class="mt-4 text-gray-700">Même les meilleurs stagiaires ont besoin d'une pause...</p>
    <p class="mt-2 text-gray-500">Notre site est momentanément en panne. Revenez plus tard ou tentez une actualisation.</p>
    <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600">Retour à l'accueil</a>
    <p class="mt-4 text-gray-400 text-sm">Erreur 503 - Stage Finder</p>
</main>
@endsection
