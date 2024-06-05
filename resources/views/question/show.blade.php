@extends('layouts.template')
@section('content')



        <div class="col-md-8">
          <div class="text-white"><h1>Liste des questions</h1></div>  
            <form action="{{ route('questions.search') }}" method="GET" class="mb-3">
                <div class="input-group" style="background-color:#081b29">
                    <input type="text" name="query" class="form-control search-input text-white" placeholder="Rechercher une question">
                    <button type="submit" class="btn btn-primary search-button text-white" style="background-color:#081b29;background-image:linear-gradient(180deg, #081b29, #0ef);">Rechercher</button>
                </div>
            </form>
            @if ($questions->isEmpty())
              <div class="text-white"><p>Aucune question n'a été trouvée.</p></div>  
            @else
                <div class="row">
                    <div class="col-md-12">
                        @foreach ($questions->reverse() as $question)
                            <div class="card mb-3">
                                <div class="card-body">
                                @if ($question->media_path)
            <img src="{{ Storage::url(str_replace('public/', '', $question->media_path)) }}" class="img-fluid mb-2 text-white" alt="Image de la question">
            @endif
                                    <div class="text-white text-sm mb-2">{{ $question->created_at->format('d/m/Y H:i') }}</div>
                                    <a href="{{ route('answers.show', $question) }}">
    <h2 class="card-title h5 text-white">{{ $question->title }}</h2>
</a>

                                    <p class="card-text text-white">{{ $question->content }}</p>
                                    <form action="{{ route('answers.store', $question) }}" method="post" data-url="{{ route('answers.store', $question) }}">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="content" class="form-control text-white" rows="3" placeholder="Votre réponse"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Répondre</button>
                                        <a href="{{ route('answers.show', $question) }}" class="btn btn-secondary">Voir Réponse</a>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .sidebar-container {
        padding-right: 0;
    }

    .search-input {
        margin-right: 0;
    }

    .search-button {
        margin-left: -1px; /* Supprimer l'espace entre le champ de recherche et le bouton */
    }
</style>

@endsection
