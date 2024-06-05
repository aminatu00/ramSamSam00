@extends('layouts.template')
@section('content')


<div class="col-md-6">
    <div class="row">
        <form method="POST" action="{{ route('register.student') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <label for="niveau">Niveau</label>
                <select class="form-control" id="niveau" name="niveau" required>
                    <option value="licence 1">Licence 1</option>
                    <option value="licence 2">Licence 2</option>
                    <option value="licence 3">Licence 3</option>
                    <option value="master 1">Master 1</option>
                    <option value="master 2">Master 2</option>
                </select>
            </div>
            <div class="form-group">
    <label for="interests">Intérêts</label>
    <select class="form-control" id="interests" name="interests[]" multiple required>
        <option value="informatique">Informatique</option>
        <option value="reseaux">Réseaux</option>
        <option value="chimie">Chimie</option>
        <option value="physique">Physique</option>
        <option value="math">Math</option>
    </select>
</div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</div>
@endsection
