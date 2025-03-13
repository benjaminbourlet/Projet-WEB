@extends('layouts.app')

@section('title', 'Postuler à une offre')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Postuler à l'offre : {{ $offer->title }}</h2>

        @if (session('error'))
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('applicationRegister', ['offer_id' => $offer->id]) }}" enctype="multipart/form-data">
            @csrf

            {{-- Champ CV --}}
            <div class="mb-4">
                <label for="cv" class="block text-sm font-medium text-gray-700">CV (PDF, DOC, DOCX)</label>
                <input type="file" id="cv" name="cv" required accept=".pdf,.doc,.docx"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                @error('cv') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Champ Lettre de motivation --}}
            <div class="mb-4">
                <label for="cover_letter" class="block text-sm font-medium text-gray-700">Lettre de motivation</label>
                <textarea id="cover_letter" name="cover_letter" rows="4"
                    class="w-full mt-1 p-2 border rounded-md @error('cover_letter') border-red-500 @enderror"
                    placeholder="Rédigez votre lettre de motivation ici...">{{ old('cover_letter') }}</textarea>
                @error('cover_letter')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Champs cachés --}}
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <input type="hidden" name="offer_id" value="{{ $offer->id }}">
            <input type="hidden" name="status_id" value="1"> {{-- Vérifier que le statut "1" est bien valide en backend --}}

            {{-- Bouton d'envoi --}}
            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 mt-4">
                Envoyer la candidature
            </button>

        </form>
    </div>
@endsection
