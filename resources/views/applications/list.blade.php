@extends('layouts.app')

@section('title', 'Mes candidatures')


@section('content')
<h1 class="text-2xl font-bold mb-4 ml-4">Mes Candidatures</h1>

<div class="container mx-auto p-4 items-center flex justify-center" x-data="{ showModal: false, application: null }">

    @if ($applications->isEmpty())
    <p>Aucune candidature trouvée.</p>
    @else
    <table class="w-full overflow-x-auto border border-gray-200 shadow-md px-4 mx-auto">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Offre</th>
                <th class="border p-2">Date de postulation</th>
                <th class="border p-2">Statut</th>
                <th class="border p-2">Détails de la candidature</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $application)
            <tr class="border">
                <!-- Titre de l'offre -->
                <td class="border p-2 text-center">
                    <a href="{{ route('offer_info', ['id' => $application->offer->id, 'title' => Str::slug($application->offer->title)]) }}">
                        {{ $application->offer->title }}
                    </a>
                </td>

                <!-- Date de la candidature -->
                <td class="border p-2 text-center">{{ $application->created_at->translatedFormat('d F Y') }}</td>

                <!-- Statut de la candidature -->
                <td class="border p-2 text-center">
                    <span class="
                        @if ($application->status->id == 1 || $application->status->id == 2)
                        text-black
                        @elseif ($application->status->id == 3)
                        text-green-900
                        @elseif ($application->status->id == 4)
                        text-green-600
                        font-bold
                        @elseif ($application->status->id == 5)
                        text-red-600
                        font-bold
                        @endif
                        ">
                        {{ $application->status->name }}
                    </span>
                </td>

                <!-- Détails de la candidature -->
                <td class="border p-2 text-center">
                    <button @click="showModal = true; application = {{ json_encode($application) }}"
                        class="text-[#387077] hover:underline">
                        Voir
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $applications->links() }}
    </div>
    @endif
    <!-- Pop-up -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 z-50">
        <div class="bg-[#5A8E95] text-white shadow-md rounded-2xl flex flex-col gap-2 p-6 max-w-lg mx-auto relative">
            <button @click="showModal = false" class="absolute top-2 right-2 text-xl font-bold">&times;</button>
            <h6 class="text-xl font-bold mb-2" x-text="application.offer.title"></h6>
            <p><strong>Date :</strong> <span x-text="new Date(application.created_at).toLocaleDateString('fr-FR')"></span></p>
            <div class="flex gap-2 items-center">
                <p><strong>Statut :</strong> <span x-text="application?.status?.name ?? ''"></span></p>
                @role('Admin')
                <a :href="'{{ url('students') }}/' + application?.user_id + '/applications/' + application?.offer?.id + '/edit'"
                    class="border-2 border-red-700 p-2 inline-block text-red-700 hover:underline rounded-lg hover:bg-red-200">
                    Modifier le statut
                </a>
                @endrole
            </div>
            <p><strong>CV :</strong>
                <a :href="'/storage/' + application.cv" class="text-gray-200 hover:underline" target="_blank">
                    Voir le CV
                </a>
            </p>
            <div class="flex flex-col">
                <p><strong>Lettre de motivation :</strong></p>
                <p class="px-4" x-text="application.cover_letter"></p>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center">
                <a href="javascript:void(0);" @click="showModal = false" class="text-gray-200 hover:underline px-4">
                    Retour
                </a>
                <a href="{{ route('offer_info', ['id' => $application->offer->id, 'title' => Str::slug($application->offer->title)]) }}"
                class="cursor-pointer text-gray-200 hover:underline px-4">
                    Voir l'offre
                </a>
            </div>
        </div>
    </div>
</div>

@endsection