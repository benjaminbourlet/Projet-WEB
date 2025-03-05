@extends('layouts.app')

@section('title', 'Informations de ' . $company->name)

@section('content')

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Profil de {{ $company->name }}</h1>

        <div class="mt-4">
            <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-32 h-32 rounded-full mx-auto" alt="Logo">
        </div>

        <form action="{{ route('company_update', ['id' => $company->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-bold">Nom de l'entreprise :</label>
                <input type="text" name="name" value="{{ $company->name }}" class="border p-2 w-full">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Numéro de téléphone :</label>
                <input type="text" name="siret" value="{{ $company->siret }}" class="border p-2 w-full">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Email :</label>
                <input type="email" name="email" value="{{ $company->email }}" class="border p-2 w-full">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Numéro de téléphone :</label>
                <input type="text" name="tel_number" value="{{ $company->tel_number }}" class="border p-2 w-full">
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
                <input type="text" name="address" value="{{ $company->address }}" class="border p-2 w-full">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Région :</label>
                <p class="border p-2 w-full bg-gray-100">
                    {{ optional(optional($company->city)->region)->name ?? 'Non défini' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Ville :</label>
                <select name="city_id" class="border p-2 w-full">
                    <option value="">Sélectionnez une ville</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $company->city_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                    <label for="sectors" class="block text-sm font-medium text-gray-700">Secteurs (Sélection
                        multiple)</label>
                    <select id="sectors" name="sectors[]" multiple
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}" {{ in_array($sector->id, $company->sectors->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            <div class="mb-4">
                <label class="block font-bold">Logo de l'entreprise :</label>
                <input type="file" name="logo" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">
                Modifier
            </button>
        </form>
    </div>

@endsection