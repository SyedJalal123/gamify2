@extends('frontend.app')

@section('content')
    <div class="container section section--first text-white text-center pb-5 mb-5">
        <h2>Select a Category</h2>
        <ul>
            @foreach($categories as $category)
                <li><a class="text-white" href="{{ route('games.index', $category->id) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection