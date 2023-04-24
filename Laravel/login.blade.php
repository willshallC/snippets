@extends('layouts.app', ['class' => 'login-page', 'page' => __('Login Page'), 'contentClass' => 'login-page'])

@section('content')
    @if ($errors->any())
        <div class="alert alert-warning">
            @foreach ($errors->all() as $error)
                <div class="text-center">{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <div class="col-md-10 text-center ml-auto mr-auto">
        <h1 class="card-title">{{ __('Log in and get to work') }}</h1>
    </div>