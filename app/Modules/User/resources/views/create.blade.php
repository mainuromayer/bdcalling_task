@extends('backend.layouts.content')

@section('header-resources')
    @include('partials.datatable_css')

    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    {!! Form::open([
       'route' => 'user.store',
        'method' => 'post',
        'id' => 'form_id',
        'enctype' => 'multipart/form-data',
        'files' => 'true',
        'role' => 'form',
    ]) !!}


    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary form-card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title pt-2 pb-2"> Create New User </h3>
                    <div class="card-tools">
                        <a href="{{ route('user.list') }}" class="btn btn-sm btn-primary"><i
                                class="bx bx-list-ul pr-2"></i> User List </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">

                    <div class="input-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter User Name',
                            ]) !!}
                            {!! $errors->first('name', '<span class="help-block text-danger">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'Email', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('email', old('email'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter Email',
                            ]) !!}
                            {!! $errors->first('email', '<span class="help-block text-danger">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! Form::label('password', 'Password', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::password('password', [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter Password',
                            ]) !!}
                            {!! $errors->first('password', '<span class="help-block text-danger">:message</span>') !!}
                        </div>
                    </div>


                    <div class="input-group row {{ $errors->has('role') ? 'has-error' : '' }}">
                        {!! Form::label('role', 'User Type', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('role', $roles, old('role'), ['class' => 'form-control required select2']) !!}
                            {!! $errors->first('role', '<span class="help-block text-danger">:message</span>') !!}
                        </div>
                    </div>


                    <div class="input-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button class="btn btn-primary">Add</button>
                        </div>
                    </div>

                </div>

                {!! form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <script type="text/javascript" src="{{ asset('assets/libs/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#form_id").validate({
                errorPlacement: function() {
                    return true;
                },
            });
        });

        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'Select One',
                allowClear: true
            });
        });
    </script>
@endsection
