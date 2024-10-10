@extends('auth.layout.main')

@section('header-resources')
@endsection

@section('auth-content')
    <!-- Content -->
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="{{ asset('/') }}" class="logo d-flex align-items-center">
                            <img src="{{ asset('assets/images/bdcalling_logo.png') }}" style="max-height: 40px" alt="Bdcalling">
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">
                        {!! Form::open([
                            'route' => 'register.store',
                            'method' => 'POST',
                            'class' => 'mb-3',
                            'id' => 'form_id',
                            'enctype' => 'multipart/form-data',
                            'role' => 'form'
                        ]) !!}

                        <!-- Name -->
                        <div class="form-floating form-floating-outline mb-3 {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Enter your name',
                            ]) !!}
                            {!! Form::label('name', 'Name') !!}
                            {!! $errors->first('name', '<span class="help-block text-danger">:message</span>') !!}
                        </div>

                        <!-- Email -->
                        <div class="form-floating form-floating-outline mb-3 {{ $errors->has('email') ? 'has-error' : '' }}">
                            {!! Form::email('email', old('email'), [
                                'class' => 'form-control',
                                'id' => 'email',
                                'placeholder' => 'Enter your email'
                            ]) !!}
                            {!! Form::label('email', 'Email') !!}
                            {!! $errors->first('email', '<span class="help-block text-danger">:message</span>') !!}
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline {{ $errors->has('password') ? 'has-error' : '' }}">
                                        {!! Form::password('password', [
                                            'class' => 'form-control',
                                            'id' => 'password',
                                            'placeholder' => 'Password',
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

                        <!-- Role Selection (User/Admin) -->
                        <div class="form-floating form-floating-outline mb-3 {{ $errors->has('role') ? 'has-error' : '' }}">
                            {!! Form::select('role', ['user' => 'User', 'admin' => 'Admin'], old('role'), [
                                'class' => 'form-control',
                                'id' => 'role',
                                'placeholder' => 'Select Role'
                            ]) !!}
                            {!! Form::label('role', 'Role') !!}
                            {!! $errors->first('role', '<span class="help-block text-danger">:message</span>') !!}
                        </div>

                        <!-- Register Button -->
                        <div class="mb-3">
                            {!! Form::button('Register', ['type' => 'submit', 'class' => 'btn btn-primary d-grid w-100']) !!}
                        </div>

                        {!! Form::close() !!}

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">
                                <span>Login</span>
                            </a>
                        </p>

                        <div class="divider my-4">
                            <div class="divider-text">or</div>
                        </div>
                    </div>
                </div>
                <!-- Register Card -->
                <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-register-mask-light.png') }}"
                     class="authentication-image d-none d-lg-block"
                     data-app-light-img="illustrations/auth-basic-register-mask-light.png"
                     data-app-dark-img="illustrations/auth-basic-register-mask-dark.png"/>
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
