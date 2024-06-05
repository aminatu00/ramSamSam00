<!-- resources/views/formSignal.blade.php -->

@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Signaler un contenu</h1>
    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <div class="form-group">
            <label for="content_type">Type de contenu :</label>
            <input type="text" id="content_type" name="content_type" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="message">Message :</label>
            <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer le signalement</button>
    </form>
</div>
@endsection
