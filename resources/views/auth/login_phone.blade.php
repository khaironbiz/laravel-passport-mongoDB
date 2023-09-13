@extends('layout.auth')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>{{ env('APP_NAME') }}</b></a>
        </div>

        <div class="card">
            <div class="card-img text-center">
                <img class="small card-img w-50" src="{{ env('APP_LOGO') }}">
            </div>
            <div class="card-body login-card-body">
                @if(session('danger') != null)
                    <p class="login-box-msg text-danger">{{ session('danger') }}</p>
                @elseif (session('success') != null)
                    <p class="login-box-msg text-success">{{ session('success') }}</p>
                @else
                    <p class="login-box-msg">Passcode will be sent to WhatsApp</p>
                @endif
                <form action="{{ route('auth.postLoginPhone') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="number" class="form-control" name="nomor_telepon" placeholder="Nomor Telepon" value="{{ old('nomor_telepon') }}">
                        @error('nomor_telepon')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row justify-content-center">

                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">Passcode Request </button>
                        </div>
                    </div>
                </form>
                    <hr>
                    <p class="mb-0"><a href="{{ route('auth.login') }}" class="text-center">Login Email</a></p>
                    <p class="mb-0"><a href="{{ route('auth.activate') }}" class="text-center">Account Activation</a></p>
                    <p class="mb-0"><a href="{{ route('auth.forgotPassword') }}">I forgot my password</a></p>
                    <p class="mb-0"><a href="{{ route('auth.register') }}" class="text-center">Register a new membership</a></p>
            </div>

        </div>
    </div>
@endsection


