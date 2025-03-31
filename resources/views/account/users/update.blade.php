@extends('layouts.app')

@section('title', 'Informations de ' . $user->name)

@include('partials.header')

<main class="mt-10 mb-10 w-2/3 mx-auto">
    <div class="container mx-auto p-4 bg-[#387077] rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold">Profil de {{ $user->name }}</h1>

        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-4">
            <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Avatar">
        </div>

        <form action="{{ route('user_update', ['role' => $role, 'id' => $user->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <!-- Photo de profil -->
            <div class="grid grid-cols-1 place-items-center mt-1 w-full">
                <label class="block font-bold mb-1">Photo de profil :</label>
                <div class="relative w-full max-w-xs cursor-pointer" onclick="document.getElementById('fileInput').click()">
                    <input id="fileInput" type="file" name="pp" class="hidden">
                    <div class="bg-[#D9D9D9] p-2 rounded-lg text-center">Choisir un fichier</div>
                </div>
                @error('pp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Nom -->
            <div>
                <label class="block font-bold">Nom :</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Prénom -->
            <div>
                <label class="block font-bold">Prénom :</label>
                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                    class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Date de naissance -->
            <div class="mb-4">
                <label class="block font-bold">Date de naissance :</label>
                <input type="date" name="birthdate"
                    value="{{ old('birthdate', $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') : '') }}"
                    class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block font-bold">Email :</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Région -->
            <div class="mb-4">
                <label class="block font-bold">Région :</label>
                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                    {{ optional(optional($user->city)->region)->name ?? 'Non défini' }}
                </p>
            </div>

            <!-- Ville -->
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

            <!-- Classe -->
            @if ($role === 'Etudiant')
                <div>
                    <label class="block font-bold">Classe (Promo)</label>
                    <select id="classe_id" name="classe_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-[#D9D9D9]">
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ old('classe_id', $user->classe_id) == $classe->id ? 'selected' : '' }}>
                                {{ $classe->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @elseif ($role === 'Pilote')
                <div>
                    <label class="block font-bold">Classes (Sélection multiple)</label>
                    <select id="classesPilots" name="classesPilots[]" multiple
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-[#D9D9D9]">
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" 
                                {{ in_array($classe->id, old('classesPilots', $user->classesPilots->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $classe->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Création d'une nouvelle classe -->
            <div>
                <label class="block font-bold">Ou créez une nouvelle classe</label>
                <input type="text" name="new_classe" value="{{ old('new_classe') }}"
                    class="w-full border p-1.5 bg-[#D9D9D9] rounded-lg text-xs">
                @error('new_classe') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Boutons -->
            <div class="flex justify-between">
                <button type="button" class="bg-[#3D9DA9] hover:bg-[#3D8A8F] text-white px-4 py-2 rounded mt-4"
                    onclick="window.history.back()">
                    Annuler
                </button>
                <button type="submit" class="bg-[#3D9DA9] hover:bg-[#3D8A8F] text-white px-4 py-2 rounded mt-4">
                    Confirmer
                </button>
            </div>
        </form>
    </div>
</main>

@include('partials.footer')
