@extends('auth.layout.main')

@section('header-resources')
@endsection

@section('auth-content')
    <!-- Content -->
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
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

                    <div class="card-body mt-2">


                        {!! Form::open([
                            'route' => 'login.check',
                            'method' => 'POST',
                            'class' => 'mb-3',
                            'id' => 'form_id',
                            'enctype' => 'multipart/form-data',
                            'role' => 'form'
                        ]) !!}

                        <div class="form-floating form-floating-outline mb-3 {{ $errors->has('email') ? 'has-error' : '' }}">
                            {!! Form::text('email', old('email'), [
                                'class' => 'form-control',
                                'placeholder' => 'Enter your email',
                                'autofocus' => 'true'
                            ]) !!}
                            {!! Form::label('email', 'Email') !!}
                            {!! $errors->first('email', '<span class="help-block text-danger">:message</span>') !!}
                        </div>

                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline {{ $errors->has('password') ? 'has-error' : '' }}">
                                        {!! Form::password('password', [
                                            'class' => 'form-control',
                                            'id' => 'password',
                                            'placeholder' => '&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;',
                                            'aria-describedby' => 'password'
                                        ]) !!}
                                        {!! Form::label('password', 'Password') !!}
                                        {!! $errors->first('password', '<span class="help-block text-danger">:message</span>') !!}
                                    </div>
                                    <span class="input-group-text cursor-pointer form-password">
                                        <i onclick="togglePasswordVisibility()" class="mdi mdi-eye-off-outline"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                {!! Form::checkbox('remember', '1', false, ['class' => 'form-check-input', 'id' => 'remember-me']) !!}
                                {!! Form::label('remember-me', 'Remember Me', ['class' => 'form-check-label']) !!}
                            </div>
                            <a href="{{ url('/forgot-password') }}" class="float-end mb-1">
                                <span>Forgot Password?</span>
                            </a>
                        </div>

                        <div class="mb-3">
                            {!! Form::button('Login', ['type' => 'submit', 'class' => 'btn btn-primary d-grid w-100']) !!}
                        </div>

                        {!! Form::close() !!}


                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ url('/register') }}">
                                <span>Create an account</span>
                            </a>
                        </p>

                        <div class="divider my-4">
                            <div class="divider-text">or</div>
                        </div>

                        <div class="d-flex justify-content-center gap-2">
                            <a href="https://www.facebook.com/profile.php?id=61558796675458" target="_blank" class="btn btn-icon btn-lg rounded-pill btn-text-facebook">
                                <i class="tf-icons mdi mdi-24px mdi-facebook"></i>
                            </a>

                            <a href="https://www.linkedin.com/company/codefotech/" target="_blank" class="btn btn-icon btn-lg rounded-pill btn-text-linkedin">
                                <i class="tf-icons mdi mdi-24px mdi-linkedin"></i>
                            </a>

                            <a href="https://github.com/codefotech/" target="_blank" class="btn btn-icon btn-lg rounded-pill btn-text-github">
                                <i class="tf-icons mdi mdi-24px mdi-github"></i>
                            </a>

                        </div>
                    </div>
                </div>
                <!-- /Login -->
                <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-login-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block"
                    data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                    data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
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
