@extends('layouts.layout')

@section('title', $movie->title)
@section('body-id', 'movie')

@section('content')

<!-- Content -->
<div class="container-fluid cinematic-header text-white p-0" style="background-image: url('https://image.tmdb.org/t/p/w500{{$movie->backdrop_path}}')">
    <div class="cinematic-inner-header">
        <div class="container">

            @if(session('message'))
            <div class="row">
                <div class="alert alert-success mt-4 mb-0 w-100" role="alert">
                    {!! session('message') !!}
                </div>
            </div>
            @endif

            <div class="row single-movie">
                <!-- poster -->
                <div class="col-md-4 poster">
                    <img src="https://image.tmdb.org/t/p/w500{{$movie->poster_path}}" class="rounded" alt="{{$movie->title}}" width="300">
                </div>

                <!-- data -->
                <div class="col-md-8 data">

                    <div class="row">
                        <div class="col-md-10">

                            <h1>{{$movie->title}}</h1>

                            @if(app()->getLocale() != 'en')
                            <h5>{{$movie->original_title}}</h5>
                            @endif

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

                        </div>

                        <div class="col-md-2 note">
                            <h2>
                                <span class="badge badge-success p-3">
                                    {{ $avg_note ? $avg_note : '-' }}
                                </span>
                            </h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            @if($movie->tagline)
                            <p class="tagline">
                                <i>{{$movie->tagline}}</i>
                            </p>
                            @endif

                            <p class="oververviw font-weight-light">{{$movie->overview}}</p>

                            <p class="mt-5">

                                @choice('custom.num_reviews', \App\Review::checkNumberOfReviewsOfAMovie($movie->id))

                                @if(\App\Review::checkNumberOfReviewsOfAMovie($movie->id) > 0)
                                <a class="text-warning" href="{{ route('review.index', $movie->id) }}">
                                    <u>
                                        @choice('custom.num_reviews_link', \App\Review::checkNumberOfReviewsOfAMovie($movie->id))
                                    </u>
                                </a>
                                @endif
                            </p>

                            @if(Auth::check() && \App\Review::hasUserReviewedMovie(Auth::user()->id, $movie->id))
                            <p class="text-red">{{__('custom.Ya has realizado una crítica de esta película')}}</p>
                            <p>
                                <a class="btn btn-outline-success" href="{{ route('review.edit', $movie->id) }}" role="button">{{__('custom.Edita tu crítica')}}</a>
                            </p>
                            @else
                            <p>
                                <a class="btn btn-outline-success" href="{{ route('review.create', $movie->id) }}" role="button">{{__('custom.Publica tu crítica')}}</a>
                            </p>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container credits mt-5 mb-5">
    <div class="row">

        <!-- cast -->
        <div class="credits-continer-inner col-sm-6 bg-light p-4">
            <h2>Reparto</h2>
            <ul class="cast">
                @foreach($cast as $c)
                <li><b>{{$c->name}}</b> - <i>{{$c->character}}</i></li>
                @endforeach
            </ul>
        </div>

        <!-- crew -->
        <div class="col-sm-6 bg-light p-4">
            <h2>Personal</h2>
            <ul class="crew">
                @foreach($crew as $c)
                <li><b>{{$c->name}}</b> - <i>{{$c->job}}</i></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
