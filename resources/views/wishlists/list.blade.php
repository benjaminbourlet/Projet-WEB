@extends('layouts.app')

@section('title', 'Ma Wishlist')

@section('content')

    @if ($wishlists->isEmpty())
        <p class="text-gray-500">Aucune offre dans la wishlist.</p>
    @else

        <div x-data="{ selectedOffer: null }">
            <!-- Titre de la page -->
            <h1 class="text-2xl font-bold m-4">Ma Wishlist</h1>

            <!-- Contenu de la page -->
            <div class="flex flex-col md:flex-row container mx-auto p-4 gap-6">

                <!-- Sidebar Filtres -->
                <form method="GET" action="{{ route('wishlists_search', ['user_id' => $user->id]) }}"
                    class="bg-teal-700 text-white p-4 rounded-lg w-full md:w-1/5 inline-block md:top-8 md:max-h-max sticky">

                    <!-- Barre de Recherche par entreprise -->
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom d'offre"
                        class="mb-4 text-black border p-2 rounded-full w-max">

                    <!-- Filtres -->
                    <div class="flex flex-col">

                        <!--Filtre par entreprise-->
                        <label for="">Entreprise</label>
                        <select name="company" class="text-black textborder p-2 rounded-md m-2 max-w-max max-h-max">
                            <option value="">Toutes les entreprises</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>

                        <!--Filtre Ville-->
                        <label for="" class="text-white">Ville</label>
                        <select name="city" class="text-black border p-2 rounded-md m-2 max-w-max max-h-max">
                            <option value="">Toutes les villes</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Sélection de la région -->
                        <label for="" class="text-white">Region</label>
                        <select name="region" class="text-black border p-2 rounded-md m-2 max-w-max max-h-max">
                            <option value="">Toutes les régions</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Slider Salaire -->
                        <label for="salary_slider" class="block">Salaire :</label>
                        <div class="p-2">
                            <div id="salary_slider" class="mb-2"></div>

                            <!-- Affichage des valeurs de salaire -->
                            <div class="flex justify-between">
                                <span>Salaire Min: <span id="salary_min_value">{{ request('min_salaire') ?: '0' }}</span></span>
                                <span>Salaire Max: <span
                                        id="salary_max_value">{{ request('max_salaire') ?: '10000' }}</span></span>
                            </div>

                            <!-- Valeurs de salaire min et max -->
                            <input type="hidden" name="min_salaire" id="min_salaire"
                                value="{{ request('min_salaire') ?: '0' }}">
                            <input type="hidden" name="max_salaire" id="max_salaire"
                                value="{{ request('max_salaire') ?: '10000' }}">
                        </div>

                        <!-- Slider Durée -->
                        <label for="duration_slider" class="block">Durée :</label>
                        <div class="p-2">
                            <div id="duration_slider" class="mb-2"></div>

                            <!-- Affichage des valeurs de durée -->
                            <div class="flex justify-between">
                                <span>Durée Min: <span id="duration_min_value">{{ request('duration_min') ?: '0' }}</span>
                                </span>
                                <span>Durée Max: <span id="duration_max_value">{{ request('duration_max') ?: '180' }}</span>
                                </span>
                            </div>

                            <!-- Valeurs de durée min et max -->
                            <input type="hidden" name="duration_min" id="duration_min"
                                value="{{ request('duration_min') ?: '0' }}">
                            <input type="hidden" name="duration_max" id="duration_max"
                                value="{{ request('duration_max') ?: '180' }}">
                        </div>

                        <!--Filtre Durée minimum et maximum du stage-->

                        <!-- Filtre date de début stage -->
                        <label for="">Date de début</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="mb-4 w-full bg-teal-600 p-2 rounded" placeholder="Rechercher">
                    </div>
                    <!-- Bouton chercher et réinitialiser -->
                    <div class="flex justify-between items-center space-x-2">
                        <button type="submit" class="bg-blue-700 hover:bg-blue-400 text-white px-4 py-2 rounded-md flex-none">
                            Rechercher
                        </button>
                        <a href="{{ route('wishlists_search', ['user_id' => $user->id]) }}"
                            class="bg-blue-700 hover:bg-blue-400 text-white text-center p-2 rounded-md">
                            Réinitialiser
                        </a>
                    </div>
                </form>

                <!-- Liste des offres -->
                <div>
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div>
                        @foreach ($wishlists as $offer)
                            <div class="bg-white hover:bg-gray-100 shadow-md rounded-tr-2xl rounded-bl-2xl flex flex-col justify-between items-center border border-[#5A8E95] gap-2 p-2 mb-4 max-w-1/3 cursor-pointer transition-all"
                                @click="window.innerWidth < 768 ? window.location.href = '{{ route('offer_info', ['id' => $offer->id, 'title' => Str::slug($offer->title)]) }}' : selectedOffer = {{ json_encode($offer->load(['company', 'company.city', 'skills'])) }}"
                                @click.away="selectedOffer = null" @click.stop>
                                <div class="flex items-center">
                                    @if (auth()->user()->wishlists->contains($offer->id))
                                    <!-- Formulaire pour supprimer de la wishlist -->
                                        <form
                                            action="{{ route('wishlist_remove', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}"
                                            method="POST" class="flex items-center h-auto">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none mr-2">
                                                <!-- Icône de cœur -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="black"
                                                    stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                                                    <path
                                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <h4 class="text-xl font-bold text-center md:text-left">
                                        <a
                                            href="{{ route('offer_info', ['id' => $offer->id, 'title' => Str::slug($offer->title)]) }}">
                                            {{ $offer->title }}</a>
                                    </h4>
                                </div>
                                <div class="flex flex-row items-center justify-between">
                                    <!-- Nom de l'entreprise -->
                                    <h6 class="text-gray-500 text-center flex-1">
                                        {{ $offer->company->name }}
                                    </h6>

                                    <!-- Séparateur vertical -->
                                    <span class="mx-2 w-[1px] bg-gray-400 self-stretch"></span>

                                    <!-- Date du stage -->
                                    <p class="text-gray-500 mx-2 text-center flex-1">
                                        {{ \Carbon\Carbon::parse($offer->start_date)->translatedFormat('d F Y') }} to
                                        {{ \Carbon\Carbon::parse($offer->end_date)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                @role('Admin|Etudiant')
                                <div class="flex justify-center">
                                    <a href="{{ route('offer_apply', ['offer_title', 'offer_id' => $offer->id]) }}"
                                        class="bg-[#3D9DA9] text-white text-sm px-4 py-1.5 rounded-full hover:bg-[#3D8A8F] mb-2">
                                        Candidater
                                    </a>
                                </div>
                                @endrole
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $wishlists->links() }}
                    </div>
                </div>
                <!-- Détails de l'offre -->
                <div class="w-full md:w-1/2 bg-[#5A8E95] p-4 rounded-lg border border-black mx-auto inline-block sticky md:top-8 md:max-h-max md:overflow-auto fixed bottom-4 max-h-1/3 w-full md:w-1/2"
                    x-show="selectedOffer" x-transition @click.stop>
                    <div class="flex flex-col">
                        <h2 class="text-2xl text-center text-white font-bold mb-2" x-text="selectedOffer.title"></h2>
                        <span class="h-[1px] bg-white w-full"></span>
                        <div class="flex mx-2">
                            <div class="flex flex-grow items-center justify-between">
                                <!-- Nom de l'entreprise -->
                                <h6 class="text-white text-center flex-1" x-text="selectedOffer.company.name"></h6>
                                <!-- Séparateur vertical -->
                                <span class="mx-2 w-[1px] bg-white self-stretch"></span>
                                <!-- Date de stage -->
                                <p class="text-white mx-2 text-center flex-1 inline-block">
                                    <span
                                        x-text="new Date(selectedOffer.start_date).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                                    -
                                    <span
                                        x-text="new Date(selectedOffer.end_date).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                                </p>
                            </div>
                        </div>
                        <span class="h-[1px] bg-white w-full mb-2"></span>
                        <div class="mt-4 text-center"> <!-- Bouton Postuler -->
                            <a href="{{ route('offer_apply', ['offer_title', 'offer_id' => $offer->id]) }}"
                                class="bg-[#3D9DA9] text-white text-sm px-4 py-1.5 rounded-full hover:bg-[#3D8A8F] border border-white cursor-pointer">
                                Postuler maintenant
                            </a>
                        </div>
                        <h6 class="text-white mt-2 text-lg"><strong>Détails :</strong></h6>
                        <div class="flex justify-center flex-col md:flex-row px-4 gap-4">
                            <div class="flex items-center"> <!-- Localisation du stage -->
                                <!-- Icône de localisation -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-6 h-6">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 10.5c-1.93 0-3.5-1.57-3.5-3.5S10.07 5.5 12 5.5s3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z" />
                                </svg>
                                <p class="text-white text-lg" x-text="selectedOffer.company.city.name"></p>
                            </div> <!-- Fin de la localisation du stage -->
                            <div class="flex items-center"> <!-- Salaire du stage -->
                                <p class="text-white">
                                    <span class="font-bold">Salaire :</span>
                                    <span x-text="selectedOffer.salary"></span>
                                    <span>€</span>
                                </p>
                            </div>
                        </div>
                        <div class=" px-4"> <!-- Description de l'offre -->
                            <p class="text-white"><strong>Description :</strong></p>
                            <p class="text-white px-4" x-text="selectedOffer.description"></p>
                        </div> <!-- Fin de la description de l'offre -->
                        <div class="px-4"> <!-- Compétences requises -->
                            <label class="block font-bold text-white">Compétences :</label>
                            <div class="flex flex-wrap gap-2 mt-2 justify-center items-center">
                                <!-- Affiche les compétences de l'offre -->
                                <template x-for="skill in selectedOffer.skills" :key="skill . id">
                                    <p
                                        class="inline-block bg-[#387077] text-white text-sm px-4 py-1.5 rounded-full border border-white">
                                        <span x-text="skill.name"></span>
                                    </p>
                                </template>
                            </div>
                        </div> <!-- Fin des compétences requises -->
                    </div>

                </div>

            </div>

        </div>
    @endif

@endsection