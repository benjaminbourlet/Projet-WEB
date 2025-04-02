@extends('layouts.app')

@section('title', $role . 's')

@include('partials.header')

@section('content')
    <main>
        <div class="flex-grow container mx-auto p-4 flex gap-6">
            <div class="container mx-auto p-4">

                @if (session('success'))
                    <div id="success-message"
                        class="bg-green-500 text-white p-3 rounded-md mb-4 max-w-sm mx-auto inline-block">
                        {{ session('success') }}
                    </div>
                @endif

                <h1 class="text-2xl font-bold">{{ $role }}s</h1>

                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('user_register', [$role === 'Etudiant' ? 'students' : 'pilots']) }}">
                        <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">+</button>
                    </a>

                    <!-- Formulaire de recherche et filtres -->
                    <form method="GET" class="flex flex-wrap gap-4 items-center bg-gray-100 p-4 rounded-md mb-6">
                        <!-- Barre de recherche -->
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Rechercher un utilisateur..." class="w-full border p-2 rounded-md">
                        </div>

                        @if ($role === 'Etudiant')
                            <!-- Filtre par classe -->
                            <div>
                                <select name="class_id" class="border p-2 rounded-md">
                                    <option value="">Toutes les classes</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div>
                            <button type="submit" class="bg-blue-700 hover:bg-blue-500 text-white px-4 py-2 rounded-md">
                                Rechercher
                            </button>
                        </div>
                    </form>

                </div>

                <div class="mt-4 space-y-4">
                    @foreach ($users as $user)
                        <div
                            class="bg-white shadow-md rounded-tr-2xl rounded-bl-2xl flex items-center justify-between border border-gray-200">
                            <a href="{{ route('user_info', ['role' => $role === 'Etudiant' ? 'students' : 'pilots', 'id' => $user->id]) }}"
                                class="flex items-center justify-between space-x-4 h-full w-full p-4">
                                <img src="{{ asset('storage/' . $user->pp_path) }}" class="w-12 h-12 rounded-full"
                                    alt="Avatar">
                                <div class="flex gap-4 items-center h-full w-full">
                                    <p><strong>Id :</strong> {{ $user->id }}</p>
                                    <div>
                                        <p><strong>Nom :</strong> {{ $user->name }}</p>
                                        <p><strong>Prénom :</strong> {{ $user->first_name }}</p>
                                    </div>
                                    <p><strong>Email :</strong> {{ $user->email }}</p>

                                    @if ($role === 'Etudiant')
                                        <p><strong>Promo :</strong>
                                            {{ $user->classe ? $user->classe->name : 'Aucune classe' }}</p>
                                    @else
                                        <p><strong>Classes :</strong>
                                            {{ $user->classesPilots->isNotEmpty() ? $user->classesPilots->pluck('name')->implode(', ') : 'Aucune classe' }}
                                        </p>
                                    @endif

                                    <!-- Date de naissance -->
                                    <p><strong>Date de naissance :</strong>
                                        {{ \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') ?? 'Non défini' }}</p>


                                    <form action="{{ route('user_delete', ['id' => $user->id]) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');"
                                        class="ml-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 pt-1.5 pb-1.5 bg-red-500 rounded-lg">X</button>
                                    </form>

                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
@endsection
