@extends('layouts.app')

@section('title', 'Accueil')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesi ton stage</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.3/flowbite.min.js"></script>
</head>
<body class="bg-white">
    @include('partials.header')

<!-- Script JavaScript pour le menu déroulant -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const accountBtn = document.getElementById("accountBtn");
        const accountMenu = document.getElementById("accountMenu");

        accountBtn.addEventListener("click", function () {
            accountMenu.classList.toggle("hidden");
        });

        // Fermer le menu si on clique ailleurs
        document.addEventListener("click", function (event) {
            if (!accountBtn.contains(event.target) && !accountMenu.contains(event.target)) {
                accountMenu.classList.add("hidden");
            }
        });
    });
</script>



<body class="bg-white">
    
    <div class="container mx-auto pt-20 text-center">
        <div class="relative w-2/3 mx-auto flex items-center">
            <button class="absolute left-3 top-1/2 -translate-y-1/2 bg-[#387077] p-2 rounded-full">
                <img src="{{ asset('images/loupe_recherche.png') }}" alt="Recherche" class="w-8 h-8">
            </button>
            <input type="text" class="w-full pl-16 p-4 border-2 border-black rounded-full text-lg" placeholder="Rechercher...">
        </div>
    </div>

    <h1 class="text-4xl font-bold text-black text-center pt-20"> Stage - Entreprise à la une </h1>
    
</body>
</html>