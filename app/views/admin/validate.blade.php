@extends('master')
@section('content')
@if (Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
    {{ Session::get('message') }}
</div>
@endif
@if (Session::has('errormessage'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
    {{ Session::get('errormessage') }}
</div>
@endif
{{ Form::open(array('url' => 'admin/validate','id' => 'formChangePass')) }}
<div class="row centered-form">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
        <div class="panel panel-default panel-danger">
            <div class="panel-heading ">
                <h3 class="panel-title">{{trans('labels.validate.lbl_title')}}</h3>
            </div>
            <div class="panel-body">
                <div class="form-group @if ($errors->has('oldPassword')) has-error @endif">
                    <label for="old password">{{trans('labels.validate.lbl_old_pwd')}}</label>
                    <input type="password" id="old password" class="form-control" name="oldPassword" placeholder="{{trans('placeholder.create.password')}}" value="{{ Input::old('password') }}">
                    @if ($errors->has('oldPassword')) <p class="help-block">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        Old Password is required.
                    </div>
                </p>
                @endif
            </div>
            <div class="form-group @if ($errors->has('password')) has-error @endif">
                <label for="password">{{trans('labels.validate.lbl_new_pwd')}}</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="Enter Password" value="{{ Input::old('password') }}">
                @if ($errors->has('password')) <p class="help-block">
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    New Password is required.
                </div>
            </p>
            @endif
        </div>
        <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
            <label for="password_confirmation">{{trans('labels.validate.lbl_confirm_pwd')}}</label>
            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Enter Password again" value="{{ Input::old('password_confirmation') }}">
            @if ($errors->has('password_confirmation')) <p class="help-block">
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                Confirm Password is required.
            </div>
        </p>
        @endif
    </div>
    {{ Form::submit('UPDATE', array('class' => 'btn col-sm-5 btn-md btn-success','style'=>'margin-left:40px;')) }}
    <a href="{{URL::to('admin')}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left:10px;">{{trans('labels.lbl_validate')}}</a>
    {{ Form::close() }}
</div>
</div>
</div>
</div>
{{Form::close()}}
@stop