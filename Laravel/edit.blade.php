@extends('layouts.app', ['page' => __('Edit Profile'), 'pageSlug' => 'edit-profile'])

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<div class="row">
    <div class="col-md-8 edit_profile-admin">
        <div class="card edit_password">
            <div class="card-header">
                <h5 class="title">{{ __('Edit Profile') }}</h5>
            </div>
            <form method="post" action="{{ route('profile.update') }}" autocomplete="off" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @method('put')

                    <div class="form-group img-sec-profile-sec">
                        <div class="img-sec-profile-inner form-control">
                            <img id="profile-pic" class="img-responsive" src="{{ asset('/storage') }}/{{ auth()->user()->profile_pic }}">
                            <input type="file" id="profile-pic-input" class="form-control" name="photo[]">
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}">
                        @include('alerts.feedback', ['field' => 'name'])
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label>{{ __('Email address') }}</label>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email address') }}" value="{{ old('email', auth()->user()->email) }}">
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>

                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                </div>
                    <!--div class="card-footer">
                      
                    </div-->
                </form>
            </div>

        </br>
        <div class="card edit_password">
            <div class="card-header">
                <h5 class="title">{{ __('Password') }}</h5>
            </div>
            <form method="post" action="{{ route('profile.password') }}" autocomplete="off" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @method('put')

                    @include('alerts.success', ['key' => 'password_status'])

                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                        <label>{{ __('Current Password') }}</label>
                        <input type="password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>
                        @include('alerts.feedback', ['field' => 'old_password'])
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm New Password') }}" value="" required>
                    </div>

                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Change password') }}</button>
                </div>
                    <!--div class="card-footer">
                      
                    </div-->
                </form>
            </div>
        </div>