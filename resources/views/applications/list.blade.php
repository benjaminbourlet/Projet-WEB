@extends('layouts.app')

@section('title', 'Mes candidatures')

@include('partials.header')

@section('content')

    <main class="flex-grow container mx-auto p-4 flex gap-6">
        <h1 class="text-2xl font-bold mb-4">Mes Candidatures</h1>

        @if ($applications->isEmpty())
            <p>Aucune candidature trouvée.</p>
        @else
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Offre</th>
                        <th class="border p-2">Date</th>
                        <th class="border p-2">Statut</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr class="border">
                            <td class="border p-2">{{ $application->offer->title }}</td>
                            <td class="border p-2">{{ $application->created_at->format('d/m/Y') }}</td>
                            <td class="border p-2">{{ $application->status->name }}</td>
                            <td class="border p-2">
                                <a href="{{ route('applications_info', ['user_id' => $user->id, 'offer_id' => $application->offer_id]) }}"
                                    class="text-blue-500 hover:underline">Voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $applications->links() }}
            </div>
        @endif
    </main>

    @include('partials.footer')
@endsection