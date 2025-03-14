@extends('frontend.app')

@section('content')
    <div class="container section section--first text-white text-center pb-5 mb-5">
        <h2>Select a Game for {{ $category->name }}</h2>
        <ul>
            @foreach($games as $game)
                <li>
                    <a href="{{ route('items.create', ['category' => $category->id, 'game' => $game->id]) }}">
                        {{ $game->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection