{{-- Vue affichant les évaluations d'une entreprise --}}
@extends('layouts.app')

{{-- Définition du titre de la page avec le nom de l'entreprise --}}
@section('title', 'Évaluations de ' . $company->name)

{{-- Contenu de la page des évaluations --}}
@section('content')

{{-- Vérification si aucune évaluation n'est disponible --}}
@if ($evaluations->isEmpty())
    {{-- Message affiché si aucun avis n'est publié --}}
    <p class="text-gray-500">Aucun avis n'a été publié</p>
@else
    {{-- Contenu principal des évaluations affichées --}}
    <main>
        {{-- Container principal pour la mise en page des évaluations --}}
        <div class="container mx-auto p-6">
            {{-- Titre principal affichant le nom de l'entreprise --}}
            <h1 class="text-3xl font-semibold mb-6">Évaluations pour l'entreprise: {{ $company->name }}</h1>

            {{-- Affichage de la moyenne des notes des évaluations --}}
            <!-- Moyenne des notes -->
            <div class="mb-6">
                <h3 class="text-xl font-bold">Moyenne des notes:
                    <span class="text-green-500">
                        {{ number_format($evaluations->avg('pivot.grade') ?? 0, 1) }} / 5
                    </span>
                </h3>
            </div>

            {{-- Affichage de la répartition des évaluations par note --}}
            <!-- Répartition des notes -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-2">Répartition des évaluations :</h4>
                <div class="space-y-3">
                    {{-- Boucle pour afficher la répartition des évaluations par note --}}
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

            {{-- Affichage de la liste détaillée des avis --}}
            <!-- Liste des avis -->
            <div class="space-y-4">
                {{-- Boucle sur chaque évaluation --}}
                <h4 class="text-lg font-semibold mb-4">Liste des avis :</h4>
                @foreach ($evaluations as $evaluation)
                    {{-- Conteneur de chaque avis individuel --}}
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        {{-- Informations de l'auteur et de la date de publication --}}
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">
                                {{ optional($evaluation)->first_name ?? 'Utilisateur inconnu' }}
                                {{ optional($evaluation)->name ?? '' }}
                            </span>

                            <span class="text-sm text-gray-500">{{ $evaluation->pivot->created_at->format('d M Y') }}</span>
                        </div>
                        {{-- Affichage de la note sous forme d'étoiles --}}
                        <div class="flex mb-2">
                            @for ($i = 0; $i < $evaluation->pivot->grade; $i++)
                                <span class="text-yellow-500">&#9733;</span> <!-- Étoile -->
                            @endfor
                        </div>
                        {{-- Affichage du commentaire de l'évaluation --}}
                        <div class="italic text-gray-600">
                            <p>{{ $evaluation->pivot->comment ?? 'Pas de commentaire' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Affichage de la pagination --}}
            <!-- Pagination -->
            <div class="mt-6">
                {{ $evaluations->links() }}
            </div>
        </div>

    </main>
@endif
@endsection