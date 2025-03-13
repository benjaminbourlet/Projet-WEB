@extends('layouts.app')

@section('title', 'Informations de ' . $user->name)

@include('partials.header')

<main class="flex-grow container mx-auto p-6 min-h-screen">
    <div class="flex mt-10 bg-[#EEEEEE]">
        <div class="w-1/3 bg-[#387077] rounded-lg shadow-lg">
            <div class="max-w-md mx-auto mt-6 p-6">

                <div class="container mx-auto p-4">
                    <h1 class="text-2xl font-bold text-center">Profil de {{ $user->name }}</h1>

                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto"
                            alt="Logo">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold"> Nom :</label>
                        <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">{{ $user->name ?? 'Non défini' }}
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
                    <form action="{{ route('user_edit', ['role' => $role === 'Etudiant' ? 'students' : 'pilots', 'id' => $user->id]) }}" method="GET" class="flex-grow mr-1">
                        <button class="bg-[#3D9DA9] text-white px-4 py-2 rounded-lg hover:bg-[#3D8A8F]" type="submit">
                            Modifier
                        </button>
                    </form>

                    <form action="{{ route('user_delete', ['id' => $user->id]) }}" method="POST"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?'); class="flex-grow mr-1"">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-[#8C3740] text-white px-4 py-2 rounded-lg hover:bg-[#70383E]">
                            Supprimer
                        </button>
                    </form>

                </div>
            </div>
        </div>
        <div class="w-2/3">
            @if ($user->hasRole('Etudiant'))

                <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold mb-4">Dernières Candidatures</h2>

                    @if ($user->applications->isEmpty())
                        <p>Aucune candidature récente.</p>
                    @else
                        <ul>
                            @foreach ($user->applications as $application)
                                <li class="border-b py-2">
                                    <strong>Offre :</strong> {{ $application->offer->title ?? 'Non défini' }} <br>
                                    <p><strong>Statut :</strong> {{ $application->status->name ?? 'Non défini' }}</p>
                                    <span class="text-gray-500 text-sm">
                                        Déposée le {{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}
                                    </span>
                                </li>
                                <td class="border p-2">
                                    <a href="{{ route('applications_info_user', ['user_id' => $user->id, 'offer_id' => $application->offer_id]) }}"
                                        class="text-blue-500 hover:underline">Voir</a>
                                </td>
                            @endforeach
                        </ul>
                    @endif
                </div>

            @endif
        </div>
    </div>

</main>

@include('partials.footer')