@extends('layouts.app')

@section('title', 'Avis')

@include('partials.header')

@section('content')

    <main class="flex-grow container mx-auto p-4 flex gap-6">
        <div class="container">
            <h1 class="mb-4">All Evaluations</h1>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>User</th>
                        <th>Grade</th>
                        <th>Comment</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluations as $evaluation)
                        <tr>
                            <td>{{ $evaluation->company_name }}</td>
                            <td>{{ $evaluation->user_name }}</td>
                            <td>{{ $evaluation->grade }}/5</td>
                            <td>{{ $evaluation->comment ?? 'No comment' }}</td>
                            <td>{{ \Carbon\Carbon::parse($evaluation->created_at)->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $evaluations->links() }} <!-- Pagination links -->
        </div>
    </main>
    @include('partials.footer')

@endsection