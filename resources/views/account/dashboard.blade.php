@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="text-center mt-10">
    <h1 class="text-3xl font-bold">Bienvenue, {{ auth()->user()->first_name }}</h1>
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
    @csrf
    <button type="submit" class="bg-red-500 text-white p-2 rounded-md">Déconnexion</button>
</form>
<div class="mt-6">
        <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition">Retour</a>
    </div>
</div>
@endsection
