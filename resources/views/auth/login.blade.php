@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form id="login_form">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="username" id="username" class="form-control form-control-sm" placeholder="Mobile number / email id" />
                                <p id="username_msg" class="input-status-msg"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Enter your password" />
                                <p id="password_msg" class="input-status-msg"></p>
                            </div>
                        </div>

                        <div id="login_form_status" class="mt-3 mx-auto w-75"></div>

                        <div class="form-group row mb-2">
                            <div class="col-md-6 offset-md-4">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    <div>
                                        @php
                                            $registerUrl   = empty($redirect) ? route("register") : route("register", ["redirect" => $redirect]);
                                        @endphp
                                        <p class="text-right mb-0">Not registered? <a href="{{ $registerUrl }}">Register Now</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="hidden" name="redirect" value="{{ $redirect }}">
                                <button type="button" id="login_form_submit" onclick="window.loginSubmit();" class="btn btn-lg btn-primary">Sign in</button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
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
@endsection

@section('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endsection
