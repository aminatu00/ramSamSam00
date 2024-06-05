@extends('layouts.template')
@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Student</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('students.update', $student->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="niveau">Niveau</label>
                    <input type="text" name="niveau" id="niveau" class="form-control" value="{{ old('niveau', $student->niveau) }}" required>
                </div>
                <div class="form-group">
                    <label for="interests">Centre d'intérêt</label>
                    <select name="interests[]" id="interests" class="form-control" multiple required>
                        <option value="informatique" @if(in_array('informatique', json_decode($student->interests))) selected @endif>Informatique</option>
                        <option value="reseaux" @if(in_array('reseaux', json_decode($student->interests))) selected @endif>Réseaux</option>
                        <option value="chimie" @if(in_array('chimie', json_decode($student->interests))) selected @endif>Chimie</option>
                        <option value="physique" @if(in_array('physique', json_decode($student->interests))) selected @endif>Physique</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Student</button>
            </form>
        </div>
    </div>
</div>
@endsection
