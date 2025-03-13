@extends('layouts.app')

@section('title', 'Votre Profile')

@section('content')
<div class="container mx-auto max-w-2xl p-6 bg-white rounded-lg shadow-md mt-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Profil de {{ $user->name }} {{ $user->first_name }}</h1>
    
    <div class="space-y-3">
        <p class="text-gray-700"><strong class="font-semibold">Email :</strong> {{ $user->email }}</p>
        <p class="text-gray-700"><strong class="font-semibold">Région :</strong> {{ $user->city->region->name ?? 'Non défini' }}</p>
        <p class="text-gray-700"><strong class="font-semibold">Ville :</strong> {{ $user->city->name ?? 'Non défini' }}</p>
        <p class="text-gray-700"><strong class="font-semibold">Rôle :</strong> {{ $user->role->name ?? 'Non défini' }}</p>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition">Retour</a>
    </div>
</div>
@endsection