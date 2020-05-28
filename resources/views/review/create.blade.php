@extends('layouts.layout')

@section('title', 'Publica tu crítica')
@section('body-id', 'create')

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
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{ route('movie', $movie->id) }}">
                        <img src="https://image.tmdb.org/t/p/w500{{$movie->poster_path}}" class="rounded w-100" alt="{{$movie->title}}" width="180">
                    </a>
                </div>

                <!-- movie data -->
                <div class="col-lg-8 col-md-7 col-sm-8 text-sm-left text-center mt-sm-0 mt-4">
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
                <div class="col-md-2 col-sm-12 d-sm-inline-flex w-100">
                    {!! Form::open(['method' => 'GET', 'action'=>['ReviewController@store', $movie->id], 'class'=>'form-inline my-2 my-lg-0 mr-auto']) !!}
                    @csrf
                    <div class="badge p-3 vote text-white m-auto">
                        <h3>{{__('custom.Tu voto')}}</h3>
                        {!! Form::select('note', [
                        '-' => '-',
                        '10' => __('custom.10 - Excelente'), 
                        '9' => __('custom.9 - Muy buena'), 
                        '8' => __('custom.8 - Notable'), 
                        '7' => __('custom.7 - Buena'), 
                        '6' => __('custom.6 - Interesante'), 
                        '5' => __('custom.5 - Pasable'), 
                        '4' => __('custom.4 - Regular'), 
                        '3' => __('custom.3 - Floja'), 
                        '2' => __('custom.2 - Mala'), 
                        '1' => __('custom.1 - Muy mala'),
                        '0' => __('custom.0 - Pésima')
                        ], null, ['class' => 'form-control mr-sm-2 mt-2 w-100']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="mb-3">
        <label>{{__('custom.Título de tu crítica')}}</label>
        {!! Form::text('title', null, ['class' => 'form-control mr-sm-2 ']); !!}
    </div>   
    <div class="mb-3 mt-3">
        <label>{{__('custom.Tu crítica sin spoilers')}}</label>
        {!! Form::textarea('review', null, ['rows' => 4, 'cols' => 54, 'class' => 'form-control mr-sm-2']) !!}
    </div>
    <div class="mb-3 mt-3">
        <label>{{__('custom.Zona Spoiler')}}</label>
        {!! Form::textarea('spoiler', null, ['rows' => 4, 'cols' => 54, 'class' => 'form-control mr-sm-2']) !!}
    </div>
    {!! Form::hidden('user_id', Auth::user()->id) !!}
    {!! Form::hidden('movie_id', $movie->id) !!}
    <div class="mb-3 mt-3">
        {!! Form::submit('Publicar', ['class' => 'btn btn-outline-success my-2 my-sm-0']); !!}
    </div>
    {!! Form::close() !!}
</div>
</div>

@endsection