@extends('frontend.app')

@section('content')
    <div class="container section section--bg section--first">
        <h2>{{ $item->title }}</h2>
        <p>{{ $item->description }}</p>
        <p>Category: {{ $item->category->name }}</p>
        <p>Game: {{ $item->game->name }}</p>
        <p>Delivery Type: {{ ucfirst($item->delivery_type) }}</p>
        <p>Price: ${{ $item->price }}</p>

        <h3>Images</h3>
        @foreach(json_decode($item->images) as $image)
            <img src="{{ asset('storage/' . $image) }}" width="200">
        @endforeach
    </div>
@endsection