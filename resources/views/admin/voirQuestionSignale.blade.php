@extends('layouts.template')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Détails de la Question Signalée</h1>
        <p class="mb-4">Examinez les détails de la question signalée.</p>

        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>ID: {{ $question->id }}</h5>
                <h5>Titre: {{ $question->title }}</h5>
                <p>Contenu: {{ $question->content }}</p>
                @if($question->media_path)
                    <img src="{{ Storage::url(str_replace('public/', '', $question->media_path)) }}" alt="Image de la question" style="max-height: 200px;">
                @else
                    <p>Aucune image disponible</p>
                @endif
                <p>Nombre de signalements: {{ $question->reports_count }}</p>

                <form action="{{ route('reported.questions.delete', $question->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question?');">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- Incluez les scripts JavaScript pour DataTables si nécessaire -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection

