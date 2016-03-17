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
{{ Form::open(array('url' => 'employees/'.$employee->emp_id.'/contribution/')) }}
<div class="row centered-form">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
        <div class="panel panel-default panel-danger">
            <div class="panel-heading ">
               <h3 class="panel-title">{{trans('labels.contribution.lbl_emp_rate')}}</h3>
           </div>
           <div class="panel-body">
               <label for="sss">{{trans('labels.contribution.lbl_sss_cont')}}</label>
               <div class="input-group @if ($errors->has('sss')) has-error @endif">
                <span class="input-group-addon">₱</span>
                <input type="text" id="sss" class="form-control" name="sss" placeholder="" value="{{$employee->sss_tax}}">
            </div>
            @if ($errors->has('sss')) <p class="help-block">
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                SSS field is required
            </div>
        </p>
        @endif
        <label for="philhealth">{{trans('labels.contribution.lbl_philH_cont')}}</label>
        <div class="input-group @if ($errors->has('philhealth')) has-error @endif">
            <span class="input-group-addon">₱</span>
            <input type="text" id="philhealth" class="form-control" name="philhealth" placeholder="" value="{{$employee->philhealth_tax}}">

        </div>
        @if ($errors->has('philhealth')) <p class="help-block">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            PhilHealth field is required
        </div>
    </p>
    @endif
    <label for="pagibig">{{trans('labels.contribution.lbl_pagibi_cont')}}</label>
    <div class="input-group @if ($errors->has('pagibig')) has-error @endif">
        <span class="input-group-addon">₱</span>
        <input type="text" id="pagibig" class="form-control" name="pagibig" placeholder="" value="{{$employee->pagibig_tax}}">
    </div>
    @if ($errors->has('pagibig')) <p class="help-block">
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        Pag-ibig field is required
    </div>
</p>
@endif
<label for="salary">{{trans('labels.contribution.lbl_basic_salary')}}</label>
<div class="input-group @if ($errors->has('salary')) has-error @endif">
    <span class="input-group-addon">₱</span>
    <input type="text" id="salary" class="form-control" name="salary" placeholder="" value="{{$employee->salary}}">
</div>
@if ($errors->has('salary')) <p class="help-block">
<div class="alert alert-danger" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
    Salary field is required
</div>
</p>
@endif
<label for="salary">{{trans('labels.contribution.lbl_allowance')}}</label>
<div class="input-group @if ($errors->has('allowance')) has-error @endif">
    <span class="input-group-addon">₱</span>
    <input type="text" id="allowance" class="form-control" name="allowance" placeholder="" value="{{$employee->allowance}}">
</div>
@if ($errors->has('allowance')) <p class="help-block">
<div class="alert alert-danger" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
    Allowance field is required
</div>
</p>
@endif
<label for="rate">Rate</label>
<div class="input-group @if ($errors->has('rate')) has-error @endif">
    <span class="input-group-addon">₱</span>
    <input type="text" id="rate" class="form-control" name="rate" placeholder="" value="{{$employee->rate}}" disabled="">
</div>
@if ($errors->has('rate')) <p class="help-block">
<div class="alert alert-danger" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
    Rate field is required
</div>
</p>
@endif
<br/>
{{ Form::submit('SUBMIT', array('class' => 'btn col-md-5 btn-md btn-success','style'=>'margin-left:40px;')) }}
<a href="{{URL::to('employees/'.$employee->emp_id)}}" class="btn col-md-5 btn-md btn-danger" style="margin-left: 10px">CANCEL</a>
{{ Form::close() }}
</div>
</div>
</div>
</div>
@stop