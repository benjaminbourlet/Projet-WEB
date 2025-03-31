@extends('layouts.app')

@section('title', 'Mentions Légales')

@include('partials.header')

<main>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Mentions Légales</h1>

        <p><strong>1- Éditeur du site :</strong><br>
            Stage Finder<br>
            Adresse : 16 Rue Magellan, 31670 Labège, France<br>
            Email : contact@stagefinder.com<br>
            Directeur de la publication : Maitre Maxime Moysset</p>

        <p><strong>2- Hébergement :</strong><br>
            Nom de l’hébergeur : Laravel Cloud<br>
            Adresse : 58 Boulevard du Doyenné Cité des associations - 49000 Angers<br>
            Téléphone : +33 9 72 10 10 07</p>

        <p><strong>3- Propriété intellectuelle :</strong><br>
            L’ensemble du contenu du site Stage Finder (textes, images, logo, etc.) est protégé par les droits d’auteur.
        </p>

        <p><strong>4- Protection des données personnelles :</strong><br>
            Les données collectées sur le site sont destinées à améliorer l’expérience des utilisateurs et ne seront en
            aucun cas revendues à des tiers.</p>

        <p><strong>5- Cookies :</strong><br>
            Lors de votre navigation, des « cookies » peuvent être stockés dans votre ordinateur. Ces « cookies »
            enregistre des informations relatives à votre navigation sur le site Stage Finder comme les pages
            consultées, l'horodatage des consultations, etc. Vous pouvez à tout moment vous opposer à cela au travers de
            votre navigateur :
            <br><br>
            Dans Chrome :
            Menu > Paramètres > Afficher les paramètres avancés (situé au bas de la page).
            Il faut ensuite cliquer sur le bouton "Paramètres de contenu" puis cocher la case "Bloquer les cookies et
            les données de sites tiers", enfin cliquer sur OK pour valider votre choix.
            <br><br>
            Dans Firefox :
            Menu > Options > Onglet "Vie privée"
            Paramétrer le menu "Règles de conservation" sur "Utiliser les paramètres personnalisés pour l'historique".
            <br><br>
            Dans Microsoft Edge :
            Menu > Paramètres > Cookies et autorisations de site > Gérer et supprimer les cookies et les données du site
            Il faut cliquer sur le bouton "Ajouter" du bloc "Bloquer" puis ajouter l'URL du site et valider.</p>

        <p><strong>Contact :</strong><br>
            Pour toute question relative aux mentions légales, vous pouvez nous contacter à l’adresse email :
            contact@stagefinder.com.</p>
    </div>
</main>
@include('partials.footer')