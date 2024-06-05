@extends('layouts.template')
@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>


    <div class="col-md-14">
        <div class="card">
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
            <div class="card-header">{{ __('La liste des utilisateurs ') }}</div>
            <div class="card-body">

                <!-- Display mentors for students -->
                @if(auth()->user()->user_type === 'student')
                @if (!$mentors->isEmpty())
                <div class="mb-4">
                    <h3>Your Mentors</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Niveau</th>
                                <th>Expertise</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mentors as $mentor)
                            <tr>
                            <td><a href="{{ route('mentors.show', $mentor->id) }}">{{ $mentor->name }}</a></td>
                                <td>{{ $mentor->email }}</td>
                                <td>{{ $mentor->niveau }}</td>
                               <td>
                                @php
                                $studentMentora = json_decode($mentor->expertise);
                                echo implode('<br>', $studentMentora);
                                @endphp
                               </td>
                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p>No mentors found.</p>
                @endif
                <!-- Display students for mentors -->
                @elseif(auth()->user()->user_type === 'mentor')
                @if (!$students->isEmpty())
                <div class="mb-4">
                    <h3>Your Students</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Niveau</th>
                                <th>Centre d'intérêt</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->niveau }}</td>
                                <td>
                                @php
                                $studentMentor = json_decode($student->interests);
                                echo implode('<br>', $studentMentor);
                                @endphp
                                </td>
                                <td>
                                    <!-- Icones pour modifier et supprimer -->
                                    <a href="{{ route('users.edit', $student->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('users.destroy', $student->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p>No students found.</p>
                @endif
                <!-- Display all users for admin -->
                @elseif(auth()->user()->user_type === 'admin')
                @if (!$students->isEmpty())
                <div class="mb-4">
                    <h3>Students</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Niveau</th>
                                <th>Centre d'intérêt</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->niveau }}</td>
                                <td>
                                @php
                                $studentInterest = json_decode($student->interests);
                                echo implode('<br>', $studentInterest);
                                @endphp
                                </td>

                                <td>
                                    <!-- Icones pour modifier et supprimer -->
                                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p>No students found.</p>
                @endif

                @if (!$mentors->isEmpty())
                <div class="mb-4">
                    <h3>Mentors</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Niveau</th>
                                <th>Expertise</th>
                                <th>Centre d'interet</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mentors as $mentor)
                            <tr>
                                <td>{{ $mentor->name }}</td>
                                <td>{{ $mentor->email }}</td>
                                <td>{{ $mentor->niveau }}</td>
                              
                                <td>
                                @php
                                $mentorExpertisesArray = json_decode($mentor->expertise);
                                echo implode('<br>', $mentorExpertisesArray);
                                @endphp
                                </td>
                                <td>
    @php
        $subExpertisesArray = json_decode($mentor->sub_expertises, true);
        echo implode('<br>', $subExpertisesArray);
    @endphp
</td>


                                <td>
                                    <!-- Icones pour modifier et supprimer -->
                                    <a href="{{ route('mentors.edit', $mentor->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('mentors.destroy', $mentor->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Est tu sure de vouloir supprimer cet utilisateur?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p>No mentors found.</p>
                @endif
                @endif
            </div>

        </div>
        @endsection