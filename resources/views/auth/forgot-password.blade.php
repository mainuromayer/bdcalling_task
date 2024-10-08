@extends('auth.layout.main')

@section('header-resources')
@endsection

@section('auth-content')
    <!-- Content -->
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Logo -->
                <div class="card p-2">
                    <!-- Forgot Password -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="{{ asset('/') }}" class="logo d-flex align-items-center">
                            <!-- <img src="assets-2/img/logo.png" alt="">
                            <span>FlexStart</span> -->

                            <img src="{{ asset('assets-2/img/CodeFoTech-1.png') }}" style="max-height: 40px" alt="Codefotech">
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">
                        <h4 class="mb-2">Forgot Password? 🔒</h4>
                        <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                        {!! Form::open([
                            'route' => 'forgot-password.create',
                            'method' => 'POST',
                            'class' => 'mb-3',
                            'id' => 'form_id',
                            'enctype' => 'multipart/form-data',
                            'role' => 'form'
                        ]) !!}

                        <div class="form-floating form-floating-outline mb-3 {{ $errors->has('email') ? 'has-error' : '' }}">
                            {!! Form::text('email', null, [
                                'class' => 'form-control',
                                'id' => 'email',
                                'placeholder' => 'Enter your email',
                                'autofocus' => true
                            ]) !!}
                            {!! Form::label('email', 'Email') !!}
                            {!! $errors->first('email', '<span class="help-block text-danger">:message</span>') !!}
                        </div>

                        {!! Form::button('Send Reset Link', ['type' => 'submit', 'class' => 'btn btn-primary d-grid w-100']) !!}

                        {!! Form::close() !!}

                        <div class="text-center">
                            <a href="{{ url('/login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
                <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-forgot-password-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block"
                    data-app-light-img="illustrations/auth-basic-forgot-password-mask-light.png"
                    data-app-dark-img="illustrations/auth-basic-forgot-password-mask-dark.png" />
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('footer-script')
@endsection
