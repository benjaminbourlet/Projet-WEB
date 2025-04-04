@extends('layouts.app')
{{--
    Fichier : update.blade.php
    Description : Formulaire de mise à jour des informations de l'utilisateur
--}}

@section('title', 'Informations de ' . $user->name)

@section('content')
    {{-- Début de la page de mise à jour --}}
    <main>

        {{-- Conteneur principal du formulaire de mise à jour --}}
        <div class="mt-10 mb-10 w-2/3 mx-auto">
            <div class="container mx-auto p-4 bg-[#387077] rounded-lg shadow-lg">
                {{-- Titre et affichage du profil de l'utilisateur --}}
                <h1 class="text-2xl font-bold">Profil de {{ $user->name }}</h1>

                {{-- Affichage des erreurs de validation, le cas échéant --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Affichage de la photo de profil actuelle --}}
                <div class="mt-4">
                    <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Avatar">
                </div>

                {{-- Début du formulaire de mise à jour de l'utilisateur --}}
                <form action="{{ route('user_update', ['role' => $role, 'id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Zone de mise à jour de la photo de profil --}}
                    <div class="grid grid-cols-1 place-items-center mt-1 w-full">
                        <label class="block font-bold mb-1">Photo de profil :</label>
                        <div class="relative w-full max-w-xs cursor-pointer" onclick="document.getElementById('fileInput').click()">
                            <input id="fileInput" type="file" name="pp" class="hidden">
                            <div class="bg-[#D9D9D9] p-2 rounded-lg text-center">Choisir un fichier</div>
                        </div>
                        @error('pp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Champ de mise à jour du nom --}}
                    <div>
                        <label class="block font-bold">Nom :</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Champ de mise à jour du prénom --}}
                    <div>
                        <label class="block font-bold">Prénom :</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                        @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Champ de mise à jour de la date de naissance --}}
                    <div class="mb-4">
                        <label class="block font-bold">Date de naissance :</label>
                        <input type="date" name="birthdate" value="{{ old('birthdate', $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') : '') }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                        @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Champ de mise à jour de l'email --}}
                    <div>
                        <label class="block font-bold">Email :</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Affichage de la région (non modifiable) --}}
                    <div class="mb-4">
                        <label class="block font-bold">Région :</label>
                        <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                            {{ optional(optional($user->city)->region)->name ?? 'Non défini' }}
                        </p>
                    </div>

                    {{-- Sélection de la ville --}}
                    <div class="mb-4">
                        <label class="block font-bold">Ville :</label>
                        <select name="city_id" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                            <option value="">Sélectionnez une ville</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Sélection de la classe ou des classes selon le rôle de l'utilisateur --}}
                    @if ($role === 'Etudiant')
                        {{-- Pour les étudiants, sélection d'une classe (promo) --}}
                        <div>
                            <label class="block font-bold">Classe (Promo)</label>
                            <select id="classe_id" name="classe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-[#D9D9D9]">
                                <option value="">Sélectionnez une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ old('classe_id', $user->classe_id) == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif ($role === 'Pilote')
                        {{-- Pour les pilotes, sélection multiple des classes --}}
                        <div>
                            <label class="block font-bold">Classes (Sélection multiple)</label>
                            <select id="classesPilots" name="classesPilots[]" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-[#D9D9D9]">
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ in_array($classe->id, old('classesPilots', $user->classesPilots->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $classe->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Option pour créer une nouvelle classe --}}
                    <div>
                        <label class="block font-bold">Ou créez une nouvelle classe</label>
                        <input type="text" name="new_classe" value="{{ old('new_classe') }}" class="w-full border p-1.5 bg-[#D9D9D9] rounded-lg text-xs">
                        @error('new_classe') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Boutons pour annuler ou confirmer la mise à jour --}}
                    <div class="flex justify-between">
                        <button type="button" class="bg-[#3D9DA9] hover:bg-[#3D8A8F] text-white px-4 py-2 rounded mt-4" onclick="window.history.back()">
                            Annuler
                        </button>
                        <button type="submit" class="bg-[#3D9DA9] hover:bg-[#3D8A8F] text-white px-4 py-2 rounded mt-4">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

@endsection