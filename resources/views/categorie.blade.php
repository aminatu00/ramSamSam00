@extends('layouts.template')
@section('content')

<div class="col-md-12">
    <div class="row">
        @foreach($categories as $category)
        <div class="col-md-6 mb-4">
            <a href="{{ route('categorie.show', ['id' => $category->id, 'category_id' => $category->id]) }}" class="category-link">
                <div class="card shadow h-100 py-2 border-left-primary">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ $category->nom }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $category->description }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .category-link {
        text-decoration: none;
    }

    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease-in-out;
    }
</style>
@endsection
