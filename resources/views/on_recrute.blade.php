@extends('layouts.app')

@section('title', 'Mentions Légales')

@include('partials.header')

@section('content')

<main class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-xl rounded-2xl p-8 text-center">
            <h1 class="text-4xl font-bold text-blue-600">Nous Recrutons !</h1>
            <p class="mt-4 text-gray-600">Rejoignez une équipe dynamique et innovante.</p>

            <img src="{{ asset('storage/images/photo_equipe.png') }}" width="600" height="400" class="mx-auto mt-6 rounded-lg shadow-lg" alt="Équipe de l'entreprise">
            
            <div class="mt-6 grid md:grid-cols-2 gap-6">
                <div class="p-6 bg-blue-50 rounded-xl shadow-md">
                    <h2 class="text-2xl font-semibold text-blue-700">Développeur Web</h2>
                    <p class="mt-2 text-gray-700">Vous maîtrisez Laravel et Tailwind CSS ? Ce poste est fait pour vous !</p>
                    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Postuler</button>
                </div>
                <div class="p-6 bg-green-50 rounded-xl shadow-md">
                    <h2 class="text-2xl font-semibold text-green-700">Designer UI/UX</h2>
                    <p class="mt-2 text-gray-700">Vous avez un œil pour le design et l'expérience utilisateur ? Rejoignez-nous !</p>
                    <button class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Postuler</button>
                </div>
            </div>
            
            <div class="mt-8">
                <p class="text-gray-600">Envoyez votre CV à <span class="font-semibold text-blue-500">recrutement@entreprise.com</span></p>
            </div>
        </div>
    </div>
</main>


@include('partials.footer')
@endsection