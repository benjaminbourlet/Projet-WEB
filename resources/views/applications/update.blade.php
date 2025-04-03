@extends('layouts.app')

@section('title', 'Modification de ' . $application->name)

@section('content')
<h1 class="text-2xl font-bold px-8">Candidature pour : {{ $application->offer->title }}</h1>

<div class="flex container mx-auto p-4 w-full flex-grow items-center">

    <div class="bg-[#5A8E95] shadow-md rounded-2xl flex flex-col justify-between border border-[#5A8E95] gap-2 p-2 max-w-3/4 mx-auto">

        <form
            action="{{ route('applications_update', ['user_id' => $application->user->id, 'offer_id' => $application->offer->id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            <p><strong> {{ $application->offer->title }} </strong></p>
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
                <a href="{{ asset('storage/' . $application->cv) }}" class="text-gray-200 hover:underline" target="_blank">
                    Voir le CV
                </a>
            </p>
            <p><strong>Lettre de motivation :</strong> {{ $application->cover_letter }}</p>
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