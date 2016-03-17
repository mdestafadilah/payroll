@extends('master')
@section('content')
@if (Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
    {{ Session::get('message') }}
</div>
@endif
{{ Form::open(array('url' => 'employees/'.$employee->emp_id.'/erc/')) }}
<div class="row centered-form">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
        <div class="panel panel-default panel-danger">
            <div class="panel-heading ">

             <h3 class="panel-title">{{trans('labels.erContrib.lbl_title')}}</h3>
         </div>
         <div class="panel-body">

            <label for="sss">{{trans('labels.erContrib.lbl_sss')}}</label>
            <div class="input-group @if ($errors->has('sss')) has-error @endif">
                <span class="input-group-addon">₱</span>
                <input type="text" id="sss" class="form-control" name="sss" placeholder="" value="{{$employee->sssERC}}">
            </div>
            @if ($errors->has('sss')) <p class="help-block">
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                {{$errors->first('sss')}}
            </div>
        </p>
        @endif
        <label for="philhealth">{{trans('labels.erContrib.lbl_philH')}}</label>
        <div class="input-group @if ($errors->has('philhealth')) has-error @endif">
            <span class="input-group-addon">₱</span>
            <input type="text" id="philhealth" class="form-control" name="philhealth" placeholder="" value="{{$employee->philHealthERC}}">

        </div>
        @if ($errors->has('philhealth')) <p class="help-block">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>{{$errors->first('philhealth')}}
        </div>
    </p>
    @endif
    <label for="pagibig">{{trans('labels.erContrib.lbl_pagibig')}}</label>
    <div class="input-group @if ($errors->has('pagibig')) has-error @endif">
        <span class="input-group-addon">₱</span>
        <input type="text" id="pagibig" class="form-control" name="pagibig" placeholder="" value="{{$employee->pagibigERC}}">
    </div>
    @if ($errors->has('pagibig')) <p class="help-block">
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        {{$errors->first('pagibig')}}
    </div>
</p>
@endif
<br/>
{{ Form::submit('SUBMIT', array('class' => 'btn col-sm-5 btn-md btn-success','style'=>'margin-left:40px;')) }}
<a href="{{URL::to('employees/'.$employee->emp_id)}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left: 10px;">{{trans('labels.lbl_cancel')}}</a>
{{ Form::close() }}
</div>
</div>
</div>
</div>
@stop
