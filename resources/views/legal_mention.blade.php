@extends('layouts.app')

@section('title', 'Mentions Légales')

@include('partials.header')

@section('content')
<main class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-10 max-w-3xl">
    <h1 class="text-center text-4xl font-extrabold text-blue-600 mb-6">Mentions Légales</h1>

    <div class="space-y-6 text-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">1. Éditeur du site</h2>
            <p class="text-gray-700">
                <strong>Stage Finder</strong><br>
                Adresse : 16 Rue Magellan, 31670 Labège, France<br>
                Email : <a href="mailto:contact@stagefinder.com" class="text-blue-500 hover:underline">contact@stagefinder.com</a><br>
                Directeur de la publication : Maitre Maxime Moysset
            </p>
        </div>
<br>
        <div>
            <h2 class="text-xl font-semibold text-gray-800">2. Hébergement</h2>
            <p class="text-gray-700">
                <strong>Laravel Cloud</strong><br>
                Adresse : 58 Boulevard du Doyenné, 49000 Angers<br>
                Téléphone : <a href="tel:+33972101007" class="text-blue-500 hover:underline">+33 9 72 10 10 07</a>
            </p>
        </div>
<br>
        <div>
            <h2 class="text-xl font-semibold text-gray-800">3. Propriété intellectuelle</h2>
            <p class="text-gray-700">
                L’ensemble du contenu du site Stage Finder (textes, images, logo, etc.) est protégé par les droits d’auteur.
            </p>
        </div>
<br>
        <div>
            <h2 class="text-xl font-semibold text-gray-800">4. Protection des données personnelles</h2>
            <p class="text-gray-700">
                Les données collectées sur le site sont destinées à améliorer l’expérience des utilisateurs et ne seront en aucun cas revendues à des tiers.
            </p>
        </div>
<br>
        <div>
            <h2 class="text-xl font-semibold text-gray-800">5. Cookies</h2>
            <p class="text-gray-700">
                Lors de votre navigation, des « cookies » peuvent être stockés dans votre ordinateur. Vous pouvez à tout moment gérer ces cookies via votre navigateur :
            </p>
            <ul class="list-disc list-inside text-gray-700 mt-2 space-y-2">
                <li><strong>Chrome :</strong> Menu > Paramètres > Afficher les paramètres avancés > Paramètres de contenu > Bloquer les cookies et les données de sites tiers.</li>
                <li><strong>Firefox :</strong> Menu > Options > Vie privée > Utiliser les paramètres personnalisés pour l'historique.</li>
                <li><strong>Edge :</strong> Menu > Paramètres > Cookies et autorisations de site > Gérer et supprimer les cookies.</li>
            </ul>
        </div>
<br>
        <div>
            <h2 class="text-xl font-semibold text-gray-800">6. Contact</h2>
            <p class="text-gray-700">
                Pour toute question relative aux mentions légales, vous pouvez nous contacter à l’adresse email :
                <a href="mailto:contact@stagefinder.com" class="text-blue-500 hover:underline">contact@stagefinder.com</a>.
            </p>
        </div>
<br>
        <div>
            <h2 class="text-xl font-semibold text-gray-800">7. Crédits</h2>
            <p class="text-gray-700">
                Ce site a été conçu et développé par <strong>Stage Finder</strong>.  
                Certaines ressources utilisées sur ce site peuvent provenir de sources externes libres de droits, 
                respectant les licences en vigueur.
            </p>
        </div>
<br>
    </div>
</main>
@include('partials.footer')
@endsection