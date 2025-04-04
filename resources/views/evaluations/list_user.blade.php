{{-- Vue listant les avis des utilisateurs --}}
@extends('layouts.app')

@section('title', 'Avis')
{{-- Définition du titre de la page --}}

@section('content')

{{-- Vérifie s'il y a des avis publiés --}}
@if ($evaluations->isEmpty())
    {{-- Message affiché lorsque aucun avis n'est publié --}}
    <p class="text-gray-500">Aucun avis n'a été publié</p>
@else

{{-- Conteneur principal pour l'affichage des avis --}}
    {{-- Début de la section principale avec animation de la bannière --}}
    <main class="m-10">
        {{-- Titre de la page avec animation --}}
        <div class="container mx-auto text-center">
            <h1
                class="text-5xl font-bold bg-gradient-to-r from-white via-[#3D9DA9] to-white bg-clip-text text-transparent bg-[length:200%_200%] animate-gradientHorizontal">
                Mes avis
            </h1>
        </div>

        {{-- Conteneur pour la liste des avis --}}
        <div class="container mx-auto px-4 py-8">

            {{-- Section listant les avis --}}
            <div class="space-y-6">
                {{-- Titre de la section des avis --}}
                <h4 class="text-xl font-semibold text-gray-700 mb-4">Liste des avis :</h4>
                {{-- Boucle sur chaque avis pour affichage --}}
                @forelse ($evaluations as $evaluation)
                    {{-- Lien vers la page de l'entreprise associée à l'avis --}}
                    <a href="{{ route('company_info', ['id' => $evaluation->company_id]) }}"
                        class="block bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-150 ease-in-out">
                        {{-- Informations de l'auteur de l'avis et date de publication --}}
                        <div class="flex justify-between items-center mb-2">
                            <div class="font-semibold text-lg text-gray-800">
                                {{ $evaluation->user_first_name ?? 'Utilisateur inconnu' }} {{ $evaluation->user_name ?? '' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($evaluation->created_at)->format('d M Y') }}
                            </div>
                        </div>
                        {{-- Nom de l'entreprise associée à l'avis --}}
                        <div class="mb-2">
                            <span class="font-semibold text-gray-800">
                                Entreprise : {{ $evaluation->company_name ?? 'Entreprise inconnue' }}
                            </span>
                        </div>
                        {{-- Affichage de la note sous forme d'étoiles --}}
                        <div class="mb-2 flex items-center">
                            @for ($i = 0; $i < $evaluation->grade; $i++)
                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927C9.324 2.292 10.676 2.292 10.951 2.927l1.466 3.732a1 1 0 00.753.548l4.123.598c.845.122 1.184 1.16.573 1.752l-2.983 2.91a1 1 0 00-.287 1.053l.704 4.1c.146.853-.751 1.5-1.535 1.1L10 16.347l-3.695 1.943c-.784.4-1.681-.247-1.535-1.1l.704-4.1a1 1 0 00-.287-1.053L1.86 9.557c-.611-.592-.272-1.63.573-1.752l4.123-.598a1 1 0 00.753-.548L9.049 2.927z">
                                    </path>
                                </svg>
                            @endfor
                        </div>
                        <div class="flex justfiy-between">
                            {{-- Affichage du commentaire de l'utilisateur --}}
                            <p class="italic text-gray-600">
                                <!-- italic :rende le texte en italique -->
                                {{ $evaluation->comment ?? 'Pas de commentaire' }}
                            </p>
                            {{-- Formulaire de suppression de l'avis --}}
                            <form
                                action="{{ route('evaluations_remove', ['user_id' => $evaluation->user_id, 'company_id' => $evaluation->company_id]) }}"
                                method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette evaluation ?');"
                                class="ml-auto">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 pt-1.5 pb-1.5 bg-red-500 rounded-lg">X</button>
                            </form>
                        </div>
                    </a>
                @empty
                    {{-- Message affiché lorsque la liste des avis est vide --}}
                    <p class="text-gray-500">Aucun avis disponible.</p>
                @endforelse
            </div>

            {{-- Affichage de la pagination des avis --}}
            @if ($evaluations->hasPages())
                <div class="mt-8">
                    {{ $evaluations->links() }}
                </div>
            @endif
        </div>
    </main>
@endif
@endsection