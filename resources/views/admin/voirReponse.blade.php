<!-- resources/views/admin/questions/show.blade.php -->

@extends('layouts.template')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ $question->title }}</div>
            <div class="card-body">
                @if($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" alt="Image de la question" class="img-thumbnail mb-3" style="width: 100%; height: auto;">
                @endif
                <p>{{ $question->content }}</p>
                <hr>
                <h5>Réponses :</h5>
                <ul class="list-group">
                    @foreach($question->answers as $answer)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p>{{ $answer->content }}</p>
                                <small>Répondu par : {{ $answer->user->name }}</small>
                            </div>
                            <form action="{{ route('answerAdmin.destroy', $answer->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
