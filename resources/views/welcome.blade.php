@inject('user_model', 'App\User')
@inject('movie_controller', 'App\Http\Controllers\MovieController')

@extends('layouts.layout')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1 class="header_title display-3 text-white">{{ __('custom.welcome') }}</h1>
        <p class="header-info text-white">{{ __('custom.tagline') }}</p>
        <!--<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>-->
    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        
        <!-- Last Reviews -->
        <div class="col-md-4 last-reviews">
            <h2 class="mb-3">{{ __('custom.Últimas críticas') }}</h2>
            @foreach($last_reviews as $review)
            <div class="card">
                <div class="card-header">
                    {{ $movie_controller->getMovie($review->movie_id)->title }}
                    <span class="badge badge-success float-right p-2">{{ $review->note }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('movie', $review->movie_id) }}">
                                <img class="rounded" src="https://image.tmdb.org/t/p/w500{{ $movie_controller->getMovie($review->movie_id)->poster_path }}" height="160"/>
                            </a>
                        </div>
                        <div class="col-md-8">
                            <p class="mb-0"><b>{{ $review->title }}</b></p>
                            <a href="{{ route('user', $review->user_id) }}">
                                <p class="mb-0"><small>{{ $user_model::find($review->user_id)->name }}</small></p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Most Valued Movies -->
        <div class="col-md-4 last-reviews">
            <h2 class="mb-3">{{ __('custom.Películas más valoradas') }}</h2>
            @foreach($most_valued_movies as $review)
            <div class="card">
                <div class="card-header">
                    {{ $movie_controller->getMovie($review->movie_id)->title }}
                    <span class="badge badge-success float-right p-2">{{ $review->note }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('movie', $review->movie_id) }}">
                                <img class="rounded" src="https://image.tmdb.org/t/p/w500{{ $movie_controller->getMovie($review->movie_id)->poster_path }}" height="160"/>
                            </a>
                        </div>
                        <div class="col-md-8">
                            {{ $movie_controller->getTotalReviewsOfAMovie($review->movie_id) }} {{ __('custom.críticas') }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- More Active Users -->
        <div class="col-md-4 last-reviews">
            <h2 class="mb-3">{{ __('custom.Usuarios más activos') }}</h2>
            @foreach($users_with_most_reviews as $user)
            <div class="card">
                <div class="card-header">
                    {{ $user->name }}
                    <span class="badge badge-success float-right p-2">{{ $user->total_reviews }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('user', $user->id) }}">
                                <img class="rounded" src="/images/users/{{ $user->image }}" height="160"/>
                            </a>
                        </div>
                        <div class="col-md-8">
                            {{ $user->total_reviews }} {{ __('custom.críticas') }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>

    <hr>

</div> <!-- /container -->

@endsection
