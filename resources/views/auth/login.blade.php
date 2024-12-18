@extends('layouts.login')

@section('content')
<div class="container justify-content-center">
    <div class="row justify-content-center" >
        <div class="col-md-6">
            <div class="card shadow-sm" style="background-color: #056262">
                <div class="card-header" style="color: white"><label style="font-size: 18px;font-weight: bolder;">Admin Login</label></div>

                @if(Session::has('message'))
                    
                    <script type="text/javascript">
                        alert('{{ Session::get('message') }}');
                    </script>
                @endif  

                <div class="card-body" >
                    <form method="POST"  action="{{ url('/login')}}" id="loginForm">
                        @csrf

                        <div class="row mb-3">
                            <label style="color: white" for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  required  autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label style="color: white" for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="off" required >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label style="color: white" class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <input type='hidden' value="{{ Session::get('publicKey')  }}" id="publicKey" />

                        <div class="row mb-0">
                            <span class="invalid-feedback text-center py-2 text-white" role="alert" id="invalidCred"> User Id / Password seems to be invalid </span>
                            <div class="col-md-8 offset-md-4">

                                <button type="button" id="loginBtn" class="btn btn-warning">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a style="color: white" class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ env('APP_URL') }}/js/jsencrypt.min.js" nonce="wUDPhZ1Z60pnMCukimCi"></script>
<script src="{{ env('APP_URL') }}/js/encrypt.js" nonce="wUDPhZ1Z60pnMCukimCi"></script>
@endsection
