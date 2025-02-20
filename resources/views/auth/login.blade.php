@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6">Connexion</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" id="email" name="email" required class="w-full mt-1 p-2 border rounded-md">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Mot de passe</label>
            <input type="password" id="password" name="password" required class="w-full mt-1 p-2 border rounded-md">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Se connecter</button>
        <p class="text-center text-sm mt-4">Pas encore inscrit ? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Créer un compte</a></p>
    </form>
</div>
@endsection
