@extends('layouts.template')
@section('content')

<div class="col-md-12"> <!-- Utilisez toute la largeur disponible -->

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
    <div class="text-white">
        <h1>Liste des questions</h1>
    </div>

    <form action="{{ route('questions.search') }}" method="GET" class="mb-3">
        <input type="hidden" name="category_id" value="{{ isset($category) ? $category->id : null }}">
        <div class="input-group">
            <input type="text" name="query" class="form-control custom-placeholder" placeholder="Rechercher une question">
            <button type="submit" class="btn btn-primary" style="background-image:linear-gradient(180deg, #081b29, #0ef);box-shadow: 0 0 1px #0ef;">Rechercher</button>
        </div>
    </form>

    @if (isset($questions) && $questions->isEmpty())
    <div class="text-white">
        <p>Aucune question n'a été trouvée.</p>
    </div>
    @else
    <div class="row" style="background-image:linear-gradient(180deg, #081b29, #081b29);">
        <div class="col-md-12">
            @foreach ($questions as $question)
            <div class="card mb-3 question-card" style="background-image:linear-gradient(180deg, #081b29, #081b29);">
                <div class="card-body" style="border: 1px solid #0ef; border-radius:10px">
                    <div class="d-flex justify-content-between">
                        <div>
                        <div class="text-white text-sm mb-2">
                                @if (auth()->user()->id === $question->user->id)
                                    Publié par Moi il y a {{ $question->created_at->diffForHumans() }}
                                @else
                                    Publié par {{ $question->user->name }} il y a {{ $question->created_at->diffForHumans() }}
                                @endif
                            </div>
                           <div class="d-flex align-items-center">
                        @if (auth()->user()->id === $question->user->id)
                            @if (auth()->user()->profile_image)
                            <img class="img-profile rounded-circle profile-image" src="{{ asset('storage/' . $question->user->profile_image) }}"style="width: 50px; height: 50px;">
                            @else
                                <div class="circle rounded-circle mr-3" style="width: 55px; height: 55px; display: flex; justify-content: center; align-items: center;background-image:linear-gradient(180deg, #0ef, #081b29)">
                                    <span class="text-white font-weight-bold" style="line-height: 1;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <!-- <p class="card-text text-white">Moi</p> -->
                        @else
                            @if ($question->user->profile_image)
                            <img class="img-profile rounded-circle profile-image" src="{{ asset('storage/' . $question->user->profile_image) }}"style="width: 50px; height: 50px;">
                            @else
                                <div class="circle rounded-circle mr-3" style="width: 55px; height: 55px; display: flex; justify-content: center; align-items: center;background-image:linear-gradient(180deg, #0ef, #081b29)">
                                    <span class="text-white font-weight-bold" style="line-height: 1;">{{ strtoupper(substr($question->user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <!-- <p class="card-text text-white">{{ $question->user->name }}</p> -->
                        @endif
                    </div>
                        </div>
                        <div class="d-flex align-items-center">
                            @if(auth()->user()->id !== $question->user_id)
                            <form action="{{ route('questions.report', $question->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $question->id }}">
                                <!-- Bouton de signalement -->
                                <button type="submit" class="btn btn-sm btn-report">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                </button>
                            </form>
                            @endif

                            <!-- Bouton de réponse -->
                            <button class="btn btn-sm btn-reply toggle-response" data-target="#response-form-{{ $question->id }}">
                                <i class="fas fa-reply " style="color:#fff"></i>
                            </button>
                            <!-- Bouton de discussion -->
                            <a href="{{ route('answers.show', $question) }}" class="btn btn-sm">
                                <i class="fas fa-comments " style="color:#0ef"></i>
                            </a>
                            <!-- Bouton de like -->
                            <form action="{{ route('questions.like', $question) }}" method="post" class="mr-2">
                                @csrf
                                <button type="submit" class="btn like-button btn-sm">
                                    <i class="fas fa-thumbs-up " style="color:#fff"></i>
                                    <span class="badge like-badge">{{ $question->likes }}</span>
                                </button>
                            </form>
                            <!-- Bouton de suppression -->
                            @if(auth()->user()->id === $question->user_id)
                            <form action="{{ route('questions.destroy', $question) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="background-color: transparent; border: none;">
                                    <i class="fas fa-trash-alt" style="color: red;"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="row"> <!-- Utiliser une rangée pour aligner le titre, le contenu et l'image -->
                    <div class="col-md-8 offset-md-1 mt-n5"> <!-- Partie texte -->

                    <a href="{{ route('answers.show', $question) }}">
                        <div class="text-white text-decoration-underline">
                            <h2 class="card-title h5">{{ $question->title }}</h2>
                        </div>
                    </a>
                    <p class="card-text  text-white">{{ $question->content }}</p>

                    @if ($question->media_path)
                    <img src="{{ Storage::url(str_replace('public/', '', $question->media_path)) }}" class="img-fluid mb-2 preview-image" alt="Image de la question" style="max-height: 80px; cursor: pointer;">
                    @endif

                </div>
                    </div>

                    <form action="{{ route('answers.store', $question) }}" method="post" class="response-form" id="response-form-{{ $question->id }}" style="display: none;">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" class="form-control text-white " style="background-color:#081b29" rows="3" placeholder="Votre réponse"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="background-image:linear-gradient(180deg, #081b29, #0ef);box-shadow: 0 0 1px #0ef;border-radius:10px; width:20%">Envoyer</button>
                    </form>

                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Ajouter le code JavaScript pour masquer automatiquement les messages d'erreur -->
<script>
    // Attendre 3 secondes avant de masquer les messages d'erreur automatiquement
    setTimeout(function() {
        document.querySelectorAll('.auto-dismiss').forEach(function(element) {
            element.style.display = 'none';
        });
    }, 3000);

    // JavaScript pour afficher le champ de réponse lorsqu'on clique sur l'icône "réponse"
    document.querySelectorAll('.toggle-response').forEach(function(button) {
        button.addEventListener('click', function() {
            var target = document.querySelector(button.getAttribute('data-target'));
            if (target.style.display === 'none') {
                target.style.display = 'block';
            } else {
                target.style.display = 'none';
            }
        });
    });

    // JavaScript pour agrandir l'image lorsqu'on clique dessus
    document.querySelectorAll('.preview-image').forEach(function(image) {
        image.addEventListener('click', function() {
            var img = new Image();
            img.src = image.src;
            var w = window.open("");
            w.document.write(img.outerHTML);
        });
    });


    
  // JavaScript pour éclaircir légèrement la couleur du div contenant chaque question lorsque le curseur survole
document.querySelectorAll('.question-card').forEach(function(card) {
    card.addEventListener('mouseenter', function() {
        card.style.backgroundColor = '#0a2545'; // Couleur de fond légèrement plus foncée
        card.style.transition = 'background-color 0.3s ease'; // Animation de transition
    });

    card.addEventListener('mouseleave', function() {
        card.style.backgroundColor = '#081b29'; // Retour à la couleur de fond d'origine
        card.style.transition = 'background-color 0.3s ease'; // Animation de transition
    });
});

</script>

@endsection

@section('styles')
<!-- Lien vers les icônes Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<style>
 .card .img-profile.rounded-circle {
    width: 10px; /* Modifier cette valeur selon vos besoins */
    height: 10px; /* Modifier cette valeur selon vos besoins */
}


    .like-button {
        background-color: white;
        color: white;
        border: 1px solid #ccc;
    }

    .like-button .fas {
        color: white;
    }

    .like-badge {
        background-color: white;
        color: black;
    }

    .btn-reply i {
        color: blue;
    }

    .btn-report i {
        color: yellow;
    }

    .btn-reply,
    .btn-report {
        background-color: transparent;
        border: none;
    }

    .custom-placeholder::placeholder {
        color: white;
        /* Couleur du texte du placeholder */
    }
</style>
@endsection