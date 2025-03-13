@extends('layouts.app')

@section('title', 'Entreprises')

@include('partials.header')

<main class="flex-grow container mx-auto p-4 flex gap-6">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Entreprises</h1>

        <div>
            @role('Admin|Pilote')
                <div class="mt-4 w-min h-auto">
                    <a href="{{ route('company_register') }}">
                        <button
                            class="bg-blue-700 hover:bg-blue-400 text-white px-4 py-2 rounded-lg flex items-center justify-center w-max">Ajouter
                            une entreprise
                        </button>
                    </a>
                </div>
            @endrole

            <form method="GET" action="{{ route('company.search') }}"
                class="flex flex-wrap gap-4 border p-4 rounded-md w-full m-2">
                @csrf

                <!-- Div Barre de Recherche + Bouton Rechercher-->
                <div class="flex w-full items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher une entreprise..." class="flex-1 border p-2 rounded-md">

                    <button type="submit"
                        class="bg-blue-700 hover:bg-blue-400 text-white px-4 py-2 rounded-md flex-none">Rechercher</button>
                </div>

                <!-- Div Filtres -->
                <div class="flex flex-col space-between w-full h-min p-2 m-2">

                    <!-- Liste des secteurs sélectionnés -->
                    <div id="selected-sectors" class="flex flex-wrap flex-none gap-2"></div>

                    <!-- Filtre par secteur -->
                    <div class="flex flex-wrap gap-2 w-full">

                        

                        <!-- Sélection des secteurs -->
                        <select id="sector-select" class="border p-2 rounded-md m-2 w-min h-min">
                            <option value="">Sélectionner un secteur</option>
                            @foreach ($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>

                        

                        <!-- Filtre par ville -->
                        <select name="city" class="border p-2 rounded-md m-2 w-min h-min">
                            <option value="">Toutes les villes</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}"
                                    {{ request('city') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Champ caché pour les secteurs sélectionnés -->
                        <input type="hidden" name="sector" id="sector-input">

                        <!-- Trie -->
                        <select name="sort" class="border p-2 rounded-md m-2 ml-auto w-min">
                            <option value="">Trier par</option>
                            <option value="name_asc">Nom A-Z</option>
                            <option value="name_desc">Nom Z-A</option>
                            <option value="date_recent">Date récente</option>
                            <option value="date_old">Date ancienne</option>
                        </select>
                        <a href="{{ route('company.search') }}"
                            class="bg-blue-700 hover:bg-blue-400 text-white border text-center p-2 rounded-md m-2">
                            Réinitialiser
                        </a>
                    </div>
            </form>

        </div>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($companies as $company)
                <div
                    class="bg-white p-4 shadow-md rounded-lg border border-gray-200 hover:shadow-xl hover:scale-105 transition-transform duration-300 ease-in-out">
                    <a href="{{ route('company_info', ['id' => $company->id]) }}"
                        class="flex flex-col items-center text-center space-y-3">

                        <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-12 h-12 rounded-full"
                            alt="Company">

                        <div>
                            <p class="text-lg font-semibold"><strong>Nom :</strong> {{ $company->name }}</p>
                            <p class="text-sm text-gray-600"><strong>ID :</strong> {{ $company->id }}</p>
                            <p class="text-sm text-gray-600"><strong>Siret :</strong> {{ $company->siret }}</p>
                            <p class="text-sm text-gray-600"><strong>Email :</strong> {{ $company->email }}</p>
                            <p class="text-sm text-gray-600"><strong>Téléphone :</strong>
                                {{ $company->tel_number ?? 'Non renseigné' }}</p>
                            <p class="text-sm text-gray-600"><strong>Secteurs :</strong>
                                {{ $company->sectors->isNotEmpty() ? $company->sectors->pluck('name')->implode(', ') : 'Aucun secteur' }}
                            </p>
                            <p class="text-sm text-gray-600"><strong>Adresse :</strong>
                                {{ $company->address ?? 'Non renseigné' }}</p>
                            <p class="text-sm text-gray-600"><strong>Région :</strong>
                                {{ optional($company->city->region)->name ?? 'Non défini' }}</p>
                            <p class="text-sm text-gray-500"><strong>Ville :</strong> {{ $company->city->name }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sectorSelect = document.getElementById("sector-select");
            const selectedSectorsContainer = document.getElementById("selected-sectors");
            const sectorInput = document.getElementById("sector-input"); // Récupère le champ caché

            // Liste des secteurs sélectionnés (Set pour éviter les doublons)
            let selectedSectors = new Set(getUrlParams());

            // Met à jour l'affichage des secteurs sélectionnés
            function updateSelectedSectors() {
                selectedSectorsContainer.innerHTML = "";

                selectedSectors.forEach(id => {
                    let option = sectorSelect.querySelector(`option[value="${id}"]`);
                    if (option) {
                        let tag = document.createElement("div");
                        tag.className = "flex items-center bg-blue-200 px-3 py-1 rounded-md";
                        tag.innerHTML = `
                    <span>${option.text}</span>
                    <button type="button" class="ml-2 text-red-600 font-bold remove-sector" data-id="${id}">×</button>
                `;
                        selectedSectorsContainer.appendChild(tag);
                    }
                });

                // Mise à jour de l'URL
                updateUrlParams();

                // Mise à jour du champ caché avec les secteurs sélectionnés
                sectorInput.value = Array.from(selectedSectors).join(",");
            }

            // Fonction pour récupérer les valeurs de l'URL
            function getUrlParams() {
                const params = new URLSearchParams(window.location.search);
                let sectors = params.get("sector");
                return sectors ? sectors.split(",") : [];
            }

            // Fonction pour mettre à jour l'URL
            function updateUrlParams() {
                const params = new URLSearchParams(window.location.search);
                if (selectedSectors.size > 0) {
                    params.set("sector", Array.from(selectedSectors).join(","));
                } else {
                    params.delete("sector");
                }
                window.history.replaceState({}, "", "?" + params.toString());
            }

            // Sélection d'un secteur
            sectorSelect.addEventListener("change", function() {
                let selectedValue = sectorSelect.value;
                if (selectedValue && !selectedSectors.has(selectedValue)) {
                    selectedSectors.add(selectedValue);
                    updateSelectedSectors();
                }
                sectorSelect.value = ""; // Reset du select
            });

            // Suppression d'un secteur
            selectedSectorsContainer.addEventListener("click", function(event) {
                if (event.target.classList.contains("remove-sector")) {
                    let sectorId = event.target.dataset.id;
                    selectedSectors.delete(sectorId);
                    updateSelectedSectors();
                }
            });

            // Initialisation au chargement de la page
            updateSelectedSectors();

            // Soumettre le formulaire avec les secteurs sélectionnés dans l'input caché
            const form = document.querySelector("form"); // Récupère le formulaire
            form.addEventListener("submit", function(e) {
                // On met à jour l'input caché avant la soumission
                sectorInput.value = Array.from(selectedSectors).join(",");
            });
        });
    </script>
</main>

@include('partials.footer')