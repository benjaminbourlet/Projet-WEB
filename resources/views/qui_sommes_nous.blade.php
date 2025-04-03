@extends('layouts.app')

@section('title', 'Mentions Légales')



@section('content')

    <main class="container mx-auto p-6">
        <section class="mb-10 text-center">
            <h2 class="text-3xl font-semibold mb-4">Notre Entreprise</h2>
            <p class="text-lg max-w-3xl mx-auto">Nous sommes une équipe passionnée par l'informatique. Notre objectif est de
                faciliter les jeunes étudiants à trouver un stage. Forts de notre expertise, nous accompagnons nos clients
                vers la réussite.</p>
        </section>

        <section class="mb-10">
            <h2 class="text-3xl font-semibold text-center mb-6">Notre Équipe</h2>

            <div class="relative w-full max-w-3xl mx-auto" x-data="{ scrollPos: 0 }">
                <!-- x-data="{ scrollPos: 0 }" : pour gérer la position de défilement -->
                <div class="flex overflow-x-scroll scroll-smooth snap-x snap-mandatory space-x-4 pb-4 scrollbar-none"
                    x-ref="carousel">
                    <!-- x-ref="carousel" : référence pour le défilement -->
                    <!-- overflow-x-scroll : pour le défilement horizontal -->
                    <!-- scrollbar-none : pour masquer la barre de défilement -->
                    <!-- scroll-smooth : pour un défilement fluide -->
                    <!-- snap-x : pour un défilement horizontal -->
                    <!-- snap-mandatory : pour un défilement obligatoire -->
                    <div class="snap-center shrink-0 w-full h-64 bg-gray-300 flex items-center justify-center">
                        <img src="{{ asset('storage/images/benjamin_bourlet.jpg') }}" class="object-cover rounded-lg"
                            alt="Membre 1">
                    </div>
                    <div class="snap-center shrink-0 w-full h-64 bg-gray-300 flex items-center justify-center">
                        <img src="{{ asset('storage/images/diego_bortolussi.jpg') }}" class="object-cover rounded-lg"
                            alt="Membre 2">
                    </div>
                    <div class="snap-center shrink-0 w-full h-64 bg-gray-300 flex items-center justify-center">
                        <img src="{{ asset('storage/images/argan_da_costa.jpg') }}" class="object-cover rounded-lg"
                            alt="Membre 3">
                    </div>
                    <div class="snap-center shrink-0 w-full h-64 bg-gray-300 flex items-center justify-center">
                        <img src="{{ asset('storage/images/maxime_moysset.jpg') }}" class="object-cover rounded-lg"
                            alt="Membre 4">
                    </div>
                </div>

                <!-- Boutons de navigation -->
                <button @click="$refs.carousel.scrollBy({ left: -780,behavior: 'smooth' })"
                
                    class="absolute hidden md:flex left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white ml-2 px-4 py-2 rounded-l-lg">
                    &#10094;
                </button>

                <button @click="$refs.carousel.scrollBy({ left: 780,behavior: 'smooth' })"
                    class="absolute hidden md:flex right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white mr-2 px-4 py-2 rounded-r-lg">
                    &#10095;
                </button>
            </div>
            <!-- @click="$refs.carousel.scrollBy({ left: -780,behavior: 'smooth' })" : pour faire défiler vers la gauche -->
            <!-- @click="$refs.carousel.scrollBy({ left: 780,behavior: 'smooth' })" : pour faire défiler vers la droite -->
        </section>
    </main>
@endsection