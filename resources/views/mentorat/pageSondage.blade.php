@extends('layouts.template')
@section('content')
<div class="col-md-8">
    <div class="card">
        @if (session('success'))
        <div class="alert alert-success auto-dismiss">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger auto-dismiss">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card-header">{{ __('Recent Surveys') }}</div>
        <div class="card-body">
            @foreach($surveys->sortByDesc('created_at') as $survey)
            <div id="sondage_{{ $survey->id }}" class="survey"> <!-- Ajout d'un div unique pour chaque sondage -->
            @if(auth()->user()->user_type === 'student')
            @if(auth()->user()->niveau >= $survey->niveau && in_array($survey->subject, json_decode(auth()->user()->interests)))
            <div class="survey">
                <h4>{{ $survey->subject }}</h4>
                <p>{{ $survey->question }}</p>
                <p><strong>Domaine :</strong> {{ $survey->subject }}</p>
                <p><strong>Date d'expiration :</strong> {{ $survey->expiry_date }}</p>
                <p><strong>Créateur :</strong>
                    @if($survey->creator->id === auth()->user()->id)
                    Moi
                    @else
                    {{ $survey->creator->name }}
                    @endif
                </p>
                <p><strong>Options :</strong></p>
                <ul>

                    @php
                    $options = json_decode($survey->options, true);
                    @endphp
                    @php
                    $totalVotes = is_array($totalVotesForSondage) ? array_sum($totalVotesForSondage) : $totalVotesForSondage;
                    @endphp
                    @foreach($options as $option)
                    <li class="d-flex align-items-center justify-content-between">
                        <div>{{ is_array($option) ? $option['name'] : $option }}</div>
                        <div class="progress" style="width: 50%">
                            @php
                            $percentage = 0;
                            $optionName = is_array($option) ? $option['name'] : $option;
                            if ($totalVotes > 0 && isset($voteCounts[$optionName])) {
                            $percentage = ($voteCounts[$optionName] / $totalVotes) * 100;
                            }
                            @endphp
                            <div class="progress-bar bg-primary" role="progressbar" style="width:10%" aria-valuenow="{{ isset($voteCounts[$optionName]) ? $voteCounts[$optionName] : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                {{ isset($voteCounts[$optionName]) ? $voteCounts[$optionName] : 0 }}
                            </div>
                        </div>

                        @if(auth()->user()->user_type !== 'mentor' || auth()->user()->user_type === 'mentor')
                        <div>
                            <form id="vote-form-{{ $loop->index }}" action="{{ route('vote.submit', [$survey->id, $option]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link vote-button" name="survey_id" value="{{ $survey->id }}"><i class="fas fa-vote-yea"></i></button>
                            </form>
                        </div>
                        @endif
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('view.survey', $survey->id) }}" class="btn btn-link"><i class="fas fa-eye"></i></a>
                <a href="{{ route('surveys.meetings', $survey->id) }}" class="btn btn-link"><i class="fas fa-calendar-alt"></i></a>
                <hr>
            </div>
            @endif
            @else
            <div class="survey">
                <h4>{{ $survey->subject }}</h4>
                <p>{{ $survey->question }}</p>
                <p><strong>Domaine :</strong> {{ $survey->subject }}</p>
                <p><strong>Date d'expiration :</strong> {{ $survey->expiry_date }}</p>
                <p><strong>Créateur :</strong>
                    @if($survey->creator->id === auth()->user()->id)
                    Moi
                    @else
                    {{ $survey->creator->name }}
                    @endif
                </p>
                <p><strong>Options :</strong></p>
                <ul>

                    @php
                    $options = json_decode($survey->options, true);
                    @endphp
                    @php
                    $totalVotes = is_array($totalVotesForSondage) ? array_sum($totalVotesForSondage) : $totalVotesForSondage;
                    @endphp
                    @foreach($options as $option)
                    <li class="d-flex align-items-center justify-content-between">
                        <div>{{ is_array($option) ? $option['name'] : $option }}</div>
                        <div class="progress" style="width: 50%">
                            @php
                            $percentage = 0;
                            $optionName = is_array($option) ? $option['name'] : $option;
                            if ($totalVotes > 0 && isset($voteCounts[$optionName])) {
                            $percentage = ($voteCounts[$optionName] / $totalVotes) * 100;
                            }
                            @endphp
                            <div class="progress-bar bg-primary" role="progressbar" style="width:10%" aria-valuenow="{{ isset($voteCounts[$optionName]) ? $voteCounts[$optionName] : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                {{ isset($voteCounts[$optionName]) ? $voteCounts[$optionName] : 0 }}
                            </div>
                        </div>

                        @if(auth()->user()->user_type !== 'mentor')
                        <div>
                            <form id="vote-form-{{ $loop->index }}" action="{{ route('vote.submit', [$survey->id, $option]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link vote-button" name="survey_id" value="{{ $survey->id }}"><i class="fas fa-vote-yea"></i></button>
                            </form>
                        </div>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @if(auth()->user()->user_type === 'mentor' && auth()->user()->id === $survey->mentor_id)
                <a href="{{ route('view.survey', $survey->id) }}" class="btn btn-link"><i class="fas fa-eye"></i></a>
                <a href="{{ route('sondages.destroy', $survey->id) }}" class="btn btn-link"><i class="fas fa-trash-alt" style="color: red;"></i></a>
                <a href="{{ route('sondages.edit', $survey->id) }}" class="btn btn-link"><i class="fas fa-edit"></i></a>
                <form action="{{ route('meetings.create') }}" method="GET">
                    @csrf
                    <input type="hidden" name="survey" id="survey" value="{{ json_encode($survey) }}">
                    <input type="hidden" name="survey_id" value="{{ $survey->id }}">
                    <button type="submit" class="btn btn-link"><i class="fas fa-calendar-plus" style="color: green;"></i></button>
                </form>
                @endif
                <hr style="border-top: 2px solid #8B0000; margin: 40px 0;">
            </div>
            @endif
            @endforeach
        </div>
        </div>
    </div>
</div>
@endsection


@section('styles')
<style>
    .survey {
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #ccc;
    }

    .survey h4 {
        color: #333;
    }

    .survey p {
        margin-bottom: 10px;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const voteForms = document.querySelectorAll('.vote-form');

        voteForms.forEach(form => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                const formData = new FormData(form);
                const action = form.action;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const progressBar = document.getElementById('progress-bar-' + data.option.replace(/\s+/g, '-'));
                            progressBar.style.width = data.percentage + '%';
                            progressBar.setAttribute('aria-valuenow', data.percentage);
                            // Mettre à jour le nombre de votes affiché
                            progressBar.innerHTML = data.percentage + '%';
                        } else {
                            console.error('Error:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            });
        });

        // Ajouter un écouteur d'événements pour la barre de progression
      document.addEventListener('DOMContentLoaded', () => {
    const voteForms = document.querySelectorAll('.vote-form');

    voteForms.forEach(form => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(form);
            const action = form.action;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const sondageId = formData.get('sondageId'); // Utilisation de l'identifiant unique du sondage
                        const progressBar = document.getElementById('progress-bar-' + sondageId + '-' + data.option.replace(/\s+/g, '-'));
                        progressBar.style.width = data.percentage + '%';
                        progressBar.setAttribute('aria-valuenow', data.percentage);
                        progressBar.innerHTML = data.percentage + '%';
                    } else {
                        console.error('Error:', data);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });
    });
});


    });
</script>
@endsection