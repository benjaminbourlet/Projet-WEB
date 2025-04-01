@extends('layouts.app')

@section('title', 'Créer une entreprise')

@include('partials.header')

@section('content')
<main>
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Créer une entreprise</h2>

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

        @if (session('error'))
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('companyRegister') }}" enctype="multipart/form-data">
            @csrf

            <!-- Logo de l'entreprise -->
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700">Logo de l'entreprise</label>
                <input type="file" id="logo" name="logo"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
                @error('logo') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nom de l'entreprise -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nom de l'entreprise</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full mt-1 p-2 border rounded-md">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Numéro de Siret -->
            <div class="mb-4">
                <label for="siret" class="block text-gray-700">Numéro de Siret</label>
                <input type="text" id="siret" name="siret" value="{{ old('siret') }}"
                    class="w-full mt-1 p-2 border rounded-md">
                @error('siret')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full mt-1 p-2 border rounded-md">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Numéro de téléphone -->
            <div class="mb-4">
                <label for="tel_number" class="block text-gray-700">Numéro de téléphone</label>
                <input type="text" id="tel_number" name="tel_number" value="{{ old('tel_number') }}"
                    class="w-full mt-1 p-2 border rounded-md">
                @error('tel_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Adresse -->
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Adresse</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}"
                    class="w-full mt-1 p-2 border rounded-md">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full mt-1 p-2 border rounded-md">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ville -->
            <div class="mb-4">
                <label for="city_id" class="block text-sm font-medium text-gray-700">Ville</label>
                <select id="city_id" name="city_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" required>
                    <option value="">Sélectionnez une ville</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('city_id') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Secteurs -->
            <div class="mb-4">
                <label for="sectors" class="block text-sm font-medium text-gray-700">Secteurs</label>
                <select id="sectors" name="sectors[]" multiple
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}" 
                            {{ in_array($sector->id, old('sectors', [])) ? 'selected' : '' }}>
                            {{ $sector->name }}
                        </option>
                    @endforeach
                </select>
                <div id="selected-sectors" class="mt-2 flex flex-wrap gap-2"></div>
                @error('sectors')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 mt-4">
                Créer l'entreprise
            </button>
        </form>
    </div>
</main>
@include('partials.footer')
@endsection
