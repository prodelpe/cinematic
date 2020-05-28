@extends('layouts.user-data')

@section('review-list')

<div class="container">
    <div class="review-list">
        <div class="col-md-12 p-4 card">

            @foreach($user_reviews as $i => $user_review)
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <p class="m-0 p-0"><b>{{ $user_review->title }}</b> - <small class="text-muted">{{ date_format(new DateTime($user->created_at), 'd-m-Y') }} </small></p>
                            <p class="m-0 p-0"><small>{{ __('custom.Por') }} {{ $user->name }}</small></p>
                        </div>
                        <div class="col-md-2 text-right m-auto">
                            <span class="badge badge-success p-2">
                                <h5 class="mb-0">{{ $user_review->note }}</h5>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="card-body text-left">
                    <div class="col-md-12">
                        <div class="row">
                            {{ $user_review->review }}
                        </div>

                        @if (!empty($user_review->spoiler))
                        <div class="row mt-3 mb-3">
                            <button class="badge badge-warning p-2" type="button" data-toggle="collapse" data-target="#collapseSpoiler-{{$i}}" aria-expanded="false" aria-controls="collapseSpoiler">
                                {{ __('custom.Ver resto de la crítica con spoilers') }}    
                            </button>
                        </div>

                        <div class="row collapse" id="collapseSpoiler-{{$i}}">
                            {{ $user_review->spoiler }} 
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="cinematic-pagination">
        {{ $user_reviews->links() }}
    </div>
</div>

@endsection