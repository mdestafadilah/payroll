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

{{ Form::model($employee, array('action' => array('EmployeeController@update', $employee->emp_id), 'method' => 'PUT')) }}
<div class="row centered-form">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
        <div class="panel panel-default panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">{{trans('labels.edit.lbl_title')}}</h3>
            </div>
            <div class="panel-body">
                <div class="form-group @if ($errors->has('firstname')) has-error @endif">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" class="form-control" name="firstname" placeholder="Enter Employee First Name" value="{{ $employee->firstname }}">
                    @if ($errors->has('firstname')) <p class="help-block">The First Name field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('lastname')) has-error @endif">
                    <label for="lastname">{{trans('labels.show.lbl_lastname')}}</label>
                    <input type="text" id="lastname" class="form-control" name="lastname" placeholder="Enter Employee Last Name" value="{{ $employee->lastname }}">
                    @if ($errors->has('lastname')) <p class="help-block">The Last Name field is required.</p> @endif
                </div>
                <div class="form-group">
                    {{ Form::label('gender', 'Gender') }}
                    {{ Form::select('gender', array('M' => 'Male', 'F' => 'Female'), Input::old('gender'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group @if ($errors->has('birthdate')) has-error @endif">
                    <label for="birthdate">Birth Date</label><br/>
                    {{ Form::text('birthdate', null, array('type' => 'text', 'class' => 'form-control datepicker','placeholder' => 'Pick the date this task should be completed', 'id' => 'birthdate')) }}
                    @if ($errors->has('birthdate')) <p class="help-block">The Birth Date field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('homeaddress')) has-error @endif">
                    <label for="homeaddress">Home Address</label>
                    <input type="text" id="homeaddress" class="form-control" name="homeaddress" placeholder="Enter Employee Home Address" value="{{ $employee->homeaddress }}">
                    @if ($errors->has('homeaddress')) <p class="help-block">The Home Address field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('contactno')) has-error @endif">
                    <label for="contactno">Contact Number</label>
                    <input type="text" id="contactno" class="form-control" name="contactno" placeholder="Enter Employee Contact Number" value="{{ $employee->contactno }}">
                    @if ($errors->has('contactno')) <p class="help-block">The Contact Number field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('email')) has-error @endif">
                    <label for="email">Email Address</label>
                    <input type="text" id="email" class="form-control" name="email" placeholder="Enter Employee Email Address" value="{{ $employee->email }}">
                    @if ($errors->has('email')) <p class="help-block">The Email Address field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('position')) has-error @endif">
                    <label for="position">Position</label>
                    <input type="text" id="position" class="form-control" name="position" placeholder="Enter Employee Email Address" value="{{ $employee->position }}">
                    @if ($errors->has('position')) <p class="help-block">The Position field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('hired_date')) has-error @endif">
                    <label for="hired_date">Hired Date</label><br/>
                    {{ Form::text('hired_date', null, array('type' => 'text', 'class' => 'form-control datepicker','placeholder' => 'Pick the date this task should be completed', 'id' => 'hireddate')) }}
                    @if ($errors->has('hired_date')) <p class="help-block">The Hired Date field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('sss_no')) has-error @endif">
                    <label for="sss_no">SSS Number</label>
                    <input type="text" id="sss_no" class="form-control" name="sss_no" placeholder="Enter Employee SSS No." value="{{ $employee->sss_no }}">
                    @if ($errors->has('sss_no')) <p class="help-block">The SSS Number field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('ph_no')) has-error @endif">
                    <label for="ph_no">Philihealth Number</label>
                    <input type="text" id="ph_no" class="form-control" name="ph_no" placeholder="Enter Employee PhilHealth No." value="{{ $employee->ph_no }}">
                    @if ($errors->has('ph_no')) <p class="help-block">The PhilHealth Number field is required.</p> @endif
                </div>
                <div class="form-group @if ($errors->has('pi_no')) has-error @endif">
                    <label for="pi_no">Pag-ibig Number</label>
                    <input type="text" id="pi_no" class="form-control" name="pi_no" placeholder="Enter Employee Pag-ibig No." value="{{ $employee->pi_no }}">
                    @if ($errors->has('pi_no')) <p class="help-block">The Pag-Ibig Number field is required.</p> @endif
                </div>
                {{ Form::submit('UPDATE', array('class' => 'btn col-sm-5 btn-md btn-success','style'=>'margin-left:40px;')) }}
                <a href="{{URL::to('employees')}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left:10px;">CANCEL</a>
                {{ Form::close() }}
            </div>   
        </div>
    </div>
</div>
@stop
