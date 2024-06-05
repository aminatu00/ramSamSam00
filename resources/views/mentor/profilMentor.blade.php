@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ asset('path/to/default/avatar.jpg') }}" alt="avatar"
                        class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="my-3">{{ $mentor->name }}</h5>
                    <p class="text-muted mb-1">{{ $mentor->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Expertises</h5>
                    @php
                        $expertises = $mentor->expertise ?? [];
                        $subExpertises = $mentor->sub_expertises ?? [];
                    @endphp
                    <ul class="list-group">
                        @foreach($expertises as $expertise)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $expertise }}
                                <span class="badge badge-primary badge-pill">{{ $subExpertises[$expertise] ?? 'N/A' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Graphique des expertises</h5>
                    <canvas id="expertiseChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Assurez-vous que les données PHP sont bien encodées en JSON
        // var expertises = {!! json_encode(array_keys($mentor->sub_expertises ?? [])) !!};
        // var values = {!! json_encode(array_values($mentor->sub_expertises ?? [])) !!};

        new Chart(document.getElementById('expertiseChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: expertises,
                datasets: [{
                    label: 'Expertise',
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
