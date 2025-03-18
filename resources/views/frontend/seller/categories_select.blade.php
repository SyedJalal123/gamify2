@extends('frontend.app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <style>
        body {
            color: white !important;
        }
    </style>
@endsection

@section('content')
<section class="section section--bg section--first" data-bg="GoGame – Digital marketplace HTML Template Preview - ThemeForest_files/img/bg.jpg" style="background: url(&quot;GoGame – Digital marketplace HTML Template Preview - ThemeForest_files/img/bg.jpg&quot;) center top 140px / auto 500px no-repeat;">
    <div class="container">
        <h2>Select a Category</h2>
        <ul>
            @foreach ($categories as $category)
                <li class="category-item" data-category-id="{{ $category->id }}">{{ $category->name }}</li>
            @endforeach
        </ul>

        <div id="games-container" style="display: none;">
            <h3>Select a Game</h3>
            <select id="games-dropdown">
                <option value="">Select a Game</option>
            </select>
        </div>

        <div id="attributes-container" style="display: none;">
            <h3>Additional Attributes</h3>
            <ul id="attributes-list"></ul>
        </div>
    </div>
</section>


@endsection

@section('js')
    <script>
        $('.category-item').click(function() {
            let categoryId = $(this).data('category-id');

            $.get('/get-games', { category_id: categoryId }, function(data) {
                $('#games-dropdown').html('<option value="">Select a Game</option>');
                data.games.forEach(game => {
                    $('#games-dropdown').append(`<option value="${game.id}">${game.name}</option>`);
                });
                $('#games-container').show();
            });

            $.get('/get-attributes', { category_id: categoryId }, function(data) {
                $('#attributes-list').empty();
                data.attributes.forEach(attr => {
                    $('#attributes-list').append(`<li>${attr.name}: ${JSON.stringify(attr.options)}</li>`);
                });
                $('#attributes-container').show();
            });
        });

        $('#games-dropdown').change(function() {
            let gameId = $(this).val();
            $.get('/get-attributes', { game_id: gameId }, function(data) {
                $('#attributes-list').empty();
                data.attributes.forEach(attr => {
                    $('#attributes-list').append(`<li>${attr.name}: ${JSON.stringify(attr.options)}</li>`);
                });
                $('#attributes-container').show();
            });
        });
    </script>

@endsection