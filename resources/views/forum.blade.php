@extends('layouts.app')

@section('title', 'Forum')

@section('content')

<main>
    <div class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold mb-8 text-center">Forum Communautaire</h1>

        <!-- Forum Categories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-2">Général</h2>
                <p class="text-gray-600 text-sm">Discussions générales autour du projet et de la communauté.</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-2">Aide & Support</h2>
                <p class="text-gray-600 text-sm">Posez vos questions et obtenez de l'aide de la communauté.</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-2">Suggestions</h2>
                <p class="text-gray-600 text-sm">Partagez vos idées d'amélioration et vos retours.</p>
            </div>
        </div>

        <!-- Liste des sujets -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!--overflow-hidden pour éviter les débordements -->
            <div class="border-b px-6 py-4 bg-gray-100">
                <h3 class="text-lg font-semibold">Derniers Sujets</h3>
            </div>
            <ul class="divide-y">
                <li class="px-6 py-4 hover:bg-gray-50 transition">
                    <a href="#" class="text-[#5A8E95] font-medium text-lg">Comment configurer Laravel pour un hébergement mutualisé ?</a>
                    <div class="text-sm text-gray-500 mt-1">Posté par <span class="font-medium">Alice</span> • il y a 2 heures • 12 réponses</div>
                </li>
                <li class="px-6 py-4 hover:bg-gray-50 transition">
                    <a href="#" class="text-[#5A8E95] font-medium text-lg">Bug sur l'affichage des composants Flowbite</a>
                    <div class="text-sm text-gray-500 mt-1">Posté par <span class="font-medium">Jean</span> • il y a 5 heures • 5 réponses</div>
                </li>
                <li class="px-6 py-4 hover:bg-gray-50 transition">
                    <a href="#" class="text-[#5A8E95] font-medium text-lg">Votre outil préféré pour le debugging Laravel ?</a>
                    <div class="text-sm text-gray-500 mt-1">Posté par <span class="font-medium">Sophie</span> • hier • 8 réponses</div>
                </li>
                <li class="px-6 py-4 hover:bg-gray-50 transition">
                    <a href="#" class="text-[#5A8E95] font-medium text-lg">Quel hébergeur utilisez-vous pour vos projets Laravel ?</a>
                    <div class="text-sm text-gray-500 mt-1">Posté par <span class="font-medium">Lucas</span> • il y a 3 jours • 7 réponses</div>
                </li>
                <li class="px-6 py-4 hover:bg-gray-50 transition">
                    <a href="#" class="text-[#5A8E95] font-medium text-lg">Best practices pour structurer ses vues Blade</a>
                    <div class="text-sm text-gray-500 mt-1">Posté par <span class="font-medium">Mélanie</span> • il y a 4 jours • 10 réponses</div>
                </li>
                <li class="px-6 py-4 hover:bg-gray-50 transition">
                    <a href="#" class="text-[#5A8E95] font-medium text-lg">Utilisation avancée d'Eloquent : vos astuces ?</a>
                    <div class="text-sm text-gray-500 mt-1">Posté par <span class="font-medium">Ahmed</span> • il y a 1 semaine • 15 réponses</div>
                </li>
            </ul>
        </div>
    </div>
</main>

@endsection