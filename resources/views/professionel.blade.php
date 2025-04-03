@extends('layouts.app')

@section('title', 'Professionel')

@section('content')

<main>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold mb-8 text-center">Annuaire des Professionnels</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md hover:scale-105 hover:bg-blue-50 transition duration-300 ease-in-out">
                <!-- hover:scale-105 : s'agrandit légèrement au survol -->
                <div class="flex items-center space-x-4 mb-4">
                    <img src="https://i.pravatar.cc/100?img=11" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                    <!-- object-cover : pour garder le ratio d'image -->
                    <div>
                        <h2 class="text-xl font-semibold">Elon Musk</h2>
                        <p class="text-sm text-gray-500">Entrepreneur & Innovateur</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">Fondateur de SpaceX, Tesla, Neuralink, il révolutionne les industries de l'automobile, de l'énergie et de l'aérospatiale.</p>
                <div class="text-sm text-gray-500">📍 Austin, Texas | ✉️ elon@tesla.com</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md hover:scale-105 hover:bg-blue-50 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-4 mb-4">
                    <img src="https://i.pravatar.cc/100?img=12" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h2 class="text-xl font-semibold">Marie Curie</h2>
                        <p class="text-sm text-gray-500">Physicienne & Chimiste</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">Pionnière dans le domaine de la radioactivité, première femme à recevoir un prix Nobel et seule personne à en recevoir deux dans des domaines scientifiques différents.</p>
                <div class="text-sm text-gray-500">📍 Varsovie, Pologne | ✉️ marie.curie@exemple.com</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md hover:scale-105 hover:bg-blue-50 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-4 mb-4">
                    <img src="https://i.pravatar.cc/100?img=13" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h2 class="text-xl font-semibold">Ada Lovelace</h2>
                        <p class="text-sm text-gray-500">Mathématicienne & Informaticienne</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">Considérée comme la première programmeuse informatique pour son travail sur la machine analytique de Charles Babbage.</p>
                <div class="text-sm text-gray-500">📍 Londres, Royaume-Uni | ✉️ ada.lovelace@exemple.com</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md hover:scale-105 hover:bg-blue-50 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-4 mb-4">
                    <img src="https://i.pravatar.cc/100?img=14" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h2 class="text-xl font-semibold">Steve Jobs</h2>
                        <p class="text-sm text-gray-500">Co-fondateur d'Apple Inc.</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">Visionnaire derrière des produits révolutionnaires comme l'iPhone et l'iPad, il a redéfini l'industrie technologique.</p>
                <div class="text-sm text-gray-500">📍 Cupertino, Californie | ✉️ steve.jobs@apple.com</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md hover:scale-105 hover:bg-blue-50 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-4 mb-4">
                    <img src="https://i.pravatar.cc/100?img=15" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h2 class="text-xl font-semibold">Tim Berners-Lee</h2>
                        <p class="text-sm text-gray-500">Inventeur du World Wide Web</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">Il a créé le premier site web et a joué un rôle clé dans le développement de la structure d'Internet tel que nous le connaissons aujourd'hui.</p>
                <div class="text-sm text-gray-500">📍 Londres, Royaume-Uni | ✉️ tim@w3.org</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md hover:scale-105 hover:bg-blue-50 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-4 mb-4">
                    <img src="https://i.pravatar.cc/100?img=16" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h2 class="text-xl font-semibold">Mark Zuckerberg</h2>
                        <p class="text-sm text-gray-500">Co-fondateur de Facebook</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">Il a transformé la manière dont les gens communiquent et interagissent à travers les réseaux sociaux.</p>
                <div class="text-sm text-gray-500">📍 Palo Alto, Californie | ✉️ mark@facebook.com</div>
            </div>
        </div>
    </div>
</main>

@endsection