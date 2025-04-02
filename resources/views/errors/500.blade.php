@extends('layouts.app')

@section('title', 'Oups ! Erreur 500')


@section('content')
<main class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-10 max-w-3xl text-center">
    <img src="storage/images/500.png" alt="Erreur 500" class="mx-auto w-64">
    <h1 class="text-4xl font-bold text-red-600 mt-6">Oups ! Un stagiaire a tout cassé...</h1>
    <p class="text-gray-700 mt-4">On dirait que notre serveur a pris une pause café un peu trop longue ☕. Ne vous inquiétez pas, nous réglons ça rapidement !</p>
    <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Retour à l'accueil</a>
</main>
@endsection
