@extends('layouts.app')

@section('title', 'Page Introuvable')


@section('content')

{{-- Page d'erreur 404 --}}
<main class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-10 max-w-3xl text-center">
    <img src="{{ asset('storage/images/404.png') }}" alt="Erreur 404" class="mx-auto w-64">
    <h1 class="text-3xl font-bold mt-6">Oups... Cette page a pris un stage ailleurs !</h1>
    <p class="text-gray-600 mt-4">Il semblerait que la page que vous cherchez ait trouvé une meilleure opportunité... ou n’ait jamais existé. 😅</p>
    <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
        Retour à l'accueil
    </a>
</main>
@endsection
