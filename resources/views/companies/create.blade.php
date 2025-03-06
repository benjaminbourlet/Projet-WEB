@extends('layouts.app')

@section('title', 'Créer une entreprise')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Créer une entreprise</h2>

        @if (session('error'))
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('companyRegister') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700">Logo de l'entreprise</label>
                <input type="file" id="logo" name="logo"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                @error('logo') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nom de l'entreprise</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full mt-1 p-2 border rounded-md @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="siret" class="block text-gray-700">Numéro de Siret</label>
                <input type="text" id="siret" name="siret" value="{{ old('siret') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('siret') border-red-500 @enderror">
                @error('siret')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full mt-1 p-2 border rounded-md @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tel_number" class="block text-gray-700">Numéro de téléphone</label>
                <input type="text" id="tel_number" name="tel_number" value="{{ old('tel_number') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('tel_number') border-red-500 @enderror">
                @error('tel_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-gray-700">Adresse</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('address') border-red-500 @enderror">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full mt-1 p-2 border rounded-md @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="city_id" class="block text-sm font-medium text-gray-700">Ville</label>
                <select id="city_id" name="city_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    required>
                    <option value="">Sélectionnez une ville</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="sectors" class="block text-sm font-medium text-gray-700">Secteurs</label>
                <select id="sectors" name="sectors[]" multiple
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                    @endforeach
                </select>
                @error('sectors')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 mt-4">
                Créer l'entreprise
            </button>

        </form>
    </div>
@endsection