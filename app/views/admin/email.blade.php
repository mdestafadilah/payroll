@extends('master')
@section('content')
@if (Session::has('message'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
    {{ Session::get('message') }}
</div>
@endif
{{ Form::open(array('url' => 'admin/mail/' .$req->req_id, 'files' => true)) }}
<div class="row centered-form">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
        <div class="panel panel-default panel-danger">
            <div class="panel-heading ">
                <h3 class="panel-title">EMAIL </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="email">TO:</label>
                    <input type="text" id="email" class="form-control" name="email" placeholder="Enter Email" value="{{ $req->employee->email }}">
                    @if ($errors->has('email')) <p class="help-block">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        Email Address field is required
                    </div>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="subject">SUBJECT:</label>
                <input type="text" id="subject" class="form-control" name="subject" placeholder="Enter Subject" value="Payslip">
                @if ($errors->has('subject')) <p class="help-block">
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    Subject field is required
                </div>
            </p>
            @endif
        </div>
        <div class="form-group " >
            <label for="msg">Message</label>
            <textarea class="form-control" rows="5" name="msg" id="msg" placeholder="Message" style="resize: none"></textarea>
            @if ($errors->has('msg')) <p class="help-block">
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                Message field is required
            </div>
        </p>
        @endif
    </div>
    <div class="form-group">
        <div style="position:relative;">
         <input type="file" class="filestyle" name="payroll_file" id="payroll_file" data-input="true" >
         @if ($errors->has('payroll_file')) <p class="help-block">
         <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            Attachment is required
        </div>
    </p>
    @endif
</div>
</div>
<div class="panel-footer">
    {{ Form::submit('SEND', array('class' => 'btn col-sm-5 btn-md btn-success','style'=>'margin-left:30px;')) }}
    <a href="{{URL::to('employees/request')}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left:10px;">CANCEL</a>
</div>
</div>
</div>
</div>
</div>
{{Form::close()}}
@stop