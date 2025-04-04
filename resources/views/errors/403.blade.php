@extends('layouts.app')

@section('title', 'Accès Interdit')


@section('content')

{{--  Page d'erreur 403  --}}

<main class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-10 max-w-3xl text-center">
    <img src="{{ asset('storage/images/403.png') }}" alt="Accès interdit" class="mx-auto w-64 mb-6">
    <h1 class="text-4xl font-bold text-red-600">403 - Accès Interdit</h1>
    <p class="text-gray-700 mt-4">Oups... Il semble que vous essayez d'accéder à une zone réservée.</p>
    <p class="text-gray-500 italic mt-2">(Même nos stagiaires n'ont pas encore le droit d'y aller !) </p>
    <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
        Retour à l'accueil
    </a>
    <p class="text-sm text-gray-400 mt-4">Si vous pensez qu'il s'agit d'une erreur, contactez-nous.</p>
</main>

@endsection