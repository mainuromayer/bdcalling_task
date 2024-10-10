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
        'route' => 'item.store',
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
                    <h3 class="card-title pt-2 pb-2"><i class="fas fa-edit"></i> Update Item </h3>
                    <div class="card-tools float-end">
                        <a href="{{ route('item.list') }}" class="btn btn-primary"><i class="fas fa-list"></i>&nbsp; Blog List </a>
                    </div>
                </div>


                <div class="card-body demo-vertical-spacing">
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="input-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Title', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('title', $data->name, [
                                'class' => 'form-control required',
                                'placeholder' => 'Title',
                            ]) !!}
                            {!! $errors->first('title', '<span class="help-block text-danger">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="input-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description', 'Present Address', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('description', old('description', $data->description), [
                                'class' => 'form-control',
                                'placeholder' => 'Description',
                            ]) !!}
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>


                    <div class="input-group row {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', 'Status', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('status', $status_list, old('status', $data->status), ['class' => 'form-control required select2']) !!}
                            {!! $errors->first('status', '<span class="help-block text-danger">:message</span>') !!}
                        </div>
                    </div>


                    <div class="input-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button class="btn btn-primary">Update</button>
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
        $("#form_id").validate({
            errorPlacement: function () {
                return true;
            },
        });

        $(function() {
            $(".select2").select2();

        });
    </script>
@endsection
