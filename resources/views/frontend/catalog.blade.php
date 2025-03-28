@extends('frontend.app')

@section('css')
    <style>
        body {
            color: #fff;
        }
    </style>
@endsection
@section('content')
    <section class="section section--bg section--first" data-bg="GoGame – Digital marketplace HTML Template Preview - ThemeForest_files/img/bg.jpg" style="background: url(&quot;GoGame – Digital marketplace HTML Template Preview - ThemeForest_files/img/bg.jpg&quot;) center top 140px / auto 500px no-repeat;">
        <div class="container mb-5">
            <div class="row">
                <!-- title -->
                <div class="col-12">
                    
                    <div class="row">
                        <h2 class="mb-3 col-md-12">
                            {{$game->name}}
                        </h2>
                        @foreach ($items as $item)
                        <div class="col-md-4">
                            <div class="drop-box bg-white text-dark m-2">
                                <p>
                                    @foreach ($item->attributes as $key => $attribute)
                                        @if ($attribute->game_id != null)
                                            <strong>@if($key !== 0).@endif {{$attribute->pivot->value}}</strong>
                                        @endif
                                    @endforeach
                                </p>
                                <p>{{$item->title}}</p>
                                <div class="mb-2 d-flex flex-column align-items-end">
                                    <img src="{{asset($item->feature_image)}}" alt="" width="50px">
                                </div>
                                <p class="m-0">
                                    <strong>${{$item->price}}</strong>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection