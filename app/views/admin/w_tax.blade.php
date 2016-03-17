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
    {{ Form::open(array('url' => 'employees/tax/create')) }}
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
            <div class="panel panel-default panel-danger">
                <div class="panel-heading ">
                    <h3 class="panel-title">{{trans('labels.w_tax.lbl_title')}}</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group @if ($errors->has('status')) has-error @endif">
                        <label for="old password">{{trans('labels.tax.lbl_status')}}</label>
                        <input type="text" id="status" class="form-control" name="status" placeholder="Enter Status" value="{{ Input::old('status') }}">
                        @if ($errors->has('status')) <p class="help-block">
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            Status is required!
                        </div>
                    </p>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('basis')) has-error @endif">
                    <label for="basis">{{trans('labels.tax.lbl_income')}}</label>
                    <input type="basis" id="basis" class="form-control" name="basis" placeholder="Enter Income Amount" value="{{ Input::old('basis') }}">
                    @if ($errors->has('basis')) <p class="help-block">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        Income Amount Basis is required!
                    </div>
                </p>
                @endif
            </div>
            <div class="form-group @if ($errors->has('excess')) has-error @endif">
                <label for="excess">{{trans('latest.tax.lbl_diff')}}</label>
                <input type="text" id="excess" class="form-control" name="excess" placeholder="Enter added difference" value="{{ Input::old('excess') }}">
                @if ($errors->has('excess')) <p class="help-block">
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    Added Differences is required!
                </div>
            </p>
            @endif
        </div>
        <div class="form-group @if ($errors->has('excemption')) has-error @endif">
            <label for="excemption">{{trans('labels.tax.lbl_tax_payable')}}</label>
            <input type="text" id="excemption" class="form-control" name="excemption" placeholder="Enter tax" value="{{ Input::old('excemption') }}">
            @if ($errors->has('excemption')) <p class="help-block">
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                Tax is required!
            </div>
        </p>
        @endif
    </div>
{{ Form::submit('SUBMIT', array('class' => 'btn col-sm-5 btn-md btn-success','style'=>'margin-left:40px','id' => 'submit')) }}
<a href="{{URL::to('employees/tax')}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left: 10px">{{trans('labels.lbl_cancel')}}</a>
</div>
</div>
</div>
</div>
@stop