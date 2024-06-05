@extends('layouts.template')
@section('content')

        <div class="col-md-8 offset-md0">
            <div class="card">
                <div class="card-header">{{ __('Modifier le sondage') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sondages.update', $sondage->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="subject">{{ __('Sujet') }}</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ $sondage->subject }}" required>
                        </div>

                        <div class="form-group">
                            <label for="question">{{ __('Question') }}</label>
                            <textarea class="form-control" id="question" name="question" rows="3" required>{{ $sondage->question }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="options">{{ __('Options (séparées par des virgules)') }}</label>
                            <input type="text" class="form-control" id="options" name="options" value="{{ $sondage->options }}" required>
                        </div>

                        <div class="form-group">
                            <label for="expiry_date">{{ __('Date d\'expiration') }}</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ $sondage->expiry_date }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Enregistrer les modifications') }}</button>
                    </form>
                </div>
            </div>
        </div>
    
@endsection
