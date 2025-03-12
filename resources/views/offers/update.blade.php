@extends('layouts.app')

@section('title', 'Informations sur ' . $offer->title)

@include('partials.header')

<main class="mt-10 mb-10 w-2/3 mx-auto">
    <div class="container mx-auto p-4 bg-[#387077] rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center">Modification de l'offre : {{ $offer->title }}</h1>

        <form action="{{ route('offer_update', ['id' => $offer->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-bold">Titre de l'offre :</label>
                <input type="text" name="title" value="{{ old('title', $offer->title) }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
            </div>

            <div class="mb-4">
                <label for="description" class="block font-bold">Description :</label>
                <textarea id="description" name="description" rows="4"
                    class="border p-1.5 w-full bg-[#D9D9D9] rounded-md @error('description') border-red-500 @enderror">{{ old('description', $offer->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-bold">Salaire :</label>
                <input type="text" name="salary" value="{{ old('salary', $offer->salary) }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Date de début :</label>
                <input type="date" name="start_date" value="{{ old('start_date', $offer->start_date) }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Date de fin :</label>
                <input type="date" name="end_date" value="{{ old('end_date', $offer->end_date) }}" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
            </div>

            <div class="mb-4">
                <label class="block font-bold">Entreprise :</label>
                <select name="company_id" class="border p-1.5 w-full bg-[#D9D9D9] rounded-lg text-lg">
                    <option value="">Sélectionnez une entreprise</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $company->id == $offer->company_id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="skills" class="block text-sm font-bold">Compétences (Sélection multiple)</label>
                <select id="skills" name="skills[]" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}" 
                            {{ in_array($skill->id, $offer->skills->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $skill->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="departments" class="block text-sm font-bold">Départements (Sélection multiple)</label>
                <select id="departments" name="departments[]" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" 
                            {{ in_array($department->id, $offer->departments->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-between">
                <button type="button" class="bg-[#3D9DA9] hover:bg-[#3D8A8F] text-white px-4 py-2 rounded mt-4" onclick="window.history.back()">
                    Annuler
                </button>
                <button type="submit" class="bg-[#3D9DA9] hover:bg-[#3D8A8F] text-white px-4 py-2 rounded mt-4">
                    Confirmer
                </button>
            </div>
        </form>
    </div>

</main>

@include('partials.footer')