@extends('master')
@section('content')
@if (Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
    {{ Session::get('message') }}
</div>
@endif
{{ Form::open(array('url' => 'hr/validate')) }}
<div class="row centered-form">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
        <div class="panel panel-default panel-danger">
            <div class="panel-heading ">
                <h3 class="panel-title">CHANGE PASSWORD</h3>
            </div>
            <div class="panel-body">
                <div class="form-group @if ($errors->has('oldPassword')) has-error @endif">
                    <label for="old password">Old Password</label>
                    <input type="password" id="old password" class="form-control" name="oldPassword" placeholder="Enter Password" value="{{ Input::old('password') }}">
                    @if ($errors->has('oldPassword')) <p class="help-block">{{ $errors->first('oldPassword') }}</p> @endif
                </div>
                <div class="form-group @if ($errors->has('password')) has-error @endif">
                    <label for="password">New Password</label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Enter Password" value="{{ Input::old('password') }}">
                    @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                </div>
                <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Enter Password again" value="{{ Input::old('password_confirmation') }}">
                    @if ($errors->has('password_confirmation')) <p class="help-block">{{ $errors->first('password_confirmation') }}</p> @endif
                </div>
                {{ Form::submit('Submit', array('class' => 'btn col-sm-5 btn-md btn-success','style'=>'margin-left:40px;')) }}
                <a href="{{URL::to('employees')}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left:10px;">CANCEL</a>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
@stop