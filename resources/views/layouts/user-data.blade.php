@extends('layouts.layout')

@section('title', 'Home')
@section('body-id', 'home')

@section('content')
<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $isTheLoggedUser ? __('custom.Panel de control') : __('custom.Perfil de usuario') }}</div>

                <div class="card-body">
                    <div class="row">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if($isTheLoggedUser)
                        <div class="sidebar-menu col-sm-4">
                            <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-index" role="tab" aria-controls="home">
                                    {{ __('custom.Mi perfil') }}
                                </a>
                                <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-edit" role="tab" aria-controls="profile">
                                    {{ __('custom.Editar perfil') }}
                                </a>
                                <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-delete" role="tab" aria-controls="settings">
                                    {{ __('custom.Borrar perfil') }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="user-data {{ $isTheLoggedUser ? 'col-sm-8' : 'col-sm-12'   }}">
                            <div class="tab-content" id="nav-tabContent">

                                <!-- Mi perfil -->
                                <div class="tab-pane fade show active dashboard-profile" id="list-index" role="tabpanel" aria-labelledby="list-home-list">

                                    @if($user->image)
                                    <img src="/images/users/{{ $user->image }}" alt="{{ $user->image }}" class="rounded-circle mb-3" width="150"/>
                                    @else
                                    <img src="/images/pic-not-found.jpg" alt="{{ $user->name }}" class="rounded-circle mb-3" width="150"/>
                                    @endif

                                    <p class="user-name">{{ $user->name }}</p>

                                    @if($isTheLoggedUser)
                                    <p class="user-email text-black-50">{{ $user->email }}</p>
                                    <p class="user-date text-black-50"><small>{{ __('custom.Te diste de alta el') }} {{ date_format($user->created_at, 'd-m-Y') }}</small></p>
                                    @endif

                                    <hr>

                                    <span class="badge badge-pill badge-light p-2">
                                        {{ $number_user_reviews }} {{__('custom.críticas publicadas') }}
                                    </span>
                                    <span class="badge badge-pill badge-light p-2">
                                        {{__('custom.Puntuación media') }}: {{ $user_avg_note }}
                                    </span>
                                </div>

                                <!-- Editar perfil -->
                                <div class="tab-pane fade" id="list-edit" role="tabpanel" aria-labelledby="list-profile-list">
                                    {!! Form::model($user, ['method'=>'PUT', 'action'=>['HomeController@update', $user->id], 'files'=>true]) !!}

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            {!! Form::label('image', __('custom.Imagen de perfil') ); !!}
                                            {!! Form::file('image', ['class' => 'form-control-file mb-3']) !!}

                                            {!! Form::label('nombre', __('custom.Nombre') ); !!}
                                            {!! Form::text('name', null, ['class' => 'form-control mb-3']) !!}

                                            {!! Form::label('email', __('custom.Email') ); !!}
                                            {!! Form::text('email', null, ['class' => 'form-control mb-3']) !!}

                                            {{csrf_field()}}

                                            {!! Form::submit( __('custom.Actualizar'), ['class' => 'btn btn-primary'] ) !!}

                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- Borrar -->
                                <div class="tab-pane fade" id="list-delete" role="tabpanel" aria-labelledby="list-messages-list">

                                    <div class="alert alert-danger" role="alert">
                                        {{ __('custom.¡Cuidado! ¡Ésto eliminará todos tus datos de la base de datos!') }}
                                    </div>

                                    {{-- TODO: Fer que l'estás seguro sigui traduïble --}}
                                    {!! Form::open(['method'=>'DELETE', 'action'=>['HomeController@destroy', $user->id]]) !!}
                                    {!! Form::submit(__('custom.Eliminar usuario'), [
                                    'class' => 'btn btn-outline-danger my-2 my-sm-0', 
                                    'onclick' => 'return confirm("¿Estás seguro?")'
                                    ]); !!}
                                    {{csrf_field()}}
                                    {!! Form::close() !!}    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if( $number_user_reviews > 0 )
@yield('review-list')
@endif

@endsection

