@extends('layouts.template')
@section('content')
<div class="col-md-8 offset-md-2">
    <div class="card text-white">
        <div class="card-header  "style="background-color:#081b29">
        </div>
        <div class="card-body"style="background-color:#081b29">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('questions.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="categorie" class="form-label text-white">Catégorie</label>
                    <select name="categorie" id="categorie" class="form-select text-white"style="background-color:#081b29">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 text-white" >
                    <label for="title" class="form-label">Sujet</label>
                    <input type="text" name="title" id="title" class="form-control text-white" style="background-color:#081b29"placeholder="Entrez le titre de votre question">
                </div>

                <div class="mb-3 text-white"style="background-color:#081b29">
                    <label for="content" class="form-label">Contenu</label>
                    <textarea name="content" id="content" rows="5" class="form-control text-white" style="background-color:#081b29"placeholder="Entrez le contenu de votre question"></textarea>
                </div>

                <div class="mb-3">
                    <label for="media" class="form-label text-white" style="background-color:#081b29">Ajouter une image </label>
                    <input type="file" name="media" id="media" class="form-control text-white" style="background-color:#081b29" accept="image/*,video/*">
                </div>

        </div>
        <div id="previewContainer" class="mb-3" style="display: none;">
            <h5>Media sélectionné :</h5>
            <div id="mediaPreview"></div>
        </div>

        <button type="submit" class="btn text-white" style="background-color:#081b29; background-image:linear-gradient(180deg, #081b29, #0ef); border-radius:10px">Soumettre</button>
        </form>
    </div>
</div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('media').addEventListener('change', function() {
        const previewContainer = document.getElementById('previewContainer');
        const mediaPreview = document.getElementById('mediaPreview');

        // Supprimer toute miniature précédente
        mediaPreview.innerHTML = '';

        // Vérifier si un fichier a été sélectionné
        if (this.files && this.files[0]) {
            const reader = new FileReader();

            // Charger l'image ou la vidéo sélectionnée dans le lecteur FileReader
            reader.onload = function(e) {
                if (e.target && e.target.result) {
                    if (e.target.result.match(/^data:image\/(?:jpeg|png|gif);base64,/)) {
                        // Si c'est une image
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Preview';
                        img.classList.add('img-thumbnail');
                        mediaPreview.appendChild(img);
                    } else if (e.target.result.match(/^data:video\/(?:mp4|quicktime);base64,/)) {
                        // Si c'est une vidéo
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.controls = true;
                        video.classList.add('img-thumbnail');
                        mediaPreview.appendChild(video);
                    }
                }
            }

            // Afficher la miniature de l'image ou de la vidéo sélectionnée
            reader.readAsDataURL(this.files[0]);

            // Afficher le nom du fichier sélectionné
            const fileName = document.createElement('p');
            fileName.textContent = 'Nom du fichier : ' + this.files[0].name;
            mediaPreview.appendChild(fileName);

            // Afficher le conteneur de prévisualisation
            previewContainer.style.display = 'block';
        } else {
            // Cacher le conteneur de prévisualisation s'il n'y a pas de fichier sélectionné
            previewContainer.style.display = 'none';
        }
    });
</script>
@endsection