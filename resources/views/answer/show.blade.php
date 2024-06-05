@extends('layouts.template')
@section('content')
<div class="col-md-8">
    <div class="card mb-4"style="background-color:#081b29;">
        <div class="card-body">
            <h2 class="card-title font-weight-bold text-white">{{ $question->title }}</h2>
            <p class="card-text text-white">{{ $question->content }}</p>
            @if ($question->media_path)
                    <img src="{{ Storage::url(str_replace('public/', '', $question->media_path)) }}" class="img-fluid mb-2 preview-image" alt="Image de la question" style="max-height: 200px; cursor: pointer;">
                    @endif
        </div>
    </div>

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

    <div class="card"style="background-color:#081b29">
        <div class="card-header">
            <h3 class="card-title font-weight-bold text-white">Réponses</h3>
        </div>
        <div class="card-body">
            @if($question->answers->isNotEmpty())
                @foreach($question->answers as $answer)
                    <div class="card mb-3"style="background-color:#081b29;border:1px solid #0ef;border-radius:10px">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar rounded-circle mr-3" style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;background-image:linear-gradient(180deg, #081b29, #0ef);">
                                    <span class="text-white font-weight-bold" style="line-height: 1;">{{ strtoupper(substr($answer->user->name, 0, 1)) }}</span>
                                </div>
                            </div>

                            <div id="answerContent_{{ $answer->id }}">
                                <!-- Afficher le contenu de la réponse -->
                                <p class="card-text text-white">{{ $answer->content }}</p>
                                <div class="d-flex justify-content-start align-items-center">
                                    <form action="{{ route('answers.like', $answer) }}" method="POST" class="mr-3">
                                        @csrf
                                        <button type="submit" class="btn ">
                                            <i class="fas fa-thumbs-up  text-white"></i> <span class="ml-1"style="color:white">{{ $answer->likes }}</span>
                                        </button>
                                    </form>
                                    <!-- Bouton "Modifier" -->
                                    @if(auth()->user() && $answer->user_id === auth()->user()->id)
                                        <button class="btn btn-link p-0 mr-3" onclick="editAnswer('{{ $answer->id }}')">
                                            <i class="fas fa-edit "style="color:#0ef"></i>
                                        </button>
                                        <form action="{{ route('answers.destroy', $answer) }}" method="POST" class="d-inline p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Formulaire de modification (initialement caché) -->
                            <form id="editForm_{{ $answer->id }}" action="{{ route('answers.update', $answer) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <textarea class="form-control text-white"style="background-color:#081b29;border:1px solid #0ef" name="content" rows="3">{{ $answer->content }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary " style="background-image:linear-gradient(180deg, #081b29, #0ef);border-radius:10px"><i class="fas fa-save"></i> Enregistrer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
              <div class="text-white"> <p>Aucune réponse disponible pour cette question.</p></div> 
            @endif
        </div>
    </div>
</div>
<div class="col-md-4">
    <!-- Ajoutez ici votre contenu pour la colonne latérale -->
</div>

<script>
    function editAnswer(answerId) {
        // Masquer le contenu de la réponse
        document.getElementById('answerContent_' + answerId).style.display = 'none';
        // Afficher le formulaire de modification correspondant
        document.getElementById('editForm_' + answerId).style.display = 'block';
    }

    // Attendre 3 secondes avant de masquer les messages automatiquement
    setTimeout(function() {
        document.querySelectorAll('.auto-dismiss').forEach(function(element) {
            element.style.display = 'none';
        });
    }, 3000);
</script>
@endsection

@section('styles')
<!-- Lien vers les icônes Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<style>
    .btn-link {
        background: none;
        border: none;
        padding: 0;
    }

    .btn-link:hover {
        text-decoration: none;
    }

    .ml-1 {
        margin-left: 0.25rem;
    }
</style>
@endsection
