<!-- resources/views/admin/questions/index.blade.php -->

@extends('layouts.template')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Toutes les questions</div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sujet</th>
                                <th scope="col">Contenu</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>
                                 <a href="{{ route('questionAdmin.show', $question->id) }}">{{ $question->title }}
                                </a>
                                    </td>
                                    <td>{{ $question->content }}</td>
                                    <td>
                                    @if ($question->media_path)
                    <img src="{{ Storage::url(str_replace('public/', '', $question->media_path)) }}" class="img-fluid mb-2 preview-image" alt="Image de la question" style="max-height: 200px; cursor: pointer;">
                    @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('questionAdmin.destroy', $question->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
