@extends('auth.layout.main')

@section('header-resources')
@endsection

@section('auth-content')
    <!-- Content -->
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="{{ asset('/') }}" class="logo d-flex align-items-center">
                            <!-- <img src="assets-2/img/logo.png" alt="">
                            <span>FlexStart</span> -->

                            <img src="{{ asset('assets-2/img/CodeFoTech-1.png') }}" style="max-height: 40px" alt="Codefotech">
                        </a>
                    </div>
                    <!-- /Logo -->
                    <!-- Reset Password -->
                    <div class="card-body mt-2">
                        <h4 class="mb-2 fw-semibold">Reset Password 🔒</h4>
                        <p class="mb-4">Your new password must be different from previously used passwords</p>
                        {!! Form::open([
                            'route' => 'reset-password.create',
                            'method' => 'POST',
                            'class' => 'mb-3',
                            'id' => 'form_id',
                            'enctype' => 'multipart/form-data',
                            'role' => 'form'
                        ]) !!}

                        {!! Form::hidden('token', $token) !!}
                        {!! Form::hidden('email', old('email')) !!}

                        <div class="mb-3 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {!! Form::password('password', [
                                        'class' => 'form-control',
                                        'id' => 'password',
                                        'placeholder' => '&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;',
                                        'aria-describedby' => 'password'
                                    ]) !!}
                                    {!! Form::label('password', 'New Password') !!}
                                    {!! $errors->first('password', '<span class="help-block text-danger">:message</span>') !!}
                                </div>
                                <span class="input-group-text cursor-pointer form-password">
                                    <i onclick="togglePasswordVisibility()" class="mdi mdi-eye-off-outline"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                    {!! Form::password('password_confirmation', [
                                        'class' => 'form-control',
                                        'id' => 'confirm-password',
                                        'placeholder' => '&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;',
                                        'aria-describedby' => 'confirm-password'
                                    ]) !!}
                                    {!! Form::label('password_confirmation', 'Confirm Password') !!}
                                    {!! $errors->first('password_confirmation', '<span class="help-block text-danger">:message</span>') !!}
                                </div>
                                <span class="input-group-text cursor-pointer form-password">
                                    <i onclick="togglePasswordVisibility()" class="mdi mdi-eye-off-outline"></i>
                                </span>
                            </div>
                        </div>

                        {!! Form::button('Set new password', ['type' => 'submit', 'class' => 'btn btn-primary d-grid w-100 mb-3']) !!}

                        <div class="text-center">
                            <a href="{{ url('/login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i>
                                Back to login
                            </a>
                        </div>

                        {!! Form::close() !!}


                    </div>
                </div>
                <!-- /Reset Password -->
                <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-reset-password-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block"
                    data-app-light-img="illustrations/auth-basic-reset-password-mask-light.png"
                    data-app-dark-img="illustrations/auth-basic-reset-password-mask-dark.png" />
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('footer-script')
    <script>
        function togglePasswordVisibility() {
            let password = document.getElementById("password");
            let eyeIcon = document.querySelector('.form-password i');

            if (password.type === "password") {
                password.type = "text";
                eyeIcon.classList.remove('mdi-eye-off-outline');
                eyeIcon.classList.add('mdi-eye-outline');
            } else {
                password.type = "password";
                eyeIcon.classList.remove('mdi-eye-outline');
                eyeIcon.classList.add('mdi-eye-off-outline');
            }
        }
    </script>
@endsection
