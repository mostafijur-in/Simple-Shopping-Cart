@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form id="register_form">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="full_name" id="full_name" class="form-control form-control-sm reqField" placeholder="Full name" />
                                <p id="full_name_msg" class="input-status-msg"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input type="email" name="email_id" id="email_id" class="form-control form-control-sm reqField" placeholder="xyz@example.com" />
                                <p id="email_id_msg" class="input-status-msg"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input type="password" name="login_password" id="login_password" class="form-control form-control-sm reqField" placeholder="Password" />
                                <p id="login_password_msg" class="input-status-msg"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input type="password" name="repeat_password" id="repeat_password" class="form-control form-control-sm reqField" placeholder="Confirm password" />
                                <p id="repeat_password_msg" class="input-status-msg"></p>
                            </div>
                        </div>

                        <div id="register_form_status" class="mt-3 mx-auto w-75"></div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <input type="hidden" name="redirect" value="{{ $redirect }}">
									    <button type="button" id="register_form_submit" onclick="window.registerSubmit();" class="btn btn-primary">Register</button>
                                    </div>
                                    <div>
                                        @php
                                            $loginrUrl   = empty($redirect) ? route("login") : route("login", ["redirect" => $redirect]);
                                        @endphp
                                        <p class="text-right mb-0">Already registered? <a href="{{ $loginrUrl }}">Login here</a></p>
                                    </div>
                                </div>
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
