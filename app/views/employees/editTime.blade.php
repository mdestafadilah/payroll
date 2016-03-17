@extends('master')
@section('content')

    <script type="text/javascript">
        $(document).ready(function() {
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
        {{ Form::open(array('url' => 'employees/'.$employee->time_id.'/stats/edit')) }}
        <div class="row centered-form">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
                <div class="panel panel-default panel-danger">
                    <div class="panel-heading ">

                        <h3 class="panel-title">{{trans('labels.attendance.lbl_time_log')}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group @if ($errors->has('attendance')) has-error @endif">
                            <label for="attendance">{{trans('labels.attendance.lbl_date')}}</label>
                            <input type="text" id="attendance" class="form-control" name="attendance" placeholder="{{trans('placeholder.attendance.date')}}" value="{{$employee->attendance_date}}">
                            @if ($errors->has('attendance')) <p class="help-block">Date field is required!</p> @endif
                        </div>
                        <div class="form-group @if ($errors->has('timeIn')) has-error @endif">
                            <label for="timeIn">{{trans('labels.attendance.lbl_time_in')}}</label>
                            <input type="text" id="timeIn" class="form-control" name="timeIn" placeholder="{{trans('placeholder.attendance.time_in')}}" value="{{$employee->time_in}}">
                            @if ($errors->has('timeIn')) <p class="help-block">Time In field is required!</p> @endif
                        </div>
                        <div class="form-group @if ($errors->has('timeOut')) has-error @endif">
                            <label for="timeOut">{{trans('labels.attendance.lbl_time_out')}}</label>
                            <input type="text" id="timeOut" class="form-control" name="timeOut" placeholder="{{trans('placeholder.attendance.time_out')}}" value="{{$employee->time_out}}">
                            @if ($errors->has('timeOut')) <p class="help-block">Time Out field is required!</p> @endif
                        </div>

                        <label for="holidayType" style="display: block;"><strong>{{trans('labels.attendance.lbl_holiday_type')}}</strong></label>

                         <div class="radio">
                          <label>
                            <input type="radio" name="holidayType" value="0" <?php if($employee->day_type=="0"){echo "checked";} ?>/>
                            {{trans('labels.attendance.lbl_non_holiday')}}
                          </label>
                        </div>

                        <div class="radio">
                          <label>
                            <input type="radio" name="holidayType" value="1" <?php if($employee->day_type=="1"){echo "checked";} ?>/>
                            {{trans('labels.attendance.lbl_regular_holiday')}}
                          </label>
                        </div>

                        <div class="radio">
                          <label>
                            <input type="radio" name="holidayType" value="2" <?php if($employee->day_type=="2"){echo "checked";} ?>/>
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
                            <input type="radio" name="acceptedLate" value="1" @if($employee->time_in >9 && $employee->time_late == 0) checked @endif/>
                            {{trans('labels.attendance.lbl_ok')}}
                          </label>

                        </div>

                        {{ Form::submit('Submit', array('class' => 'btn col-sm-5 btn-md btn-success','style'=>'margin-left:35px;')) }}
                        <a href="{{URL::to('employees/'.$employee->emp_id.'/stats')}}" class="btn col-sm-5 btn-md btn-danger" style="margin-left: 20px;">{{trans('labels.lbl_cancel')}}</a>
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>
@stop