@extends('layouts.app')

@section('title', 'Inscription ' . $role)

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Inscription {{ $role }}</h2>

        @if (session('error'))
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('userRegister') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <div>
                <label for="pp" class="block text-sm font-medium text-gray-700">Photo De Profil</label>
                <input type="file" id="pp" name="pp" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('pp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nom</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full mt-1 p-2 border rounded-md">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="first_name" class="block text-gray-700">Prénom</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required class="w-full mt-1 p-2 border rounded-md">
                @error('first_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="birthdate" class="block text-gray-700">Date de naissance</label>
                <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required class="w-full mt-1 p-2 border rounded-md">
                @error('birthdate') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full mt-1 p-2 border rounded-md">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" required class="w-full mt-1 p-2 border rounded-md">
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirmez le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full mt-1 p-2 border rounded-md">
            </div>

            @if ($role === 'Etudiant')
                <div>
                    <label for="classe_id" class="block text-sm font-medium text-gray-700">Classe (Promo)</label>
                    <select id="classe_id" name="classe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif ($role === 'Pilote')
                <div>
                    <label for="classesPilots" class="block text-sm font-medium text-gray-700">Classes (Sélection multiple)</label>
                    <select id="classesPilots" name="classesPilots[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Sélectionnez une/des classe(s)</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                        @endforeach
                    </select>
                    <div id="selected-classesPilots" class="mt-2 flex flex-wrap gap-2"></div>
                </div>
            @endif

            <div>
                <label for="new_classe" class="block text-sm font-medium text-gray-700">Ou créez une nouvelle classe</label>
                <input type="text" id="new_classe" name="new_classe" class="w-full mt-1 p-2 border rounded-md">
            </div>

            <div>
                <label for="city_id" class="block text-sm font-medium text-gray-700">Ville</label>
                <select id="city_id" name="city_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Sélectionnez une ville</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 mt-4">
                Créer le profil {{ $role }}
            </button>
        </form>
    </div>
@endsection
