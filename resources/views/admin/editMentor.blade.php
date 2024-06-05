@extends('layouts.template')
@section('content')


<<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Mentor</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('mentors.update', $mentor->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $mentor->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $mentor->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="niveau">Niveau</label>
                    <input type="text" name="niveau" id="niveau" class="form-control" value="{{ old('niveau', $mentor->niveau) }}" required>
                </div>
                <div class="form-group">
                    <label for="expertise">Expertise</label>
                    <select name="expertise[]" id="expertise" class="form-control" multiple required>
                        <option value="informatique" @if(in_array('informatique', json_decode($mentor->expertise))) selected @endif>Informatique</option>
                        <option value="reseaux" @if(in_array('reseaux', json_decode($mentor->expertise))) selected @endif>Réseaux</option>
                        <option value="chimie" @if(in_array('chimie', json_decode($mentor->expertise))) selected @endif>Chimie</option>
                        <option value="physique" @if(in_array('physique', json_decode($mentor->expertise))) selected @endif>Physique</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="sub_expertises">Sous-expertise</label>
                    <select name="sub_expertises[]" id="sub_expertises" class="form-control" multiple required>
                        <option value="java" @if(in_array('java', json_decode($mentor->sub_expertises))) selected @endif>Java</option>
                        <option value="php" @if(in_array('php', json_decode($mentor->sub_expertises))) selected @endif>PHP</option>
                        <option value="reseaux sans fil" @if(in_array('reseaux sans fil', json_decode($mentor->sub_expertises))) selected @endif>Réseaux sans fil</option>
                        <option value="reseaux avec fil" @if(in_array('reseaux avec fil', json_decode($mentor->sub_expertises))) selected @endif>Réseaux avec fil</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Mentor</button>
            </form>
        </div>
    </div>
</div>
@endsection
