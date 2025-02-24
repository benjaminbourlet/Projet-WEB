@extends('layouts.app')

@section('title', $role . 's')

@include('partials.header')

@section('content')
<div class="container mx-auto p-4">
    
    <h1 class="text-2xl font-bold">{{ $role }}s</h1>

    <div class="mt-4 flex space-x-2">
    <a href="{{ route('user_register', [$role === 'Etudiant' ? 'students' : 'pilots']) }}">
    <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">+</button>
    </a>
        <button class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">📁</button>
    </div>
    
    <div class="mt-4 space-y-4">
        @foreach ($users as $user)
            <div class="bg-white p-4 shadow-md rounded-lg flex items-center justify-between border border-gray-200">
                <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/' . $user->pp_path) }}" 
                    class="w-12 h-12 rounded-full" alt="Avatar">
                    <div>
                        <p><strong>Id :</strong> {{ $user->id }}</p>
                        <p><strong>Nom :</strong> {{ $user->name }}</p>
                        <p><strong>Prénom :</strong> {{ $user->first_name }}</p>
                        <p><strong>Email :</strong> {{ $user->email }}</p>
                        <p><strong>Promo :</strong> {{ $user->promo ?? 'Non défini' }}</p>
                        <p><strong>Statut :</strong> {{ $role }}</p>
                    </div>
                </div>
                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">✖</button>
            </div>
        @endforeach
    </div>
</div>
@endsection
