@extends('layouts.template')
@section('content')


        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profil Utilisateur</div>

                <div class="card-body">
                     <!-- Afficher les messages d'erreur -->
                     @if ($errors->any())
                        <div class="alert alert-danger auto-dismiss">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Afficher les messages de succès -->
                    @if (session('success'))
                        <div class="alert alert-success auto-dismiss">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Cercle avec le commencement du nom de l'utilisateur -->
                   <!-- Cercle avec le commencement du nom de l'utilisateur ou photo de profil -->
@if (Auth::user()->profile_image)
    <!-- Afficher la photo de profil -->
    <img class="img-profile rounded-circle" src="{{ asset('storage/' . Auth::user()->profile_image) }}">
    @else
    <!-- Afficher le cercle avec le commencement du nom de l'utilisateur -->
    <div class="circle">
        {{ substr(Auth::user()->name, 0, 1) }}
    </div>
@endif

<div>
    <h3>{{ Auth::user()->name }}</h3>
    <p>{{ Auth::user()->email }}</p>
</div>


                    

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Nom :</label>
        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
    </div>

    <div class="form-group">
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="profile_image">Photo de profil :</label>
        <input type="file" name="profile_image" class="form-control-file">
    </div>

    @if(Auth::user()->user_type == 'student')
   <div class="form-group">
    <label for="niveau">Niveau :</label>
    <select name="niveau" class="form-control">
        <option value="licence1" {{ Auth::user()->niveau == 'licence1' ? 'selected' : '' }}>Licence 1</option>
        <option value="licence2" {{ Auth::user()->niveau == 'licence2' ? 'selected' : '' }}>Licence 2</option>
        <option value="licence3" {{ Auth::user()->niveau == 'licence3' ? 'selected' : '' }}>Licence 3</option>
        <option value="master1" {{ Auth::user()->niveau == 'master1' ? 'selected' : '' }}>Master 1</option>
        <option value="master2" {{ Auth::user()->niveau == 'master2' ? 'selected' : '' }}>Master 2</option>
    </select>
</div>


<div class="form-group">
    <label for="interests">Centres d'intérêt :</label><br>
    @foreach (['informatique', 'reseaux', 'chimie', 'math'] as $interest)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="interests[]" value="{{ $interest }}" {{ in_array($interest, json_decode(Auth::user()->interests)) ? 'checked' : '' }}>
            <label class="form-check-label">{{ $interest }}</label>
        </div>
    @endforeach
</div>

@endif


    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
</form>

                </div>
            </div>
        
</div>
@endsection
<style>
    .circle {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background-color: #007bff; /* Couleur de fond du cercle */
    color: #fff; /* Couleur du texte à l'intérieur du cercle */
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 48px; /* Taille du texte */
}

</style>