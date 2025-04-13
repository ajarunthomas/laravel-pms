@extends('partials.login_layout')

@section('body')
<div class="h1">
    Login
</div>
<form method="post" action="{{ route('login.submit') }}">
    @csrf
    <div class="form-group col-lg-4">
        <label class="label">Username</label>
        <input class="form-control" type="text" name="username" />
    </div>
    <div class="form-group col-lg-4 mb-2">
        <label class="label">Password</label>
        <input class="form-control" type="password" name="password" />
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <a class="btn btn-dark" href="{{ route('register') }}">Register</a>
</form>

@if(session()->has('message'))
<div class="row">
    <div class="col-lg-4 mt-2">
        <div class="alert alert-{{ session('alert_type') }}" role="alert">{{ session('message') }}</div>
    </div>
</div>
@endif
@endsection