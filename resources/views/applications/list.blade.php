@extends('layouts.app')

@section('title', 'Mes candidatures')


@section('content')
<h1 class="text-2xl font-bold mb-4 ml-4">Mes Candidatures</h1>

<div class="container mx-auto p-4 items-center flex justify-center">

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


                <td class="border p-2 text-center">
                    <a href="{{ route('applications_info', ['user_id' => $user->id, 'offer_id' => $application->offer_id]) }}"
                        class="text-[#387077] hover:underline">Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $applications->links() }}
    </div>
    @endif
</div>

@endsection