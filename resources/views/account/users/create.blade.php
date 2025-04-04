@extends('layouts.app')
{{-- Le fichier étend le layout principal de l'application --}}

@section('title', 'Inscription ' . $role)
{{-- Le titre de la page est dynamique en fonction du rôle de l'utilisateur --}}

@section('content')

    {{-- Affichage du titre de la page d'inscription avec le rôle dynamique --}}
    <h2 class="text-2xl font-bold text-center my-6">Inscription {{ $role }}</h2>
    <div class="bg-gray-700 rounded-lg m-4">

        {{-- Si des erreurs de validation existent, elles sont affichées ici --}}
        @if ($errors->any())
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Affichage d'une erreur de session, le cas échéant --}}
        @if (session('error'))
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        {{-- Formulaire permettant la création d'un compte utilisateur --}}
        <form method="POST" action="{{ route('userRegister') }}" enctype="multipart/form-data">
            @csrf
            {{-- Le rôle de l'utilisateur est transmis via un champ caché --}}
            <input type="hidden" name="role" value="{{ $role }}">

            <div class="grid md:grid-cols-2 grid-cols-1">
                <div class="bg-[#5A8E95] p-4 rounded-lg">
                    {{-- Section contenant les informations personnelles et les détails liés aux classes et à la ville --}}
                    <div class="m-4">
                        <label for="pp" class="block text-sm font-medium text-white">Photo De Profil</label>
                        <input type="file" id="pp" name="pp"
                            class="mt-1 text-white block w-full border-gray-300 rounded-md shadow-sm">
                        @error('pp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="m-4">
                        <label for="name" class="block text-white">Nom</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full mt-1 p-2 border rounded-md">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="m-4">
                        <label for="first_name" class="block text-white">Prénom</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                            class="w-full mt-1 p-2 border rounded-md">
                        @error('first_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="m-4">
                        <label for="birthdate" class="block text-white">Date de naissance</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required
                            class="w-full mt-1 p-2 border rounded-md">
                        @error('birthdate') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Promotion -->
                    @if ($role === 'Etudiant')
                        {{-- Si le rôle est Etudiant, afficher un select pour choisir la classe (promotion) --}}
                        <div class="m-4">
                            <label for="classe_id" class="block text-sm font-medium text-white">Classe (Promo)</label>
                            <select id="classe_id" name="classe_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Sélectionnez une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    @elseif ($role === 'Pilote')
                        {{-- Si le rôle est Pilote, afficher un select permettant la sélection multiple des classes --}}
                        <div class="m-4">
                            <label for="classesPilots" class="block text-sm font-medium text-white">Classes (Sélection
                                multiple)</label>
                            <select id="classesPilots" name="classesPilots[]" multiple
                                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Sélectionnez une/des classe(s)</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Champ pour permettre la création d'une nouvelle classe si besoin --}}
                    <div class="m-4">
                        <label for="new_classe" class="block text-sm font-medium text-white">Ou créez une nouvelle
                            classe</label>
                        <input type="text" id="new_classe" name="new_classe" class="w-full mt-1 p-2 border rounded-md">
                    </div>

                    {{-- Sélection de la ville --}}
                    <div class="m-4">
                        <label for="city_id" class="block text-sm font-medium text-white">Ville</label>
                        <select id="city_id" name="city_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Sélectionnez une ville</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-gray-700 place-items-center p-4 rounded-lg">
                    {{-- Section contenant les informations de connexion --}}
                    <div class="m-8 w-3/4">
                        {{-- Champ pour l'adresse email --}}
                        <label for="email" class="block text-white">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full mt-1 p-2 border rounded-md">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="m-8 w-3/4">
                        {{-- Champ pour le mot de passe --}}
                        <label for="password" class="block text-white">Mot de passe</label>
                        <input type="password" id="password" name="password" required
                            class="w-full mt-1 p-2 border rounded-md">
                        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="m-8 w-3/4">
                        {{-- Champ pour confirmer le mot de passe --}}
                        <label for="password_confirmation" class="block text-white">Confirmez le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full mt-1 p-2 border rounded-md">
                    </div>

                    {{-- Bouton de soumission pour créer le profil avec le rôle spécifique --}}
                    <button type="submit"
                        class="w-3/4 bg-green-500 text-white px-8 py-2 rounded-full hover:bg-green-600 m-8">
                        Créer le profil {{ $role }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection