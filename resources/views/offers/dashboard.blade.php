@extends('layouts.app')

@section('content')
<div class="max-w-7xl text-center mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📊 Tableau de bord des offres</h1>

    <div class="md:flex md:space-x-6 mb-8">
        <!-- Répartition des offres par compétence -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 mb-6 md:mb-0 md:w-1/2 p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">🎯 Répartition des offres par compétence</h2>
            @if($skillsDistribution->isNotEmpty())
                <canvas id="skillsChart"
                        class="h-64 transition-all duration-500 ease-in-out transform hover:scale-105"
                        
                        data-labels='@json($skillsDistribution->pluck("name"))'
                        data-counts='@json($skillsDistribution->pluck("offers_count"))'></canvas>
            @else
                <p class="text-gray-500 italic">Aucune donnée disponible.</p>
            @endif
        </div>
        <!-- transition-all : transition de toutes les propriétés -->

        <!-- Répartition des offres par durée de stage -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 md:w-1/2 p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">⏳ Répartition des offres par durée de stage</h2>
            @if($durationDistribution->isNotEmpty())
                <canvas id="durationChart"
                        class="h-64 transition-all duration-500 ease-in-out transform hover:scale-105"
                        data-labels='@json($durationDistribution->pluck("duration_range"))'
                        data-counts='@json($durationDistribution->pluck("count"))'></canvas>
            @else
                <p class="text-gray-500 italic">Aucune donnée disponible.</p>
            @endif
        </div>
    </div>

    <!-- Top des offres les plus mises en wishlist -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">💖 Top 5 des offres les plus mises en wishlist</h2>
        @if($topWishlistedOffers->isNotEmpty())
            <ul class="divide-y divide-gray-200">
                @foreach($topWishlistedOffers as $offer)
                    <li class="py-4 flex items-center justify-between hover:bg-gray-50 px-2 rounded transition duration-200">
                        <a href="{{ route('offer_info', ['id' => $offer->id, 'title' => Str::slug($offer->title)]) }}" class="text-blue-600 hover:underline font-medium">
                            {{ $offer->title }}
                        </a>
                        <span class="inline-flex items-center justify-center px-3 py-1 text-sm font-semibold leading-none text-white bg-blue-500 rounded-full">
                            <!-- leading-none : pour aligner le texte verticalement -->
                            {{ $offer->users_count }} souhaits
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 italic">Aucune donnée disponible.</p>
        @endif
    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboardChart.js') }}"></script>
@endsection
