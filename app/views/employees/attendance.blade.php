@extends('master')
@section('content')

    <script type="text/javascript">

    $(document).ready(function() {
        //Attendance Blade

            $('#attendance').datetimepicker({
                format: "y/m/d",
                clearBtn: true,
                orientation: "top auto",
                timepicker:false
            });
            $('#timeIn').datetimepicker({
                format: "H:i",
                clearBtn: true,
                orientation: "top auto",
                allowTimes: ['9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00',
                '17:00','18:00','19:00','20:00','21:00'],
                datepicker:false
            });
            $('#timeOut').datetimepicker({
                format: "H:i",
                clearBtn: true,
                orientation: "top auto",
                allowTimes: ['9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00',
                '17:00','18:00','19:00','20:00','21:00'],
                datepicker:false
            });

    });
   </script>

    <div class="container" style="width:850px; !important">
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
        {{ Form::open(array('url' => 'employees/'.$employees->emp_id.'/stats/create')) }}
        <div class="row centered-form">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
                <div class="panel panel-default panel-danger">
                    <div class="panel-heading ">
                        <h3 class="panel-title">{{trans('labels.attendance.lbl_time_log')}}</h3>
                    </div>
                    <div class="panel-body">
                        <input class="hidden" id="empid" name="empid" value="<?php echo $employees->emp_id ?>"/>
                        <div class="form-group @if ($errors->has('attendance')) has-error @endif">
                            <label for="attendance">{{trans('labels.attendance.lbl_date')}}</label>
                            {{ Form::text('attendance', null, array('type' => 'text', 'class' => 'form-control datepicker','placeholder' => 'Pick the date this task should be completed', 'id' => 'attendance')) }}
                            @if ($errors->has('attendance')) <p class="help-block">
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                Date field is required!
                            </div>
                        </p>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('timeIn')) has-error @endif">
                        <label for="timeIn">{{trans('labels.attendance.lbl_time_in')}}</label>
                        <input type="text" id="timeIn" class="form-control" name="timeIn" placeholder="{{trans('placeholder.attendance.time_in')}}" value="{{ Input::old('timeIn') }}">
                        @if ($errors->has('timeIn')) <p class="help-block">
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            Time In field is required!
                        </div>
                    </p>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('timeOut')) has-error @endif">
                    <label for="timeOut">{{trans('labels.attendance.lbl_time_out')}}</label>
                    <input type="text" id="timeOut" class="form-control" name="timeOut" placeholder="{{trans('placeholder.attendance.time_out')}}" value="{{ Input::old('timeOut') }}">
                    @if ($errors->has('timeOut')) <p class="help-block">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        Time Out field is required!
                    </div>
                </p>
                @endif
            </div>
            
            <label for="holidayType" style="display: block;"><strong>{{trans('labels.attendance.lbl_holiday_type')}}</strong></label>

            <div class="radio">
              <label>
                <input type="radio" name="holidayType" value="0" checked>
                {{trans('labels.attendance.lbl_non_holiday')}}
              </label>
            </div>

            <div class="radio">
              <label>
                <input type="radio" name="holidayType" value="1">
                {{trans('labels.attendance.lbl_regular_holiday')}}
              </label>
            </div>

            <div class="radio">
              <label>
                <input type="radio" name="holidayType" value="2">
                {{trans('labels.attendance.lbl_special_nw_holiday')}}
              </label>
            </div>

            
                <label for="acceptedLate" style="display: block;"><strong>{{trans('labels.attendance.lbl_accepted_late')}}</strong></label>

            <div class="radio">
              <label>
                <input type="radio" name="acceptedLate" value="0" checked>
               {{trans('labels.attendance.lbl_not_ok')}}
              </label>
            </div>
             <div class="radio">
              <label>
                <input type="radio" name="acceptedLate" value="1">
                {{trans('labels.attendance.lbl_ok')}}
              </label>
            </div>
            
            <div style="margin-top:20px;!important">
                <a class="btn col-sm-3 btn-md btn-primary" href="{{ URL::to('employees/'. $employees->emp_id .'/stats/creates') }}">{{trans('labels.csv_import.lbl_title')}}</a>
                {{ Form::submit('SUBMIT', array('class' => 'btn col-sm-3 btn-md btn-success','style'=>'margin-left:10px;')) }}
                <a @if(Session::has('flg')) href="{{URL::to('employees/'.$employees->emp_id)}}"
                @else  href="{{URL::to('employees/'.$employees->emp_id.'/stats')}}"
                @endif
                class="btn col-sm-3 btn-md btn-danger" style="margin-left:10px;">{{trans('labels.lbl_cancel')}}</a>
                {{ Form::close() }}
            </div>  

    </div>
</div>
</div>
</div>
@stop