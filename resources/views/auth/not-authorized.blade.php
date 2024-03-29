@extends('layouts.auth-pages')

@section('content')
<div class="row mt-2">
    <div class="col-12 col-md-8 offset-2">
        <div class="alert alert-danger text-center">
            <strong>Restricted route:</strong>
            Uh, uh, uh! Di ka pwede!
        </div>
    </div>
    <div class="col-12 col-md-4 offset-4 mb-3">
        @auth
            <a href="{{ URL::previous() }}" class="btn btn-secondary btn-block btn-sm">Back</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-warning btn-block btn-sm">Login</a>
        @endauth
    </div>
    <div class="col-12 col-md-4 offset-4">
        <img src="{{ asset('/assets/images/not-authorized-animated.gif') }}" alt="Not Authorized" class="img-fluid" width="100%">
    </div>
</div>
@endsection