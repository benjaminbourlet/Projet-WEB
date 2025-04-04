@extends('layouts.app')
{{-- Ce fichier étend le layout principal de l'application --}}

@section('title', 'Connexion')
{{-- Définition du titre de la page de connexion --}}

@section('content')

<!-- Conteneur principal de la page de connexion -->
<div class="py-40 lg:py-60 md:py-20 flex items-center justify-center">
  <!-- Conteneur global avec ombre et dimensions adaptatives -->
  <div class="bg-white shadow-md max-w-md md:max-w-3xl lg:max-w-4xl md:h-auto lg:h-full lg:max-h-screen md:flex rounded-lg">
    
    <!-- Partie gauche : Message de bienvenue (affiché uniquement sur les écrans moyens et larges) -->
    <div class="hidden md:flex md:flex-col md:justify-center md:w-1/2 bg-[#387077] text-white p-10 rounded-lg">
      <h1 class="text-4xl font-bold">Bonjour, Bienvenue !</h1>
      <p class="mt-4">Nous sommes très heureux de vous retrouver.</p>
    </div>
    
    <!-- Partie droite : Formulaire de connexion -->
    <div class="w-full p-6 md:w-1/2 bg-gray-100">
      <!-- Titre du formulaire -->
      <h2 class="text-2xl text-center font-bold mb-6">Connexion</h2>
      
      <!-- Début du formulaire de connexion -->
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Champ Email -->
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email</label>
          <input type="email" id="email" name="email"
            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-teal-500 bg-gray-300"
            required>
          @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        
        <!-- Champ Mot de passe -->
        <div class="mb-6">
          <label for="password" class="block text-gray-700">Mot de passe</label>
          <input type="password" id="password" name="password"
            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-teal-500 bg-gray-300"
            required>
          @error('password')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        
        <!-- Bouton de soumission du formulaire -->
        <button type="submit"
          class="w-full bg-[#387077] text-white py-2 rounded-md hover:bg-teal-600 transition duration-300">
          Se connecter
        </button>
      </form>
      <!-- Fin du formulaire de connexion -->
    </div>
    <!-- Fin de la partie droite -->
  </div>
  <!-- Fin du conteneur global -->
</div>
<!-- Fin du conteneur principal -->

@endsection