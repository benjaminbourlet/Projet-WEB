@extends('layouts.app')

@section('title', 'Ma Wishlist')

@section('content')
        <h1 class="text-2xl font-bold mb-4">Ma Wishlist</h1>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($wishlists->count() > 0)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @foreach ($wishlists as $offer)
                        <li class="p-4 hover:bg-gray-50">
                            <h5 class="text-lg font-semibold">
                                <a href="{{ route('offer_info', ['id' => $offer->id, 'title' => Str::slug($offer->title)]) }}">
                                    {{ $offer->title }}</a>
                            </h5>
                            <p class="text-gray-600">{{ $offer->description }}</p>
                            <small class="text-gray-500">Ajouté le : {{ $offer->pivot->created_at->format('d/m/Y') }}</small>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-4">
                {{ $wishlists->links() }}
            </div>
        @else
            <p class="text-gray-500">Votre wishlist est vide.</p>
        @endif
@endsection