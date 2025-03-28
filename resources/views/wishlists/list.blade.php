@extends('layouts.app')

@section('title', 'Ma Wishlist')

@include('partials.header')


<main x-data="{ selectedOffer: null }">
    <!-- Titre de la page -->
    <h1 class="text-2xl font-bold m-4">Ma Wishlist</h1>

    <!-- Contenu de la page -->
    <div class="flex flex-col md:flex-row container mx-auto p-4 gap-6">

        <!-- Filtres -->
        <div class="bg-teal-700 text-white p-4 rounded-lg w-full md:w-1/5">
            <div class="mb-4">
                <label class="block font-semibold">Dates</label>
                <select class="w-full bg-teal-600 p-2 rounded">
                    <option>-14j</option>
                    <option>-7j</option>
                    <option>-3j</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Salaire</label>
                <select class="w-full bg-teal-600 p-2 rounded">
                    <option>1000 - 1500</option>
                    <option>1500 - 2000</option>
                    <option>2000 - 2500</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Lieux</label>
                <input type="text" class="w-full bg-teal-600 p-2 rounded" placeholder="Rechercher">
            </div>
        </div>

        <!-- Liste des offres -->
        <div>
            @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                {{ session('error') }}
            </div>
            @endif
            @if ($wishlists->count() > 0)
            <div>
                @foreach ($wishlists as $offer)
                <div class="bg-white shadow-md rounded-tr-2xl rounded-bl-2xl flex flex-col justify-between items-center border border-[#5A8E95] gap-2 p-2 mb-4 max-w-1/3 cursor-pointer transition-all"
                :class="{'bg-gray-300': selectedOffer?.id === Number({{ $offer->id }})}"
                @click="selectedOffer = {{ json_encode($offer) }}">
                <div class="flex items-center">
                        @if (auth()->user()->wishlists->contains($offer->id))
                        <form action="{{ route('wishlist_remove', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}" method="POST" class="mt-4 flex items-center h-auto">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                <!-- Icône de cœur -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                </svg>
                            </button>
                        </form>
                        @endif
                        <h4 class="text-xl font-bold text-center md:text-left">
                            <a href="{{ route('offer_info', ['id' => $offer->id, 'title' => Str::slug($offer->title)]) }}">
                                {{ $offer->title }}</a>
                        </h4>
                    </div>
                    <div class="flex flex-row items-center justify-between">
                        <!-- Première partie -->
                        <h6 class="text-gray-500 text-center flex-1">
                            {{ $offer->company->name }}
                        </h6>

                        <!-- Séparateur vertical -->
                        <span class="mx-2 w-[1px] bg-gray-400 self-stretch"></span>

                        <!-- Deuxième partie -->
                        <p class="text-gray-500 mx-2 text-center flex-1">
                            {{ \Carbon\Carbon::parse($offer->start_date)->translatedFormat('d F Y') }} to {{ \Carbon\Carbon::parse($offer->end_date)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    @role('Admin|Etudiant')
                    <div class="flex justify-center">
                        <a href="{{ route('offer_apply', ['offer_id' => $offer->id]) }}"
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
            @else
            <p class="text-gray-500">Votre wishlist est vide.</p>
            @endif
        </div>
        <!-- Détails de l'offre -->
        <div class="w-full md:w-1/3 bg-gray-100 p-4 rounded-lg" x-show="selectedOffer" x-transition>
            <template x-if="selectedOffer">
                <div>
                    <h2 class="text-xl font-bold mb-2" x-text="selectedOffer.title"></h2>
                    <p class="text-gray-700"><strong>Entreprise :</strong> <span x-text="selectedOffer.company.name"></span></p>
                    <p class="text-gray-700"><strong>Dates :</strong>
                        <span x-text="new Date(selectedOffer.start_date).toLocaleDateString()"></span>
                        -
                        <span x-text="new Date(selectedOffer.end_date).toLocaleDateString()"></span>
                    </p>
                    <p class="text-gray-700 mt-2" x-text="selectedOffer.description"></p>
                    <div class="mt-4">
                        <a :href="'/offers/' + selectedOffer.id + '/apply'"
                            class="bg-[#3D9DA9] text-white text-sm px-4 py-1.5 rounded-full hover:bg-[#3D8A8F]">
                            Candidater
                        </a>
                    </div>
                </div>
            </template>
        </div>

    </div>

    <!-- Débug -->
    <div class="text-sm text-red-500" x-text="JSON.stringify(selectedOffer)"></div>
    <div>
    <!-- Affiche la valeur et le type de selectedOffer.id -->
    <div class="text-sm text-blue-500">
        selectedOffer.id: <span x-text="typeof selectedOffer?.id"></span> - <span x-text="selectedOffer?.id"></span>
    </div>

    <!-- Affiche la valeur et le type de $offer->id -->
    <div class="text-sm text-green-500">
        $offer->id: <span x-text="'number'"></span> - <span>{{ $offer->id }}</span>
    </div>
</div>

</main>

@include('partials.footer')