@extends('layouts.app')

@section('title', 'Avis')

@section('content')
        <!-- Liste des évaluations -->
        <div class="w-4/5">
            <div class="mb-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Avis</h1>
            </div>

            <!-- Liste des avis -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold mb-4">Liste des avis :</h4>
                @forelse ($evaluations as $evaluation)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <a href="{{ route('company_info', ['id' => $evaluation->company_id]) }}"
                            >
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">
                                   Utilisateur : {{ $evaluation->user_first_name ?? 'Utilisateur inconnu' }}
                                    {{ $evaluation->user_name ?? '' }}
                                </span>
                                <span
                                    class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($evaluation->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">
                                    Entreprise : {{ $evaluation->company_name ?? 'Entreprise inconnue' }}
                                </span>
                            </div>
                            <div class="flex mb-2">
                                @for ($i = 0; $i < $evaluation->grade; $i++)
                                    <span class="text-yellow-500">&#9733;</span>
                                @endfor
                            </div>
                            <div class="italic text-gray-600">
                                <p>{{ $evaluation->comment ?? 'Pas de commentaire' }}</p>
                            </div>
                            @role('Admin')
                            <form action="{{ route('evaluations_remove', ['user_id' => $evaluation->user_id, 'company_id' => $evaluation->company_id]) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette evaluation ?');"
                                        class="ml-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 pt-1.5 pb-1.5 bg-red-500 rounded-lg">X</button>
                                    </form>
                            @endrole
                    </div>
                @empty
                    <p class="text-gray-500">Aucun avis disponible.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($evaluations->hasPages())
                <div class="mt-6">
                    {{ $evaluations->links() }}
                </div>
            @endif
        </div>
@endsection