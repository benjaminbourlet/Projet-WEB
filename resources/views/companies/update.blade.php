@extends('layouts.app')

@section('title', 'Informations de ' . $company->name)

@section('content')

        <div class="container p-4 mx-6">
            <h1 class="text-2xl font-bold">Profil de {{ $company->name }}</h1>

            <!-- Affichage des erreurs globaux -->
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
                <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Logo">
            </div>

            <form action="{{ route('company_update', ['id' => $company->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-bold">Nom de l'entreprise :</label>
                    <input type="text" name="name" value="{{ old('name', $company->name) }}"
                        class="border p-2 w-full @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Numéro de téléphone :</label>
                    <input type="text" name="siret" value="{{ old('siret', $company->siret) }}"
                        class="border p-2 w-full @error('siret') border-red-500 @enderror">
                    @error('siret')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Email :</label>
                    <input type="email" name="email" value="{{ old('email', $company->email) }}"
                        class="border p-2 w-full @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Numéro de téléphone :</label>
                    <input type="text" name="tel_number" value="{{ old('tel_number', $company->tel_number) }}"
                        class="border p-2 w-full @error('tel_number') border-red-500 @enderror">
                    @error('tel_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block font-bold">Description :</label>
                    <textarea id="description" name="description" rows="4"
                        class="border p-2 w-full rounded-md @error('description') border-red-500 @enderror">{{ old('description', $company->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Adresse :</label>
                    <input type="text" name="address" value="{{ old('address', $company->address) }}"
                        class="border p-2 w-full @error('address') border-red-500 @enderror">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Région :</label>
                    <p class="border p-2 w-full bg-gray-100">
                        {{ optional(optional($company->city)->region)->name ?? 'Non défini' }}
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Ville :</label>
                    <select name="city_id" class="border p-2 w-full @error('city_id') border-red-500 @enderror">
                        <option value="">Sélectionnez une ville</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $company->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="sectors" class="block text-sm font-medium text-gray-700">Secteurs (Sélection
                        multiple)</label>
                    <select id="sectors" name="sectors[]" multiple @foreach($sectors as $sector) <option
                        value="{{ $sector->id }}" {{ in_array($sector->id, old('sectors', $company->sectors->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $sector->name }}
                        </option>
                    @endforeach
                    </select>
                    @error('sectors')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Logo de l'entreprise :</label>
                    <input type="file" name="logo" class="border p-2 w-full">
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">
                    Modifier
                </button>
            </form>
        </div>
@endsection