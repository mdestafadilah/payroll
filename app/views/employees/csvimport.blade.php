@extends('master')
@section('content')
@if (Session::has('message'))
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
<div class="row centered-form">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
        <div class="panel panel-default panel-danger">
            <div class="panel-heading ">
                <h3 class="panel-title">{{trans('labels.csv_import.lbl_title')}}</h3>
            </div>
            {{ Form::open(array('url' => 'employees/'. $employee->emp_id .'/stats/creates', 'files' => true)) }}
            <div class="panel-body">
                <div class="form-group  @if ($errors->has('csv')) has-error @endif">
                    {{ Form::label('avatar', 'Avatar',array('class' => 'sr-only')) }}
                    <div style="position:relative;">
                       <input type="file" class="filestyle" name="csv" id="csv" accept=".csv" data-input="true" >
                       @if ($errors->has('csv')) <p class="help-block">
                       <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        Attachment is required
                    </div>
                </p>
                @endif
            </div>
            <div class="centered-form">
                {{Form::submit('Submit',array('class' => 'btn col-sm-5 btn-md btn-success', 'style'=>'margin-left:30px;'))}}

                <a href="{{URL::to('employees/'.$employee->emp_id.'/stats')}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left:10px;">CANCEL</a>
            </div>
        </div>

    </div>
    {{Form::close()}}
</div>
</div>
</div>
@stop
