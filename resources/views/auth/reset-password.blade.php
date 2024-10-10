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
                            <img src="{{ asset('assets/images/bdcalling_logo.png') }}" style="max-height: 40px" alt="Bdcalling">
                        </a>
                    </div>
                    <!-- /Logo -->

                    <!-- Reset Password -->
                    <div class="card-body mt-2">
                        <h4 class="mb-2 fw-semibold">Reset Password 🔒</h4>
                        <p class="mb-4">Your new password must be different from previously used passwords</p>

                        {!! Form::open([
                            'route' => 'reset-password.action',
                            'method' => 'POST',
                            'class' => 'mb-3',
                            'id' => 'form_id',
                            'enctype' => 'multipart/form-data',
                            'role' => 'form'
                        ]) !!}

                        {!! Form::hidden('token', $token) !!}
                        {!! Form::hidden('email', old('email')) !!}

                        <!-- New Password -->
                        <div class="mb-3 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {!! Form::password('password', [
                                        'class' => 'form-control',
                                        'id' => 'password',
                                        'placeholder' => '••••••••',
                                        'aria-describedby' => 'password'
                                    ]) !!}
                                    {!! Form::label('password', 'New Password') !!}
                                    {!! $errors->first('password', '<span class="help-block text-danger">:message</span>') !!}
                                </div>
                                <span class="input-group-text cursor-pointer">
                                    <i class="mdi mdi-eye-off-outline" onclick="togglePasswordVisibility('password', this)"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                    {!! Form::password('password_confirmation', [
                                        'class' => 'form-control',
                                        'id' => 'confirm-password',
                                        'placeholder' => '••••••••',
                                       'aria-describedby' => 'confirm-password'
                                    ]) !!}

                                    {!! Form::label('password_confirmation', 'Confirm Password') !!}
                                    {!! $errors->first('password_confirmation', '<span class="help-block text-danger">:message</span>') !!}
                                </div>
                                <span class="input-group-text cursor-pointer">
                                    <i class="mdi mdi-eye-off-outline" onclick="togglePasswordVisibility('confirm-password', this)"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        {!! Form::button('Set new password', ['type' => 'submit', 'class' => 'btn btn-primary d-grid w-100 mb-3']) !!}

                        <!-- Back to login -->
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

                <!-- Image Illustration -->
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
        function togglePasswordVisibility(fieldId, element) {
            let passwordField = document.getElementById(fieldId);
            let eyeIcon = element;

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove('mdi-eye-off-outline');
                eyeIcon.classList.add('mdi-eye-outline');
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove('mdi-eye-outline');
                eyeIcon.classList.add('mdi-eye-off-outline');
            }
        }
    </script>
@endsection
