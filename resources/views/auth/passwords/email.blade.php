@extends('layouts.auth-pages')

@section('content')
    <div class="login-box row d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-8 px-0 col-12 justify-content-center align-content-center card card-outline card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <img src="{{ asset('assets/images/cdl-logo.png') }}" alt="CDL Logo" style="width: 30%" class="cdl-logo">
                        <img src="{{ asset('assets/icons/diary-icon.ico') }}" alt="Diary Logo" style="width: 8%">
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        <a href="#" class="h3"><b>CDL </b>Duty Diary</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="login-box-msg">Enter your email address</p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
                        </div>
                    <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection
