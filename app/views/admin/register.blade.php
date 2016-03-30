@extends('master')
@section('content')
<script>$(document).on('click', '#submit', offBeforeUnload);

    function offBeforeUnload(event) {
        $(window).off('beforeunload');
    }
    function windowBeforeUnload() {
        return "Data will be lost if you leave the page.";
    }
    $(document).ready(function(){
        $('#username').focus();
        $(":input").focusout(function () {
            if ($(this).val()) {
                $(window).on('beforeunload', windowBeforeUnload);
            }
        });
    });</script>
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

    {{ Form::open(array('url' => 'admin/register')) }}
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
            <div class="panel panel-default panel-danger">
                <div class="panel-heading ">

                    <h3 class="panel-title">{{trans('labels.register.lbl_title')}}</h3>
               </div>
               <div class="panel-body">
                <input type="password" style="width:1px;height:1px;background-color:transparent;border:none;">
                <div class="form-group @if ($errors->has('username')) has-error @endif">
                    <label for="username">{{trans('labels.register.lbl_username')}}</label>
                    <input type="text" id="username" class="form-control" name="username" placeholder="{{trans('placeholder.register.username')}}" value="{{ Input::old('username') }}">
                    @if ($errors->has('username')) <p class="help-block">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        {{$errors->first('username')}}
                    </div>
                </p>
                @endif
            </div>
            <div class="form-group @if ($errors->has('password')) has-error @endif">
                <label for="password">{{trans('labels.register.lbl_password')}}</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="{{trans('placeholder.register.password')}}" value="{{ Input::old('password') }}">
                @if ($errors->has('password')) <p class="help-block">
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    Password is required.
                </div>
            </p>
            @endif
        </div>
        <div class="form-group @if ($errors->has('fullname')) has-error @endif">
            <label for="fullname">{{trans('labels.register.lbl_fullname')}}</label>
            <input type="text" id="fullname" class="form-control" name="fullname" placeholder="{{trans('placeholder.register.fullname')}}" value="{{ Input::old('fullname') }}">
            @if ($errors->has('fullname')) <p class="help-block">
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                Full Name is required.
            </div>
        </p>
        @endif
    </div>
    <!-- <div class="form-group @if ($errors->has('position')) has-error @endif">
        <label for="position">{{trans('labels.register.lbl_position')}}</label>
        <input type="text" id="position" class="form-control" name="position" placeholder="{{trans('placeholder.register.position')}}" value="{{ Input::old('position') }}">
        @if ($errors->has('position')) <p class="help-block">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            {{trans('labels.register.lbl_position')}} is required.
        </div>
    </p>
    @endif
</div> -->
    <div class="form-group">
       <label for="privilege">{{trans('labels.register.lbl_privilege')}}</label>
       {{Form::select('position', $positions,null,array('class'=>'form-control'));}}
       @if ($errors->has('position')) <p class="help-block">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            {{trans('labels.register.lbl_position')}} is required.
        </div>
    </p>
    @endif
       <!-- <select name="privilege" class="form-control">
           <option disabled selected>{{trans('placeholder.register.privilege')}}</option>
           <option value="0" >{{trans('labels.register.lbl_hr')}}</option>
           <option value="1" >{{trans('labels.register.lbl_admin')}}</option>
       </select> -->
    </div>

</div>
<div class="panel-footer">
    {{ Form::submit('CREATE ACCOUNT', array('class' => 'btn btn-block btn-md btn-success','id' => 'submit')) }}
    {{ Form::close() }}
</div>
</div>
</div>
</div>
@stop