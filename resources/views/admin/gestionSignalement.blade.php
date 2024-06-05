@extends('layouts.template')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Gérer les Questions Signalées</h1>
    <p class="mb-4">Liste des questions signalées pour examen.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Image</th>
                            <th>Signalements</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportedQuestions as $question)
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td>{{ $question->title }}</td>
                            <td>{{ $question->content }}</td>
                            <td>
                                @if($question->media_path)
                                <img src="{{ Storage::url(str_replace('public/', '', $question->media_path)) }}" alt="Image de la question" style="max-height: 100px;">
                                @else
                                N/A
                                @endif
                            </td>
                            <td>{{ $question->reports_count }}</td>
                            <td>
                                <form action="{{ route('reported.questions.delete', $question->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question?');">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">Aucune question signalée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection
