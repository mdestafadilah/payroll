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
{{ Form::open(array('url' => 'admin/update/' .$user->user_id)) }}
<div class="row centered-form">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
        <div class="panel panel-default panel-danger">
            <div class="panel-heading ">
                <h3 class="panel-title">{{trans('labels.master.lbl_update_accounts')}}</h3>
            </div>
            <div class="panel-body">
                <div class="form-group @if ($errors->has('username')) has-error @endif">
                    <label for="username">{{trans('labels.register.lbl_username')}}</label>
                    <input type="text" id="username" class="form-control" name="username" placeholder="{{trans('placeholder.register.username')}}" value="{{ $user->username }}">
                    @if ($errors->has('username')) <p class="help-block">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        {{trans('labels.register.lbl_username')}} is required.
                    </div>
                </p>
                @endif
            </div>
            <div class="form-group @if ($errors->has('fullname')) has-error @endif">
                <label for="fullname">{{trans('labels.register.lbl_fullname')}}</label>
                <input type="text" id="fullname" class="form-control" name="fullname" placeholder="{{trans('placeholder.register.fullname')}}" value="{{ $user->fullname }}">
                @if ($errors->has('fullname')) <p class="help-block">
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {{trans('labels.register.lbl_fullname')}} is required.
                </div>
            </p>
            @endif
        </div>
        <div class="form-group @if ($errors->has('position')) has-error @endif">
            <label for="position">{{trans('labels.register.lbl_position')}}</label>
            <input type="text" id="position" class="form-control" name="position" placeholder="{{trans('placeholder.register.position')}}" value="{{$user->position }}">
            @if ($errors->has('position')) <p class="help-block">
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                {{trans('labels.register.lbl_position')}} is required.
            </div>
        </p>
        @endif
    </div>
    <div class="form-group">

        <label for="privilege">{{trans('labels.register.lbl_privilege')}}</label>

        <select name="privilege" class="form-control">
            <option value="0" @if($user->usr_role == 0)selected @endif>{{trans('labels.register.lbl_hr')}}</option>
            <option value="1"  @if($user->usr_role == 1)selected @endif>{{trans('labels.register.lbl_admin')}}</option>
        </select>
    </div>
    <div class="form-group">

        <label for="language">{{trans('labels.register.lbl_language')}}</label>
        <select name="language" class="form-control">
            <option disabled selected>{{trans('placeholder.register.language')}}</option>
            <option value="en" @if($user->langu == 'en')selected @endif>{{trans('labels.languages.lbl_en')}}</option>
            <option value="jp" @if($user->langu == 'jp') selected @endif>{{trans('labels.languages.lbl_jp')}}</option>
        </select>
    </div>
    {{ Form::submit('UPDATE', array('class' => 'btn col-sm-5 btn-md btn-success','style'=>'margin-left:40px;')) }}
    <a href="{{URL::to('admin')}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left:10px;">{{trans('labels.lbl_cancel')}}</a>
    {{ Form::close() }}
</div>
</div>
</div>
</div>
@stop