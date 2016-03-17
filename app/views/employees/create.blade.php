@extends('master')
@section('content')

    <script type="text/javascript">

        $(document).ready(function() {

            //Create Blade
/*            $('#birthdate').datepicker({
                format: "yyyy/mm/dd",
                clearBtn: true,
                orientation: "bottom auto"
            });
            $('#hireddate').datepicker({
                format: "yyyy/mm/dd",
                clearBtn: true,
                orientation: "bottom auto"
            });*/

            $('#birthdate').datetimepicker({
                format: "Y/m/d",
                clearBtn: true,
                orientation: "top auto",
                timepicker:false
            });

            $('#hireddate').datetimepicker({
                format: "Y/m/d",
                clearBtn: true,
                orientation: "top auto",
                timepicker:false
            });        
        });    

        $(document).on('click', '#submit', offBeforeUnload);
        function offBeforeUnload(event) {
            $(window).off('beforeunload');
        }

        function windowBeforeUnload() {
            return "Data will be lost if you leave the page.";
        }

       $(document).ready(function(){
        $('#firstname').focus();
            $(":input").focusout(function () {
                if ($(this).val()) {
                    $(window).on('beforeunload', windowBeforeUnload);
                }
            });
        });
   </script>

    <div class="container" style="">
        {{ Form::open(array('url' => 'employees')) }}
        <div class="row centered-form">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
                <div class="panel panel-default panel-danger">
                    <div class="panel-heading ">
                        <h3 class="panel-title">{{trans('labels.master.lbl_create_employee')}}</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group @if ($errors->has('firstname')) has-error @endif">
                            <label for="firstname">{{trans('labels.show.lbl_firstname')}}</label>
                            <input type="text" id="firstname" class="form-control" name="firstname" placeholder="{{trans('placeholder.create.firstname')}}" value="{{ Input::old('firstname') }}">
                            @if ($errors->has('firstname')) <p class="help-block">
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                First Name field is required
                            </div>
                        </p>
                        @endif
                    </div>
                <div class="form-group @if ($errors->has('lastname')) has-error @endif">
                        <label for="lastname">{{trans('labels.show.lbl_lastname')}}</label>
                        <input type="text" id="lastname" class="form-control" name="lastname" placeholder="{{trans('placeholder.create.lastname')}}" value="{{ Input::old('lastname') }}">
                        @if ($errors->has('lastname')) <p class="help-block">
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            Last Name field is required
                        </div>
                    </p>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('gender', 'Gender') }}
                    {{ Form::select('gender', array('M' => 'Male', 'F' => 'Female'), Input::old('gender'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group @if ($errors->has('birthdate')) has-error @endif">
                    <label for="birthdate">{{trans('labels.show.lbl_bdate')}}</label><br/>
                    {{ Form::text('birthdate', null, array('type' => 'text', 'class' => 'form-control datepicker','placeholder' => 'Pick the date this task should be completed', 'id' => 'birthdate')) }}
                    @if ($errors->has('birthdate')) <p class="help-block">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        Birth Date field is required
                    </div>
                </p>
                @endif
            </div>
            <div class="form-group @if ($errors->has('homeaddress')) has-error @endif">
                <label for="homeaddress">{{trans('labels.show.lbl_home_addr')}}</label>
                <input type="text" id="homeaddress" class="form-control" name="homeaddress" placeholder="{{trans('placeholder.create.home_addr')}}" value="{{ Input::old('homeaddress') }}">
                @if ($errors->has('homeaddress')) <p class="help-block">
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    Home Address field is required
                </div>
            </p>
            @endif
        </div>
        <div class="form-group @if ($errors->has('contactno')) has-error @endif">
            <label for="contactno">{{trans('labels.show.lbl_cnt_no')}}</label>
            <input type="text" id="contactno" class="form-control" name="contactno" placeholder="{{trans('placeholder.create.contact_no')}}" value="{{ Input::old('contactno') }}">
            @if ($errors->has('contactno')) <p class="help-block">
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                Contact Number field is required
            </div>
        </p>
        @endif
    </div>
    <div class="form-group @if ($errors->has('email')) has-error @endif">
        <label for="email">{{trans('labels.show.lbl_email_addr')}}</label>
        <input type="text" id="email" class="form-control" name="email" placeholder="{{trans('placeholder.create.email_addr')}}" value="{{ Input::old('email') }}">
        @if ($errors->has('email')) <p class="help-block">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            Email Address field is required
        </div>
    </p>
    @endif
</div>
<div class="form-group @if ($errors->has('position')) has-error @endif">
    <label for="position">{{trans('labels.show.lbl_position')}}</label>
    <input type="text" id="position" class="form-control" name="position" placeholder="{{trans('placeholder.create.position')}}" value="{{ Input::old('position') }}">
    @if ($errors->has('position')) <p class="help-block">
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        Position field is required
    </div>
</p>
@endif
</div>
<div class="form-group @if ($errors->has('hired_date')) has-error @endif">
    <label for="hired_date">{{trans('labels.show.lbl_hired_date')}}</label><br/>
    {{ Form::text('hired_date', null, array('type' => 'text', 'class' => 'form-control datepicker','placeholder' => 'Pick the date this task should be completed', 'id' => 'hireddate')) }}
    @if ($errors->has('hired_date')) <p class="help-block">
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        Hired Date field is required
    </div>
</p>
@endif
</div>
<div class="form-group @if ($errors->has('sss_no')) has-error @endif">
    <label for="sss_no">{{trans('labels.show.lbl_sss_no')}}</label>
    <input type="text" id="sss_no" class="form-control" name="sss_no" placeholder="{{trans('placeholder.create.sss')}}" value="{{ Input::old('sss_no') }}">

    @if ($errors->has('sss_no')) <p class="help-block">
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        SSS Number field is required
    </div> 
</p>
@endif
</div>
<div class="form-group @if ($errors->has('ph_no')) has-error @endif">
    <label for="ph_no">{{trans('labels.show.lbl_phlH_no')}}</label>
    <input type="text" id="ph_no" class="form-control" name="ph_no" placeholder="{{trans('placeholder.create.philhealth')}}" value="{{ Input::old('ph_no') }}">
    @if ($errors->has('ph_no')) <p class="help-block">
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        PhilHealth Number field is required
    </div>
</p>
@endif
</div>
<div class="form-group @if ($errors->has('pi_no')) has-error @endif">
    <label for="pi_no">{{trans('labels.show.lbl_pagibig_no')}}</label>
    <input type="text" id="pi_no" class="form-control" name="pi_no" placeholder="{{trans('placeholder.create.pagibig')}}" value="{{ Input::old('pi_no') }}">
    @if ($errors->has('pi_no')) <p class="help-block">
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        Pag-ibig Mumber field is required
    </div>
</p>
@endif
</div>
</div>
<div class="panel-footer">
    {{ Form::submit('CREATE EMPLOYEE', array('class' => 'btn btn-block btn-md btn-success', 'id'=>'submit')) }}
    {{ Form::close() }}
</div>
</div>
</div>
</div>
</div>
@stop