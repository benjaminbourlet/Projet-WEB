@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

    @if(session('success'))
        <div id="success-message" class="bg-green-500 text-white p-3 rounded-md mb-4 max-w-sm mx-auto">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto pt-20 text-center bg-100">
        <div class="relative w-2/3 mx-auto flex items-center">
            <form method="GET" action="{{ route('offer_search') }}" class="w-full">
                <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 bg-[#387077] p-2 rounded-full z-10">
                    <img src="{{ asset('storage/images/loupe.png') }}" alt="Recherche" class="w-8 h-8">
                </button>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full pl-16 p-4 border-2 border-black rounded-full text-lg" placeholder="Rechercher...">
            </form>
        </div>
    </div>

        <div class="container mx-auto pt-20 text-center">
            <h1 class="text-4xl font-bold text-black text-center pt-20">Stage - Entreprise à la une</h1>

            @if ($topCompanies->isNotEmpty())
                <div id="carousel" class="relative w-full">
                    <div class="flex justify-center space-x-4 py-8 transition-transform duration-500 ease-in-out">
                        @foreach ($topCompanies as $company)
                            <div
                                class="carousel-item hidden w-64 h-64 bg-gray-100 rounded-xl shadow-lg overflow-hidden flex-col items-center opacity-0 transition-opacity duration-500">
                                <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-32 h-auto rounded-full mx-auto"
                                    alt="Logo">
                                <div class="p-4 text-center">
                                    <h3 class="text-lg font-semibold">{{ $company->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $company->offers_count }} offres publiées</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button id="prevBtn"
                        class="absolute left-5 top-1/2 -translate-y-1/2 bg-gray-500 p-2 rounded-full text-white hover:bg-gray-700 transition-transform duration-300 hover:scale-110">
                        &lt;
                    </button>
                    <button id="nextBtn"
                        class="absolute right-5 top-1/2 -translate-y-1/2 bg-gray-500 p-2 rounded-full text-white hover:bg-gray-700 transition-transform duration-300 hover:scale-110">
                        &gt;
                    </button>
                </div>
            @else
                <p class="text-gray-500 text-lg mt-5">Aucune entreprise mise en avant pour le moment.</p>
            @endif
        </div>


        <!-- Section À propos de nous -->
        <div class="container mx-auto pt-20 px-8">
            <h2 class="text-3xl font-semibold text-[#387077]">À propos de nous</h2>
            <p class="text-gray-700 mt-4">
                Chez Job Finder, nous avons une mission claire : aider les étudiants à trouver un stage rapidement et
                efficacement. Nous savons à quel point décrocher une première expérience professionnelle peut être un
                parcours du combattant, c'est pourquoi nous avons créé une plateforme innovante qui simplifie la recherche
                de stage.
                <br>
                <br>
                Grâce à notre réseau d'entreprises partenaires et à notre technologie intelligente, nous mettons en relation
                les étudiants avec des offres adaptées à leur profil et à leurs aspirations. Plus besoin de parcourir des
                dizaines de sites : avec Job Finder, une seule candidature peut ouvrir plusieurs opportunités.
                <br>
                <br>
                Que vous soyez à la recherche de votre premier stage ou d’une expérience clé pour votre avenir, Job Finder
                vous accompagne à chaque étape. Trouvez le stage qui vous correspond, et lancez-vous dans le monde
                professionnel en toute confiance !
            </p>
        </div>

    <!-- Section Statistiques -->
    <div class="container mx-auto pt-10 px-8">
        <h2 class="text-3xl font-semibold text-[#387077]">Notre platerforme a déjà fait ces preuves !</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10 place-items-center mx-2 w-full">
            <div class="bg-[#dfdede] w-full max-w-xs p-8 rounded-lg shadow-md text-center">
                <p class="text-3xl font-bold">{{ $totalOffers }}</p>
                <img src="{{ asset('storage/images/job.png') }}" alt="Jobs" class="mx-auto w-16 md:w-20 h-16 md:h-20 my-4">
                <p class="text-black">Offres disponibles actuellement, trouvez la parfaite pour vous !</p>
            </div>
            <div class="bg-[#dfdede] w-full max-w-xs p-8 rounded-lg shadow-md text-center">
                <p class="text-3xl font-bold">{{ $totalCompanies }}</p>
                <img src="{{ asset('storage/images/partners.png') }}" alt="Partenaires"
                    class="mx-auto w-16 md:w-20 h-16 md:h-20 my-4">
                <p class="text-black">Entreprises partenaires, une multitude de choix !</p>
            </div>
            <div class="bg-[#dfdede] w-full max-w-xs p-8 rounded-lg shadow-md text-center">
                <p class="text-3xl font-bold">{{ $totalStudents }}</p>
                <img src="{{ asset('storage/images/students.png') }}" alt="Étudiants"
                    class="mx-auto w-16 md:w-20 h-16 md:h-20 my-4">
                <p class="text-black">Étudiants en recherche, vous n’êtes pas seul !</p>
            </div>
        </div>
    </div>

@endsection