@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de bord des offres</h1>

    <!-- Répartition des offres par compétence -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Répartition des offres par compétence</h5>
        </div>
        <div class="card-body">
            @if($skillsDistribution->isNotEmpty())
                <canvas id="skillsChart"></canvas>
            @else
                <p>Aucune donnée disponible.</p>
            @endif
        </div>
    </div>

    <!-- Répartition des offres par durée de stage -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Répartition des offres par durée de stage</h5>
        </div>
        <div class="card-body">
            @if($durationDistribution->isNotEmpty())
                <canvas id="durationChart"></canvas>
            @else
                <p>Aucune donnée disponible.</p>
            @endif
        </div>
    </div>

    <!-- Top des offres les plus mises en wishlist -->
    <div class="card">
        <div class="card-header">
            <h5>Top 5 des offres les plus mises en wishlist</h5>
        </div>
        <div class="card-body">
            @if($topWishlistedOffers->isNotEmpty())
                <ul class="list-group">
                    @foreach($topWishlistedOffers as $offer)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('offer_info', ['id' => $offer->id, 'title' => Str::slug($offer->title)]) }}') }}">{{ $offer->title }}</a>
                            <span class="badge bg-primary rounded-pill">{{ $offer->users_count }} souhaits</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucune donnée disponible.</p>
            @endif
        </div>
    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Répartition des offres par compétence
        @if($skillsDistribution->isNotEmpty())
        var ctx1 = document.getElementById('skillsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($skillsDistribution->pluck('name')),
                datasets: [{
                    label: 'Nombre d\'offres',
                    data: @json($skillsDistribution->pluck('offers_count')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
        @endif

        // Répartition des offres par durée de stage
        @if($durationDistribution->isNotEmpty())
        var ctx2 = document.getElementById('durationChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: @json($durationDistribution->pluck('duration_range')),
                datasets: [{
                    data: @json($durationDistribution->pluck('count')),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                }]
            },
            options: {
                responsive: true
            }
        });
        @endif
    });
</script>
@endsection
