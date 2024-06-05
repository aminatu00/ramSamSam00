<!-- resources/views/surveys/create.blade.php -->

@extends('layouts.template')
@section('content')

   
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Create Survey') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('sondage.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="subject">{{ __('Expertise') }}</label>
                        <select id="subject" class="form-control @error('subject') is-invalid @enderror" name="subject" required>
                            <option value="">Select an expertise</option>
                            @if(is_array($expertises))
                            @foreach($expertises as $expertise)
                            <option value="{{ $expertise }}">{{ $expertise }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('subject')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="question">{{ __('Question') }}</label>
                        <textarea id="question" class="form-control @error('question') is-invalid @enderror" name="question" required autocomplete="question">{{ old('question') }}</textarea>
                        @error('question')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
    <label>{{ __('Options') }}</label><br>
    @foreach($subExpertises ?? [] as $subExpertise)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="options[]" value="{{ $subExpertise }}">
        <label class="form-check-label">{{ $subExpertise }}</label>
    </div>
@endforeach


    @error('options')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


                    <div class="form-group">
                        <label for="expiry_date">{{ __('Expiry Date') }}</label>
                        <input id="expiry_date" type="datetime-local" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date') }}" required autocomplete="expiry_date">
                        @error('expiry_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Creer sondage') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection