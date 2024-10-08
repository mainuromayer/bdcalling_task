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

                    <!-- Verify Email -->
                    <div class="card-body mt-2">
                        <h4 class="mb-2">Verify your email ✉️</h4>
                        <p class="text-start mb-2">
                            Account activation link sent to your email address: hello@example.com Please follow the link
                            inside to
                            continue.
                        </p>
                        <a class="btn btn-primary w-100 my-3" href="{{ url('/') }}"> Skip for now </a>
                        <p class="text-center mb-0">
                            Didn't get the mail?
                            <a href="javascript:void(0);"> Resend </a>
                        </p>
                    </div>
                </div>
                <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-login-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block"
                    data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                    data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
                <!-- /Verify Email -->
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('footer-script')
@endsection
