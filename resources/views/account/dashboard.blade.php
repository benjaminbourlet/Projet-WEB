@extends('layouts.app')

@section('title', 'Dashboard')


@section('content')
<main>
<div class="container">
    <h1 class="mb-4">Tableau de Bord</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-black bg-success mb-3">
                <div class="card-header">Nombre de candidatures</div>
                <div class="card-body">
                    <h4 class="card-title">{{ $totalApplications }}</h4>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-4">Compétences les plus demandées</h2>
    <ul class="list-group">
        @foreach($topSkills as $skill)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $skill->name }}
                <span class="badge bg-primary rounded-pill">{{ $skill->count }}</span>
            </li>
        @endforeach
    </ul>

    <div class="row mt-4">
        <div class="col-md-6">
            <canvas id="applicationsChart"
                data-accepted="{{ $acceptedApplications }}"
                data-rejected="{{ $rejectedApplications }}"
                data-pending="{{ $pendingApplications }}"
                data-traitement="{{ $traitementApplications }}"
                data-interview="{{ $interviewApplications }}"
                width="50" height="50">
            </canvas>
        </div>
    </div>
</div>
</main>
@endsection