@inject('sc', 'App\Http\Controllers\SearchController')

@extends('layouts.layout')

@section('title', 'Búsqueda en Cinematic')
@section('body-id', 'search')

@section('content')

<!-- Content -->
<div class="container">

    <div class="row movie-results">
        <nav class="navbar navbar-light bg-light w-100 p-3">
            <span class="navbar-text">
                @if($total_results==1)
                Se ha encontrado un resultado
                @else
                Se han encontrado {{$total_results}} resultados
                @endif
            </span>
        </nav>
    </div>


    <div class="row">
        @foreach ($results as $result)
        <div class="col-md-3 col-6 movie-column">
            <a href="{{ route('movie', $result->id) }}">
                <div class="card">
                    <div class="movie-poster rounded" 
                         data-toggle="popover" 
                         title="{{$result->title}} 
                         @if(property_exists($result, 'release_date'))
                         ({{Str::limit($result->release_date, 4, '')}})
                         @endif"                     
                         data-placement="right" 
                         data-trigger="hover" 
                         data-content="{{$result->overview ? $result->overview : ''}}">
                        {{-- @if($result->poster_path && $sc->checkIfImageExists($result->poster_path)) --}}
                        @if($result->poster_path)
                        <img src="https://image.tmdb.org/t/p/w500{{$result->poster_path}}" class="card-img-top" alt="{{$result->title}}">
                        @else
                        <img src="images/not-found.jpg" class="card-img-top" alt="{{$result->title}}">
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{$result->title}}</h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<!-- Paginator -->
{{-- TODO: No es el paginador más elegante pero la cosa se complicó al buscar en una API y no BD interna --}}
<nav aria-label="bootstrap_pagination">
    <ul class="pagination justify-content-center">
        <!--<li class="page-item">
            <a class="page-link" href="{{ $sc->returnPageView(csrf_token(), $search, 1) }}" tabindex="-1">
                ‹‹
            </a>
        </li>-->
        <li class="page-item">
            <a class="page-link" href="{{ $sc->returnPageView(csrf_token(), $search, $page-1)}}" tabindex="-1">
                ‹
            </a>
        </li>
        @for ($i = $page-1; $i <= $page+1; $i++)
        @if($i>0 && $i<=$total_pages)
        @if($page==$i)
        <li class="page-item active" aria-current="page">
        @else
        <li class="page-item">
            @endif
            <a class="page-link" href="{{ $sc->returnPageView(csrf_token(), $search, $i)}}">
                {{$i}}
            </a>
        </li>
        @endif
        @endfor
        <li class="page-item">
            <a class="page-link" href="{{ $sc->returnPageView(csrf_token(), $search, $page+1)}}" tabindex="-1">
                ›
            </a>
        </li>
        <!--<li class="page-item">
            <a class="page-link" href="{$sc->returnPageView(csrf_token(), $search, $total_pages)}}" tabindex="-1">
                ››
            </a>
        </li>-->
    </ul>
</nav>

@endsection
