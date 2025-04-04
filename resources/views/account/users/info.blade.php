@extends('layouts.app')
{{-- 
    Fichier: info.blade.php
    Description: Affiche les informations détaillées d'un utilisateur, y compris son profil, ses candidatures, 
                 sa wishlist et ses statistiques. Les sections sont adaptées en fonction du rôle de l'utilisateur.
--}}

@section('title', 'Informations de ' . $user->name)

@section('content')
    <main>
        <div class="flex-grow container mx-auto p-6 min-h-screen">
            <div class="flex flex-col md:flex-row mt-10 bg-[#EEEEEE]">
                <div class="w-full md:w-1/3 bg-[#387077] rounded-lg shadow-lg mb-6 md:mb-0 min-h-full flex flex-col justify-between">
                    <div class="max-w-md mx-auto mt-6 p-6">

                        <div class="container mx-auto p-4">
                            <h1 class="text-2xl font-bold">Profil de {{ $user->name }}</h1>

                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto"
                                    alt="Logo">
                            </div>

                            <div class="mb-4">
                                <label class="block font-bold"> Nom :</label>
                                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                                    {{ $user->name ?? 'Non défini' }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block font-bold">Prenom :</label>
                                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                                    {{ $user->first_name ?? 'Non défini' }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block font-bold">Adresse mail :</label>
                                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                                    {{ $user->email ?? 'Non défini' }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block font-bold">Date de naissance :</label>
                                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                                    {{ \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') ?? 'Non défini' }}
                                </p>
                            </div>

                            @if ($role === 'Etudiant')
                                <div class="mb-4">
                                    <label class="block font-bold">Classe (Promo) :</label>
                                    <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                                        {{ $user->classe ? $user->classe->name : 'Aucune classe' }}
                                    </p>
                                </div>
                            @elseif ($role === 'Pilote')
                                <div class="mb-4">
                                    <label class="block font-bold">Classes :</label>
                                    <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                                        {{ $user->classesPilots->isNotEmpty() ? $user->classesPilots->pluck('name')->implode(', ') : 'Aucune classe' }}
                                    </p>
                                </div>
                            @endif


                            <div class="mb-4">
                                <label class="block font-bold">Région :</label>
                                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                                    {{ $user->city->region->name ?? 'Non défini' }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block font-bold">Ville :</label>
                                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                                    {{ ($user->city)->name ?? 'Non défini' }}
                                </p>
                            </div>
                        </div>
                        <!-- Boutons de modification et de suppression -->
                        <div class="mb-4 flex justify-between">
                            <!-- Bouton Modifier -->
                            <form
                                action="{{ route('user_edit', ['role' => $role === 'Etudiant' ? 'students' : 'pilots', 'id' => $user->id]) }}"
                                method="GET" class="flex-grow mr-1">
                                <button class="bg-[#3D9DA9] text-white px-4 py-2 rounded-lg hover:bg-[#3D8A8F]"
                                    type="submit">
                                    Modifier
                                </button>
                            </form>

                            <form action="{{ route('user_delete', ['id' => $user->id]) }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-[#8C3740] text-white px-4 py-2 rounded-lg hover:bg-[#70383E]">
                                    Supprimer
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="w-full md:w-2/3 md:ml-4 bg-white rounded-lg shadow-lg p-6 flex flex-col justify-center">
                    @if ($user->hasRole('Etudiant'))
                        <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
                            <h2 class="text-xl font-bold mb-4">Dernières Candidatures</h2>
                            @if ($user->applications->isEmpty())
                                <p>Aucune candidature récente.</p>
                            @else
                                <ul>
                                    @foreach ($user->applications->take(3) as $application)
                                        <li class="border-b py-2">
                                            <strong>Offre :</strong> {{ $application->offer->title ?? 'Non défini' }} <br>
                                            <p><strong>Statut :</strong> {{ $application->status->name ?? 'Non défini' }}</p>
                                            <span class="text-gray-500 text-sm">Déposée le
                                                {{ optional($application->created_at)->format('d/m/Y') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <a href="{{ route('applications_list_user', ['user_id' => $user->id]) }}"
                            class="text-[#3D9DA9] hover:underline">Voir toutes les candidatures</a>
                        <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
                            <h2 class="text-xl font-bold mb-4">Dernières offres ajoutées à la wishlist</h2>
                            @if ($user->wishlists->isEmpty())
                                <p>Aucun ajout récent dans la wishlist.</p>
                            @else
                                <ul>
                                    @foreach ($user->wishlists->take(3) as $wishlist)
                                        <li class="border-b py-2">
                                            <strong>Offre :</strong> {{ $wishlist->title ?? 'Non défini' }} <br>
                                            <span class="text-gray-500 text-sm">Ajouté le
                                                {{ optional($wishlist->pivot->created_at)->format('d/m/Y') ?? 'Date inconnue' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <a href="{{ route('wishlists_list_user', ['user_id' => $user->id]) }}"
                            class="text-[#3D9DA9] hover:underline">Voir la wishlist</a>

                        {{-- Section Statistiques: Affiche les statistiques des candidatures de l'utilisateur --}}
                        <div class="mt-10">
                            <h2 class="text-2xl font-bold mb-6 text-gray-800">📊 Statistiques</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Carte des candidatures -->
                                <div class="bg-green-100 text-green-900 rounded-xl shadow-md p-6">
                                    <h3 class="text-lg font-semibold mb-2">Nombre total de candidatures</h3>
                                    <p class="text-4xl font-bold">{{ $totalApplications }}</p>
                                </div>

                                <!-- Graphique des candidatures -->
                                <div class="bg-white rounded-xl shadow-md p-6">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Répartition des candidatures</h3>
                                    <canvas id="applicationsChart"
                                        data-accepted="{{ $acceptedApplications }}"
                                        data-rejected="{{ $rejectedApplications }}"
                                        data-pending="{{ $pendingApplications }}"
                                        data-traitement="{{ $traitementApplications }}"
                                        data-interview="{{ $interviewApplications }}"
                                        class="mx-auto max-w-full h-64">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </main>

@endsection