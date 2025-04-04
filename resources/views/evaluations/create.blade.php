{{-- Vue pour la création d'une évaluation --}}
@extends('layouts.app')

@section('title', 'Evaluate' . $company->name)
{{-- Définition du titre de la page avec le nom de l'entreprise --}}

@section('content')
{{-- Contenu principal de la page d'évaluation --}}
    <main>
        <div class="flex items-center justify-center auto-h-screen bg-gray-100">
            {{-- Conteneur centré pour l'affichage de la carte d'évaluation --}}
            <div class="bg-white p-6 rounded-lg shadow-md w-96">
                <h2 class="text-xl font-bold mb-4">Donnez votre avis</h2>
                {{-- Formulaire de soumission de l'évaluation --}}
                <form action="{{ route('evaluationsCreate', ['company_id' => $company->id]) }}" method="POST">
                    @csrf
                    {{-- Protection CSRF pour sécuriser le formulaire --}}

                    {{-- Champ caché pour l'ID de l'utilisateur authentifié --}}
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    {{-- Champ caché pour l'ID de l'entreprise --}}
                    <input type="hidden" name="company_id" value="{{ $company->id }}">

                    {{-- Section de notation avec étoiles interactives --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Note :</label>
                        {{-- Génération des étoiles de notation (de 1 à 5) --}}
                        <div class="flex space-x-1" id="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 cursor-pointer text-gray-300 star" data-value="{{ $i }}"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path
                                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                            @endfor
                            {{-- Champ caché pour stocker la note sélectionnée --}}
                        </div>
                        <input type="hidden" name="grade" id="grade" value="">
                    </div>

                    {{-- Zone de saisie pour le commentaire de l'utilisateur --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Commentaire :</label>
                        <textarea name="comment" class="w-full p-2 border rounded-lg" rows="3"
                            placeholder="Votre commentaire..."></textarea>
                    </div>

                    {{-- Bouton de soumission du formulaire --}}
                    <button type="submit"
                        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Envoyer</button>
                </form>
            </div>
    </main>
@endsection