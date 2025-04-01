@extends('layouts.app')

@section('title', 'Informations de ' . $company->name)

@section('content')

    <div class="max-w-5xl mx-auto mt-10 grid grid-cols-3 gap-6">

        <!-- 📊 SECTION STATISTIQUES -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">📊 Statistiques</h2>

            <div class="mb-4">
                <label class="block font-bold">💰 Salaire moyen :</label>
                <p class="border p-2 w-full bg-gray-100">
                    {{ $averageSalary ? number_format($averageSalary, 0, ' ', ' ') . ' €' : 'Non disponible' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">📆 Durée moyenne des stages :</label>
                <p class="border p-2 w-full bg-gray-100">
                    {{ $averageDuration ? round($averageDuration) . ' jours' : 'Non disponible' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Nombre de stagiaire ayant postulé :</label>
                <p class="border p-2 w-full bg-gray-100">
                    {{ $applicationsCount ? round($applicationsCount) . ' candidatures' : 'Non disponible' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">🔥 Compétences les plus demandées :</label>
                @if (count($topSkills) > 0)
                    <ul class="border p-2 bg-gray-100">
                        @foreach ($topSkills as $skill)
                            <li>• {{ $skill }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="border p-2 w-full bg-gray-100">Aucune compétence répertoriée.</p>
                @endif
            </div>

        </div>

        <!-- 📄 SECTION INFORMATIONS ENTREPRISE -->
        <div class="col-span-2 bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold">Profil de {{ $company->name }}</h1>

            <div class="mt-4 flex justify-center">
                <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-32 h-32 rounded-full" alt="Logo">
            </div>

            <div class="mb-4">
                <label class="block font-bold">🏢 Numéro de Siret :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->siret ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">📧 Adresse mail :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->email ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">📞 Numéro de téléphone :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->tel_number ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">🏠 Adresse :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->address ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">🌍 Région :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->city->region->name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">🏙️ Ville :</label>
                <p class="border p-2 w-full bg-gray-100">{{ $company->city->name ?? 'Non défini' }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold">Secteurs de l'entreprise :</label>
                @if ($company->sectors->isNotEmpty())
                    <ul class="border p-2 bg-gray-100">
                        @foreach ($company->sectors as $sector)
                            <li>• {{ $sector->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="border p-2 w-full bg-gray-100">Aucune compétence répertoriée.</p>
                @endif
            </div>

            <div class="flex gap-4">
                <a href="{{ route('evaluations_create', $company->id) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Donner un avis
                </a>
                <a href="{{ route('evaluations_company_list', $company->id) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Afficher les avis
                </a>
            </div>

            @role('Admin|Pilote')
            <div class="flex gap-4 mt-4">
                <a href="{{ route('company_edit', $company->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Modifier
                </a>
                <form action="{{ route('company_delete', ['id' => $company->id]) }}" method="POST"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        Supprimer
                    </button>
                </form>
            </div>
            @endrole
        </div>
    </div>

    <!-- 📋 SECTION OFFRES -->
    <div class="max-w-5xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Dernières Offres</h2>

        @if ($company->offers->isEmpty())
            <p>Aucune offre récente.</p>
        @else
            <ul>
                @foreach ($company->offers->take(3) as $offer)
                    <li class="border-b py-2">
                        <strong>Offre :</strong> {{ $offer->title ?? 'Non défini' }} <br>
                        <span class="text-gray-500 text-sm">Déposée le {{ optional($offer->created_at)->format('d/m/Y') }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mt-4">
            <a href="{{ route('company_offers', $company->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Liste des offres
            </a>
        </div>
    </div>

@endsection