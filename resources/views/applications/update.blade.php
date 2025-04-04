@extends('layouts.app')
{{-- 
    Fichier : resources/views/applications/update.blade.php
    Description : Formulaire de modification d'une candidature. Permet de mettre à jour le statut et de visualiser les informations associées.
--}}

@section('title', 'Modification de ' . $application->name)
{{-- Titre de la page de modification de la candidature --}}

@section('content')

    <!-- Titre principal de la page indiquant pour quelle offre la candidature est effectuée -->
    <h1 class="text-2xl font-bold px-8">Candidature pour : {{ $application->offer->title }}</h1>

    <!-- Conteneur principal pour le formulaire de modification -->
    <div class="flex container mx-auto p-4 w-full flex-grow items-center">

        <!-- Carte de modification de la candidature avec un style personnalisé -->
        <div class="bg-[#5A8E95] shadow-md rounded-2xl flex flex-col justify-between border border-[#5A8E95] gap-2 p-2 max-w-3/4 mx-auto">

            <!-- Formulaire pour mettre à jour la candidature -->
            <form action="{{ route('applications_update', ['user_id' => $application->user->id, 'offer_id' => $application->offer->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Inclusion du token CSRF pour la sécurité du formulaire --}}

                <!-- Affichage du titre de l'offre -->
                <p><strong>{{ $application->offer->title }}</strong></p>
                <!-- Affichage de la date de création de la candidature -->
                <p><strong>Date :</strong> {{ $application->created_at->format('d/m/Y') }}</p>

                <!-- Section de sélection du statut de la candidature -->
                <div class="mb-4">
                    <label class="block font-bold">Statut :</label>
                    <select name="status_id" class="border p-2 w-full">
                        <option value="">Sélectionnez un statut</option>
                        @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ $application->status_id == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lien pour consulter le CV associé à la candidature -->
                <p><strong>CV :</strong>
                    <a href="{{ asset('storage/' . $application->cv) }}" class="text-gray-200 hover:underline" target="_blank">
                        Voir le CV
                    </a>
                </p>
                <!-- Affichage de la lettre de motivation -->
                <p><strong>Lettre de motivation :</strong> {{ $application->cover_letter }}</p>

                <!-- Liens pour revenir ou soumettre le formulaire de modification -->
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <a href="javascript:window.history.back();" class="inline-block text-gray-200 hover:underline px-4">
                        Retour
                    </a>
                    <button type="submit" class="cursor-pointer text-gray-200 hover:underline px-4">
                        Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection