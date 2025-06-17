@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('adminlte_css')
    {{-- Animate.css CDN + estilos personalizados --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body.login-page {
            background: linear-gradient(to right,rgb(183, 75, 160), #182848);
        }

        .login-box {
            animation: fadeInDown 1s;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        .form-control {
            border-radius: 8px;
        }

        .input-group-text {
            border-radius: 0 8px 8px 0;
        }

        .btn-primary {
            border-radius: 8px;
        }

        .auth-footer a {
            color: #f8f9fa;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>
@stop

@php
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');
    $registerUrl = View::getSection('register_url') ?? config('adminlte.register_url', 'register');
    $passResetUrl = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset');

    if (config('adminlte.use_route_url', false)) {
        $loginUrl = $loginUrl ? route($loginUrl) : '';
        $registerUrl = $registerUrl ? route($registerUrl) : '';
        $passResetUrl = $passResetUrl ? route($passResetUrl) : '';
    } else {
        $loginUrl = $loginUrl ? url($loginUrl) : '';
        $registerUrl = $registerUrl ? url($registerUrl) : '';
        $passResetUrl = $passResetUrl ? url($passResetUrl) : '';
    }
@endphp

@section('auth_header')
    
    <h4 class="text-center text-white font-weight-bold">Bienvenido, por favor inicia sesión</h4>
@endsection

@section('auth_body')
    <form action="{{ $loginUrl }}" method="post">
        @csrf

        {{-- Email --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="{{ __('Correo electrónico') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text bg-primary text-white">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>

            @error('email')
                <div class="alert alert-danger mt-1 mb-0 p-1 w-100" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('Contraseña') }}">

            <div class="input-group-append">
                <div class="input-group-text bg-primary text-white">
                    <span class="fas fa-lock"></span>
                </div>
            </div>

            @error('password')
                <div class="alert alert-danger mt-1 mb-0 p-1 w-100" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Remember & Submit --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary" title="{{ __('Recordarme') }}">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">
                        {{ __('Recordarme') }}
                    </label>
                </div>
            </div>

            <div class="col-5">
                <button type="submit"
                        class="btn btn-primary btn-block shadow-sm">
                    <i class="fas fa-sign-in-alt mr-1"></i>
                    {{ __('Iniciar sesión') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@section('auth_footer')
    @if($passResetUrl)
        <p class="mt-3 mb-1 text-center text-light">
            <a href="{{ $passResetUrl }}">{{ __('¿Olvidaste tu contraseña?') }}</a>
        </p>
    @endif

    @if($registerUrl)
        <p class="mb-0 text-center text-light">
            <a href="{{ url('/crear-empresa') }}">{{ __('Registrar nueva empresa') }}</a>
        </p>
    @endif
@endsection

