@extends('partials.layout')

@section('body')
<div class="h1">
    Register
</div>

<form method="post" action="{{ route('register.submit') }}">
    @csrf
    <div class="form-group col-lg-4">
        <label class="label">Name</label>
        <input class="form-control" type="text" name="name" />
    </div>
    <div class="form-group col-lg-4">
        <label class="label">Username</label>
        <input class="form-control" type="text" name="username" />
    </div>
    <div class="form-group col-lg-4 mb-2">
        <label class="label">Password</label>
        <input class="form-control" type="password" name="password" />
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
    <a class="btn btn-dark" href="{{ route('login') }}">Back to Login</a>
</form>

@if(session()->has('message'))
<div class="row">
    <div class="col-lg-4 mt-2">
        <div class="alert alert-{{ session('alert_type') }}" role="alert">{{ session('message') }}</div>
    </div>
</div>
@endif
@endsection