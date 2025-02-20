@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6">Inscription</h2>
    
    @if (session('error'))
    <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
        {{ session('error') }}
    </div>
@endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full mt-1 p-2 border rounded-md @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="first_name" class="block text-gray-700">Prénom</label>
            <input type="first_name" id="first_name" name="first_name" value="{{ old('first_name') }}" required class="w-full mt-1 p-2 border rounded-md @error('first_name') border-red-500 @enderror">
            @error('first_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full mt-1 p-2 border rounded-md @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Mot de passe</label>
            <input type="password" id="password" name="password" required class="w-full mt-1 p-2 border rounded-md @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirmez le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full mt-1 p-2 border rounded-md">
        </div>

        <div>
            <label for="region_id" class="block text-sm font-medium text-gray-700">Région</label>
            <select id="region_id" name="region_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" required>
                <option value="">Sélectionnez une région</option>
                @foreach(App\Models\Region::all() as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
            @error('region_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="city_id" class="block text-sm font-medium text-gray-700">Ville</label>
            <select id="city_id" name="city_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" required>
                <option value="">Sélectionnez une ville</option>
                @foreach(App\Models\City::all() as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
            <select id="role_id" name="role_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" required>
                <option value="">Sélectionnez un role</option>
                @foreach(App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600">S'inscrire</button>

        <p class="text-center text-sm mt-4">
            Déjà inscrit ? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Se connecter</a>
        </p>
    </form>
</div>
@endsection
