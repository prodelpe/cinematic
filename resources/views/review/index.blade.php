@inject('review_model', 'App\Review')
@inject('user_model', 'App\User')

@extends('layouts.layout')

@section('title', 'Críticas de ' . $movie->title)
@section('body-id', 'reviews')

@section('content')

<!-- Create Post Form -->

<div class="create-header container-fluid movie-excerpt mb-5 p-0 text-white" style="background-image: url('https://image.tmdb.org/t/p/w500/xE3Y5ntcbqDz9FzwLWSVVR5qF7H.jpg')">
    <div class="create-inner-header">
        <div class="container pt-5 pb-5">

            @if ($errors->any())
            <div class="row">
                <div class="alert alert-danger w-100" style="margin-top: -25px;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="row">

                <!-- poster -->
                <div class="col-sm-2">
                    <a href="{{ route('movie', $movie->id) }}">
                        <img src="https://image.tmdb.org/t/p/w500{{$movie->poster_path}}" class="rounded" alt="{{$movie->title}}" width="180">
                    </a>
                </div>

                <!-- movie data -->
                <div class="col-sm-8">
                    <h1>{{$movie->title}}</h1>

                    <h5>{{$movie->original_title}}</h5>

                    <p class="year-duration">
                        {{Str::limit($movie->release_date, 4, '')}} - 
                        {{$movie->runtime}} min - 
                        @foreach($movie->production_countries as $country)
                        <img src="https://www.filmaffinity.com/imgs/countries2/{{$country->iso_3166_1}}.png" width="20"/>
                        @endforeach
                    </p>

                    <p class="genres">
                        @foreach($movie->genres as $genre)
                        {{$genre->name}}
                        @if (next($movie->genres))
                        ,
                        @endif
                        @endforeach
                    </p>

                    <p>
                        @foreach($crew as $c)
                        {{$c->name}} ({{$c->job}})
                        @if (next($crew))
                        , 
                        @endif
                        @endforeach
                    </p>

                    <p>
                        @foreach($cast as $c)
                        {{$c->name}}
                        @if (next($cast))
                        , 
                        @endif
                        @endforeach
                    </p>
                </div>

                <!-- Your vote -->
                <div class="col-sm-2 d-sm-inline-flex">
                    <h2>
                        <span class="badge badge-success p-3">
                            {{ \App\Review::getMovieAverageNote($movie->id) }}
                        </span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @foreach($reviews as $review)
    <div class="review card p-3">
        <div class="row review-user-info">
            <div class="col-10 review-header">
                <h6>
                    {{__('custom.Autor')}}: 
                    <a href="{{ route('user', $review->user_id) }}">
                        {{\App\User::getUsernameById($review->user_id)}}
                    </a>
                </h6>
                <small>
                    {{\App\Review::getNumberOfReviewsByUserId($review->user_id)}} {{__('custom.críticas publicadas')}}
                </small>
                <hr>
            </div>
            <div class="col-2 text-right">
                <span class="badge badge-primary px-3 py-2">
                    <h4>{{ $review->note }}</h4>
                </span>
            </div>
        </div>
        <div class="row review-title">
            <div class="col-12 card-title">
                <h2>{{ $review->title }}</h2>
            </div>
        </div>
        <div class="row review-body">
            <div class="col-12 card-body text-left">
                <p>{{ $review->review }}</p>
            </div>
        </div>
        @if (!empty($review->spoiler))
        <div class="row review-spoiler text-left">
            <div class="col-12">
                <button class="badge badge-warning p-2" type="button" data-toggle="collapse" data-target="#collapseSpoiler" aria-expanded="false" aria-controls="collapseSpoiler">
                    {{ __('custom.Ver resto de la crítica con spoilers') }}    
                </button>
            </div>
            <div class="collapse" id="collapseSpoiler">
                <div class="col-12 card-body">
                    <p>{{ $review->spoiler }}</p>  
                </div>
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>

<div class="row">
    <div class="cinematic-pagination">
        {{ $reviews->links() }}
    </div>
</div>

@endsection