@extends('layouts.app')

@section('title', 'Créer une offre')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Créer une offre</h2>

        @if (session('error'))
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('offerRegister') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700">Titre de l'offre :</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                    class="w-full mt-1 p-2 border rounded-md @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="salary" class="block text-gray-700">Salaire</label>
                <input type="text" id="salary" name="salary" value="{{ old('salary') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('salary') border-red-500 @enderror">
                @error('salary')
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

            <div class="mb-4">
                <label for="start_date" class="block text-gray-700">Date de début</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                    class="w-full mt-1 p-2 border rounded-md">
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-gray-700">Date de fin</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                    class="w-full mt-1 p-2 border rounded-md">
                @error('end_dates')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="company_id" class="block text-sm font-medium text-gray-700">Entreprise</label>
                <select id="company_id" name="company_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    required>
                    <option value="">Sélectionnez une entreprise</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
                @error('company_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sélection des départements -->
            <div class="mb-4">
                <label for="departments" class="block text-sm font-medium text-gray-700">Départements</label>
                <select id="departments"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="">Sélectionnez un département</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <div id="selected-departments" class="mt-2 flex flex-wrap gap-2"></div>
            </div>

            <!-- Sélection des compétences -->
            <div class="mb-4">
                <label for="skills" class="block text-sm font-medium text-gray-700">Compétences</label>
                <select id="skills"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="">Sélectionnez une compétence</option>
                    @foreach ($skills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                    @endforeach
                </select>
                <div id="selected-skills" class="mt-2 flex flex-wrap gap-2"></div>
            </div>




            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 mt-4">
                Créer l'offre
            </button>

        </form>
   </div>
@endsection
