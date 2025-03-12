@extends('layouts.app')

@section('title', 'Accueil')

@include('partials.header')


<body class="bg-white">
    
    <div class="container mx-auto pt-20 text-center bg-100">
        <div class="relative w-2/3 mx-auto flex items-center">
            <button class="absolute left-3 top-1/2 -translate-y-1/2 bg-[#387077] p-2 rounded-full z-10">
                <img src="{{ asset('storage/images/loupe.png') }}" alt="Recherche" class="w-8 h-8">
            </button>
            <input type="text" class="w-full pl-16 p-4 border-2 border-black rounded-full text-lg" placeholder="Rechercher...">
        </div>
    </div>

    <h1 class="text-4xl font-bold text-black text-center pt-20"> Stage - Entreprise à la une </h1>
    

    
</body>

@include('partials.footer')

</html>