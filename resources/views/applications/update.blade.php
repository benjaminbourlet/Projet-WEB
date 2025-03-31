@extends('layouts.app')

@section('title', 'Modification de ' . $application->name)

@section('content')

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Candidature pour {{ $application->offer->title }}</h1>

        <form
            action="{{ route('applications_update', ['user_id' => $application->user->id, 'offer_id' => $application->offer->id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            <p><strong>Offre :</strong> {{ $application->offer->title }}</p>
            <p><strong>Date :</strong> {{ $application->created_at->format('d/m/Y') }}</p>
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
            <p><strong>CV :</strong>
                <a href="{{ asset('storage/' . $application->cv) }}" class="text-blue-500 hover:underline" target="_blank">
                    Voir le CV
                </a>
            </p>
            <p><strong>Lettre de motivation :</strong> {{ $application->cover_letter }}</p>


            <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">
                Modifier
            </button>
        </form>
    </div>

@endsection
