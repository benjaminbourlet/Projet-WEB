@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-6">Évaluations pour l'entreprise: {{ $company->name }}</h1>

        <!-- Moyenne des notes -->
        <div class="mb-6">
            <h3 class="text-xl font-bold">Moyenne des notes:
                <span class="text-green-500">
                    {{ number_format($evaluations->avg('pivot.grade') ?? 0, 1) }} / 5
                </span>
            </h3>
        </div>

        <!-- Répartition des notes -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold mb-2">Répartition des évaluations :</h4>
            <div class="space-y-3">
                @foreach ([5, 4, 3, 2, 1] as $i)
                            @php
                                $count = $evaluations->where('pivot.grade', $i)->count();
                                $total = $evaluations->count();
                                $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                            @endphp
                            <div class="flex items-center">
                                <span class="w-24 text-sm">{{ $i }} étoiles</span>
                                <div class="relative flex-1 h-4 bg-gray-200 rounded-full">
                                    <div class="h-full bg-green-500 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="ml-2 text-sm">{{ $count }}</span>
                            </div>
                @endforeach
            </div>
        </div>

        <!-- Liste des avis -->
        <div class="space-y-4">
            <h4 class="text-lg font-semibold mb-4">Liste des avis :</h4>
            @foreach ($evaluations as $evaluation)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">
                            {{ optional($evaluation)->first_name ?? 'Utilisateur inconnu' }}
                            {{ optional($evaluation)->name ?? '' }}
                        </span>

                        <span class="text-sm text-gray-500">{{ $evaluation->pivot->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex mb-2">
                        @for ($i = 0; $i < $evaluation->pivot->grade; $i++)
                            <span class="text-yellow-500">&#9733;</span> <!-- Étoile -->
                        @endfor
                    </div>
                    <div class="italic text-gray-600">
                        <p>{{ $evaluation->pivot->comment ?? 'Pas de commentaire' }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $evaluations->links() }}
        </div>
    </div>
@endsection