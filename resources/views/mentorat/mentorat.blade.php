@extends('layouts.template')
@section('content')

<div class="col-md-8 offset-md-0">
    <div class="card">
        <div class="card-header ">{{ __('Meetings') }}</div>

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

            @if($meetings->isEmpty())
                <p>No meetings found.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Meeting Link/Info</th>
                            <th>Subject</th>
                            <th>Mentor</th>
                            <th>Domaine</th>
                            <th>Session Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($meetings as $meeting)
                        <tr>
                            <td>{{ $meeting->date }}</td>
                            <td>{{ $meeting->time }}</td>
                            <td>
                                {!! preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $meeting->meeting_link) !!}
                            </td>
                            <td>{{ $meeting->subject }}</td>
                            <td>{{ $meeting->mentor->name }}</td>
                            <td>{{ $meeting->domaine }}</td>
                            <td>{{ ucfirst($meeting->session_type) }}</td>
                            <td>
                                <a href="{{ route('meetings.edit', $meeting->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> <!-- Icone pour modifier -->
                                </a>
                                <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> <!-- Icone pour supprimer -->
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
