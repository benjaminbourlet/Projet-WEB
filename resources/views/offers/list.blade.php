@extends('layouts.app')

@section('title', 'Offres')

@include('partials.header')

<!-- Contenu principal -->
<main class="flex-grow container mx-auto p-4 flex gap-6">

    <!-- Sidebar Filtres -->
    <div class="bg-teal-700 text-white p-4 rounded-lg w-1/5">
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
                    <a href="{{ route('offer_info', ['id' => $offer->id]) }}" class="block space-y-2">
                        <p class="text-lg font-semibold">{{ $offer->title }}</p>
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
                    <div class="mt-2">
                        @if (auth()->user()->wishlists->contains($offer->id))
                            <form action="{{ route('wishlist_remove', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">
                                    🩶
                                </button>
                            </form>
                        @else
                            <form action="{{ route('wishlist_add', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-500">
                                    ❤️
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

</main>

@include('partials.footer')