@extends('layouts.app')

@section('title', 'Informations de ' . $user->name)

@include('partials.header')

<main class="mt-10 mb-10 w-2/3 mx-auto">
    <div class="container mx-auto p-4 bg-[#387077] rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold">Profil de {{ $user->name }}</h1>

        <div class="mt-4">
            <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Avatar">
        </div>

        <form action="{{ route('user_update', ['role' => $role, 'id' => $user->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 place-items-center mt-1 w-full">
                <label class="block font-bold mb-1">Photo de profil :</label>
                <div class="relative w-full max-w-xs cursor-pointer">
                    <input type="file" name="pp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer pointer-events-none">
                    <div class="bg-[#D9D9D9] p-2 rounded-lg text-center">Choisir un fichier</div>
                </div>
            </div>
            <div>
                <label class="block font-bold">Nom :</label>
                <input type="text" name="name" value="{{ $user->name }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg"">
            </div>
            <div>
                <label class="block font-bold">Prénom :</label>
                <input type="text" name="first_name" value="{{ $user->first_name }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Date de naissance :</label>
                <input type="date" name="birthdate" value="{{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') : '' }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
            </div>

            <div>
                <label class="block font-bold">Email :</label>
                <input type="email" name="email" value="{{ $user->email }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Région :</label>
                <p class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">{{ optional(optional($user->city)->region)->name ?? 'Non défini' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Ville :</label>
                <select name="city_id" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                    <option value="">Sélectionnez une ville</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($role === 'Etudiant')
                <div>
                    <label for="classe_id" class="block font-bold">Classe (Promo)</label>
                    <select id="classe_id" name="classe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-[#D9D9D9]">
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id}}" {{ $user->classe_id == $classe->id ? 'selected' : '' }}>
                                {{ $classe->name }}
                        @endforeach
                    </select>
                </div>
            @elseif ($role === 'Pilote')
                <div>
                    <label for="classesPilots" class="block font-bold">Classes (Sélection
                        multiple)</label>
                    <select id="classesPilots" name="classesPilots[]" multiple
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-[#D9D9D9]">
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ in_array($classe->id, $user->classesPilots->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $classe->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif


            <div>
                <label for="new_classe" class="block text-xs font-bold">Ou créez une nouvelle classe</label>
                <input type="text" id="new_classe" name="new_classe" class="w-full border p-1.5 bg-[#D9D9D9] rounded-lg text-xs">
            </div>

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
</main>

@include('partials.footer')