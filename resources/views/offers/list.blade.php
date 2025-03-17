@extends('layouts.app')

@section('title', 'Offres')

@include('partials.header')

<!-- Contenu principal -->
<main class="flex-grow container mx-auto p-4 flex gap-6">

    <!-- Sidebar Filtres -->
    @include('partials.search_bar')

    <!-- Liste des offres -->
    <div class="w-4/5">
        <div class="mb-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Offres</h1>
            @role('Admin|Pilote')
            <a href="{{ route('offer_register') }}">
                <button class="bg-[#5A8E95] hover:bg-blue-500 text-white px-4 py-2 rounded-lg">
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
                                <button type="submit" class=" text-white px-3 py-1 rounded hover:bg-red-500">
                                    <img src="{{ asset('storage/images/wishlist_white.svg') }}" width="20" height="20"
                                        alt="">
                                </button>
                            </form>
                        @else
                            <form action="{{ route('wishlist_add', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="text-white px-3 py-1 rounded">
                                    <img src="{{ asset('storage/images/wishlist_red.svg') }}" width="20" height="20" alt="">
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