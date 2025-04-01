@extends('layouts.app')

@section('title', 'Ma Wishlist')

@include('partials.header')

@section('content')
    <main class="flex-grow container mx-auto p-2 flex flex-col gap-6">
        <h1 class="text-2xl font-bold mb-4">Ma Wishlist</h1>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($wishlists->count() > 0)
            <div>
                <ul class="divide-y divide-gray-200">
                    @foreach ($wishlists as $offer)
                        <li class="bg-white p-4 shadow-md rounded-lg border border-gray-200 hover:shadow-lg hover:scale-105 transition-transform duration-300 ease-in-out">
                            <h5 class="text-lg font-semibold">
                                <a href="{{ route('offer_info', ['id' => $offer->id, 'title' => Str::slug($offer->title)]) }}">
                                    {{ $offer->title }}</a>
                            </h5>
                            <p class="text-gray-600">{{ $offer->description }}</p>
                            <small class="text-gray-500">Ajouté le : {{ $offer->pivot->created_at->format('d/m/Y') }}</small>
                            <div class="p-4 rounded-lg">
                                @role('Admin|Etudiant')
                                <!-- Bouton Wishlist -->
                                <div class="mt-2">
                                    @if (auth()->user()->wishlists->contains($offer->id))
                                        <form action="{{ route('wishlist_remove', ['user_id' => auth()->id(), 'offer_id' => $offer->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="bg-[#5A8E95] text-white px-4 py-2 rounded-full hover:bg-blue-200">
                                                Supprimer de la Wishlist
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                @endrole
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>




            <!-- Pagination -->
            <div class="mt-4">
                {{ $wishlists->links() }}
            </div>
        @else
            <p class="text-gray-500">Votre wishlist est vide.</p>
        @endif
    </main>

    @include('partials.footer')
@endsection