@extends('layouts.app')

@section('title', 'Offres')

@include('partials.header')

@section('content')

    <!-- Contenu principal -->
    <main class="container mx-auto p-4 flex gap-6">

        <!-- Sidebar Filtres -->
        <form method="GET" class="bg-teal-700 text-white p-4 rounded-lg w-1/5">

            <!-- Barre de Recherche par entreprise -->
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom d'offre"
                class="mb-4 text-black border p-2 rounded-full w-max">

            <!-- Filtres -->
            <div class="grid">
                <label for="">Entreprise</label>
                <input type="text" name="company" value="{{ request('company') }}"
                    class=" mb-4 w-full bg-teal-600 p-2 rounded" placeholder="Rechercher">


                <!-- Slider Salaire -->
                <label for="salary_slider" class="block">Salaire :</label>
                <div id="salary_slider" class="mb-4"></div>

                <!-- Affichage des valeurs de salaire -->
                <div class="flex justify-between">
                    <span>Salaire Min: <span id="salary_min_value">{{ request('min_salaire') ?: '0' }}</span></span>
                    <span>Salaire Max: <span id="salary_max_value">{{ request('max_salaire') ?: '10000' }}</span></span>
                </div>

                <!-- Valeurs de salaire min et max -->
                <input type="hidden" name="min_salaire" id="min_salaire" value="{{ request('min_salaire') ?: '0' }}">
                <input type="hidden" name="max_salaire" id="max_salaire" value="{{ request('max_salaire') ?: '10000' }}">

                <label for="" class="mt-6">Ville</label>
                <input type="text" name="city" value="{{ request('city') }}" class="mb-4 w-full bg-teal-600 p-2 rounded"
                    placeholder="Rechercher">
                <label for="">Durée minimum</label>
                <input type="text" name="duree_min" value="{{ request('duree_min') }}"
                    class=" mb-4 w-full bg-teal-600 p-2 rounded" placeholder="Rechercher">
                <label for="">Durée maximum</label>
                <input type="text" name="duree_max" value="{{ request('duree_max') }}"
                    class=" mb-4 w-full bg-teal-600 p-2 rounded" placeholder="Rechercher">
                <label for="">Date de début</label>
                <input type="text" name="start_date" value="{{ request('start_date') }}"
                    class=" mb-4 w-full bg-teal-600 p-2 rounded" placeholder="Rechercher">
            </div>
            <button type="submit"
                class="bg-blue-700 hover:bg-blue-400 text-white px-4 py-2 rounded-md flex-none">Rechercher</button>
        </form>

        <!-- Liste des offres -->
        <div class="w-4/5">
            <div class="mb-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Offres</h1>
                @role('Admin|Pilote')
                <a href="{{ route('offer_register') }}">
                    <button class="bg-blue-700 hover:bg-blue-500 text-white px-4 py-2 rounded-lg">
                        Ajouter une offre
                    </button>
                </a>
                @endrole
            </div>

            <div class="grid gap-4">
                @foreach ($offers as $offer)
                    <div
                        class="bg-white p-4 shadow-md rounded-lg border border-gray-200 hover:shadow-lg hover:scale-105 transition-transform duration-300 ease-in-out">
                        <a href="{{ route('offer_info', ['id' => $offer->id, 'title' => Str::slug($offer->title)]) }}"
                            class="block space-y-2">
                            <p class="text-lg font-semibold">{{ $offer->title }}</p>
                            <p class="text-xs text-gray-500">Publié le {{ $offer->created_at->format('d/m/Y') }}</p>
                            <p class="text-sm text-black">Entreprise : {{ $offer->company->name }}</p>

                            <!-- Affichage dynamique des compétences -->
                            <p class="text-sm text-black">Compétences :
                                @foreach ($offer->skills as $skill)
                                    <span class="bg-[#387077] px-2 py-1 rounded text-sm text-white">{{ $skill->name }}</span>
                                @endforeach
                            </p>

                            <p class="text-sm text-black">Description : {{ Str::limit($offer->description, 100) }}</p>
                        </a>

                        @role('Admin|Etudiant')
                        <!-- Bouton Wishlist -->
                        <div class="m-4">
                            @if (auth()->user()->wishlists->contains($offer->id))
                                <form action="{{ route('wishlist_remove', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="relative group bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-500">
                                        ❤️
                                        <span class="absolute left-1/2 -translate-x-1/2 top-full mt-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 z-40 transition-opacity duration-300">
                                            Supprimer de la Wishlist
                                        </span>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('wishlist_add', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="relative group bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-500">
                                        🩶
                                        <span class="absolute left-1/2 -translate-x-1/2 top-full mt-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 z-40 transition-opacity duration-300">
                                            Ajouter à la Wishlist
                                        </span>
                                    </button>
                                </form>
                            @endif
                        </div>
                        @endrole
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $offers->links() }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var salarySlider = document.getElementById('salary_slider');
                var minSalaryInput = document.getElementById('min_salaire');
                var maxSalaryInput = document.getElementById('max_salaire');
                var salaryMinValue = document.getElementById('salary_min_value');
                var salaryMaxValue = document.getElementById('salary_max_value');

                // Initialisation du slider
                noUiSlider.create(salarySlider, {
                    start: [{{ request('min_salaire') ?: 0 }}, {{ request('max_salaire') ?: 10000 }}],
                    connect: true,
                    range: {
                        'min': [0],
                        'max': [10000]
                    },
                    step: 100,
                    format: {
                        to: function (value) {
                            return Math.round(value);
                        },
                        from: function (value) {
                            return value;
                        }
                    }
                });

                // Mettre à jour les valeurs quand le slider est déplacé
                salarySlider.noUiSlider.on('update', function (values, handle) {
                    if (handle === 0) {
                        salaryMinValue.innerText = values[0];
                        minSalaryInput.value = values[0];
                    } else {
                        salaryMaxValue.innerText = values[1];
                        maxSalaryInput.value = values[1];
                    }
                });

                // Ajout de l'événement submit pour s'assurer que les champs sont mis à jour avant l'envoi
                var form = document.querySelector('form');
                form.addEventListener('submit', function (event) {
                    // Empêcher l'envoi immédiat du formulaire pour mettre à jour les valeurs
                    event.preventDefault();

                    // Assurer que les champs cachés sont mis à jour avec les valeurs actuelles du slider
                    minSalaryInput.value = salarySlider.noUiSlider.get()[0];
                    maxSalaryInput.value = salarySlider.noUiSlider.get()[1];

                    // Enfin, soumettre le formulaire
                    form.submit();
                });
            });
        </script>

    </main>

    @include('partials.footer')

@endsection