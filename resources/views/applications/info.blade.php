@extends('layouts.app')

@section('title', 'Détail de ma candidature')

@section('content')
<main class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Détails de la Candidature</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <p><strong>Offre :</strong> {{ $application->offer->title }}</p>
        <p><strong>Date :</strong> {{ $application->created_at->format('d/m/Y') }}</p>
        <p><strong>Statut :</strong> {{ $application->status->name }}</p>
        <p><strong>CV :</strong> 
            <a href="{{ asset('storage/' . $application->cv) }}" class="text-blue-500 hover:underline" target="_blank">
                Voir le CV
            </a>
        </p>
        <p><strong>Lettre de motivation :</strong> {{ $application->cover_letter }}</p>

        <a href="{{ route('applications_show', ['user_id' => $user->id]) }} " class="mt-4 inline-block text-blue-500 hover:underline">Retour à la liste</a>

        <a href="{{ route('applications_edit', ['user_id' => $user->id, 'offer_id' => $application->offer->id]) }} " class="mt-4 inline-block text-blue-500 hover:underline">Modifie le statut</a>

    </div>
</main>
@endsection
