@extends('layout.auth')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>{{ env('APP_NAME') }}</b></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                @if(session('success') != null)
                    <p class="login-box-msg text-success">{{ session('success') }}</p>

                @else
                    <p class="login-box-msg">Enter OTP and email to activate this account.</p>
                @endif

                <form action="{{ route('auth.activation') }}" method="post">
                    <div class="mb-1">
                        <input type="number" class="form-control" placeholder="OTP" name="otp">
                    </div>
                    <div class="mb-1">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Activate Now</button>
                        </div>

                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('auth.login') }}">Login</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('auth.register') }}" class="text-center">Register</a>
                </p>
            </div>

        </div>
    </div>
@endsection
