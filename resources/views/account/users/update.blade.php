@extends('layouts.app')

@section('title', 'Informations de ' . $user->name)

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Profil de {{ $user->name }}</h1>

        <div class="mt-4">
            <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Avatar">
        </div>

        <form action="{{ route('user_update', ['role' => $role, 'id' => $user->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div>
                <label class="block font-bold">Nom :</label>
                <input type="text" name="name" value="{{ $user->name }}" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-bold">Prénom :</label>
                <input type="text" name="first_name" value="{{ $user->first_name }}" class="border p-2 w-full">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Date de naissance :</label>
                <input type="date" name="birthdate" value="{{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') : '' }}" class="border p-2 w-full">
            </div>

            <div>
                <label class="block font-bold">Email :</label>
                <input type="email" name="email" value="{{ $user->email }}" class="border p-2 w-full">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Région :</label>
                <p class="border p-2 w-full bg-gray-100">{{ optional(optional($user->city)->region)->name ?? 'Non défini' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Ville :</label>
                <select name="city_id" class="border p-2 w-full">
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
                    <label for="classe_id" class="block text-sm font-medium text-gray-700">Classe (Promo)</label>
                    <select id="classe_id" name="classe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id}}" {{ $user->classe_id == $classe->id ? 'selected' : '' }}>
                                {{ $classe->name }}
                        @endforeach
                    </select>
                </div>
            @elseif ($role === 'Pilote')
                <div>
                    <label for="classesPilots" class="block text-sm font-medium text-gray-700">Classes (Sélection
                        multiple)</label>
                    <select id="classesPilots" name="classesPilots[]" multiple
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ in_array($classe->id, $user->classesPilots->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $classe->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif


            <div>
                <label for="new_classe" class="block text-sm font-medium text-gray-700">Ou créez une nouvelle classe</label>
                <input type="text" id="new_classe" name="new_classe" class="w-full mt-1 p-2 border rounded-md">
            </div>

            <div>
                <label class="block font-bold">Photo de profil :</label>
                <input type="file" name="pp" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">
                Modifier
            </button>
        </form>
    </div>
@endsection
