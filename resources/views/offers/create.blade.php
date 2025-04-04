@extends('layouts.app')

@section('title', 'Créer une offre')


@section('content')
    <main>
        <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Créer une offre</h2>

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

            <form method="POST" action="{{ route('offerRegister') }}" enctype="multipart/form-data">
                @csrf

                <!-- Titre de l'offre -->
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Titre de l'offre :</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full mt-1 p-2 border rounded-md @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sélection du salaire -->
                <div class="mb-4">
                    <label for="salary" class="block text-gray-700">Salaire</label>
                    <input type="text" id="salary" name="salary" value="{{ old('salary') }}"
                        class="w-full mt-1 p-2 border rounded-md @error('salary') border-red-500 @enderror">
                    @error('salary')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description de l'offre -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full mt-1 p-2 border rounded-md @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sélection de la date de début -->
                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700">Date de début</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                        class="w-full mt-1 p-2 border rounded-md">
                    @error('start_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <!-- Sélection de la date de fin -->
                    <label for="end_date" class="block text-gray-700">Date de fin</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                        class="w-full mt-1 p-2 border rounded-md">
                    @error('end_dates')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Sélection de l'entreprise -->
                    <div>
                        <label for="company_id" class="block text-sm font-medium text-gray-700">Entreprise</label>
                        <select id="company_id" name="company_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                            required>
                            <option value="">Sélectionnez une entreprise</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sélection des départements -->
                    <div class="mb-4">
                        <label for="departments" class="block text-sm font-medium text-gray-700">Departements</label>
                        <select id="departments" name="departments[]"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <div id="selected-departments" class="mt-2 flex flex-wrap gap-2"></div>
                        @error('departments')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sélection des compétences -->
                    <div class="mb-4">
                        <label for="skills" class="block text-sm font-medium text-gray-700">Compétences</label>
                        <select id="skills" name="skills[]"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endforeach
                        </select>
                        <div id="selected-skills" class="mt-2 flex flex-wrap gap-2"></div>
                        @error('skills')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton pour confirmer la création de l'offre -->
                    <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 mt-4">
                        Créer l'offre
                    </button>

            </form>
        </div>
    </main>
@endsection