@extends('auth.layout.main')

@section('header-resources')
@endsection

@section('auth-content')
    {!! Form::open([
        'route' => 'verify-login.otp.action',
        'method' => 'POST',
        'class' => 'mb-3',
        'id' => 'form_id',
        'enctype' => 'multipart/form-data',
        'role' => 'form'
    ]) !!}

    <!-- Content -->
    <div class="positive-relative">
        <div class="authentication-wrapper authentication-basic">
            <div class="authentication-inner py-4">
                <!--  Two Steps Verification -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="{{ asset('/') }}" class="logo d-flex align-items-center">
                            <img src="{{ asset('assets/images/bdcalling_logo.png') }}" style="max-height: 40px" alt="Bdcalling">
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body">
                        {!! Form::hidden('email', $email) !!}

                        <h4 class="mb-2 fw-semibold">Two Step Verification 💬</h4>
                        <p class="text-start mb-4">
                            We sent a verification code to your email. Enter the code from the email in the field below.
                            <span class="fw-bold d-block mt-2">{{ $email }}</span>
                        </p>
                        <p class="mb-0 fw-semibold">Type your 6 digit security code</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <div class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                                @for ($i = 0; $i < 6; $i++)
                                    {!! Form::text('otp_digit_' . $i, null, [
                                        'class' => 'form-control auth-input w-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2' . ($errors->has('otp_digit_' . $i) ? ' is-invalid' : ''),
                                        'maxlength' => 1,
                                        'autofocus' => $i === 0 ? 'autofocus' : null,
                                    ]) !!}
                                    @if ($errors->has('otp_digit_' . $i))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('otp_digit_' . $i) }}
                                        </div>
                                    @endif
                                @endfor
                            </div>
                            <!-- Create a hidden field which is combined by the fields above -->
                            {!! Form::hidden('otp', null) !!}
                        </div>

                        {!! Form::button('Verify my account', ['type' => 'submit', 'class' => 'btn btn-primary d-grid w-100 mb-3']) !!}
                        <div class="text-center">
                            Didn't get the code?
                            <a href="javascript:void(0);">Resend</a>
                        </div>

                    </div>
                </div>
                <!-- / Two Steps Verification -->
                <img
                    alt="mask"
                    src="{{ asset('assets/img/illustrations/auth-basic-register-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block"
                    data-app-light-img="illustrations/auth-basic-register-mask-light.png"
                    data-app-dark-img="illustrations/auth-basic-register-mask-dark.png" />
            </div>
        </div>
    </div>
    <!-- / Content -->

    {!! Form::close() !!}
@endsection

@section('footer-script')
    <script>
        $(document).ready(function() {
            $('#form_id').on('submit', function(e) {
                var otp = '';
                for (var i = 0; i < 6; i++) {
                    otp += $('input[name="otp_digit_' + i + '"]').val();
                }
                $('input[name="otp"]').val(otp);
            });
        });
    </script>
@endsection
