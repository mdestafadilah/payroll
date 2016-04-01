@extends('master')
@section('content')

    <script type="text/javascript">

    //Summary REPORT
    $(function() {

      $('input[name="dateRange"]').daterangepicker({
          autoUpdateInput: false,
          locale: {
              cancelLabel: 'Clear'
          }
      });

      $('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
      });

      $('input[name="dateRange"]').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });
    });  
   </script>



<div class="container" style="">
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





<div class="row" style="">
    <div class="col-lg-3">
        {{Form::open(array('url' => 'employees/'.Session::get('sess_selected_empid').'/stats/filter'))}}
        <div class="@if ($errors->has('searchforMonth')) has-error @endif">
            <div class="input-group">
                <input id="dateRange" name="dateRange" style="" type="text" class="form-control" placeholder="Search Date..." >
                <!-- <input type="text" class="form-control" placeholder="Search for..." name ="searchKeywordDate" id="searchKeywordDate"> -->
                <span class="input-group-btn">
                <button type="submit" class="btn btn-primary" type="button">Go!</button>
                </span>
            </div>
        {{Form::close()}}
        </div>
    </div>
  <div class="col-lg-3">

  </div>
</div>



<br/>
<div style="position: relative;">
    <div class="row">
        <div class="col-lg-4">
            <div class="btn-group" style="margin-bottom:10px;!important">
                <a class="btn btn-success" href="{{ URL::to('employees/'.Session::get('sess_selected_empid').'/stats/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{trans('labels.stats.lbl_create_att')}}</a>
                <a class="btn btn-primary" href="{{ URL::to('employees/'.Session::get('sess_selected_empid').'/stats/creates') }}"><span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> {{trans('labels.csv_import.lbl_title')}}</a>
            </div>
                
                    <div style="left: 953px; width: 200px; bottom: -15px; position: absolute; " class="btn btn-primary alert alert-info">
                        @if($employee->avatar == null)
                            <img src="{{URL::to('uploads/avatar.png')}}" width="60px" height="60px" class="img-circle">
                        @else
                            <img src="{{URL::to('uploads/')}}/{{$employee->avatar}}" width="60px" height="60px" class="img-circle"> 
                        @endif
                        <span class="label label-primary">{{ $employee->firstname }} {{ $employee->lastname }}</span>
                    </div>
                
        </div>
    </div>    
</div>


@if( ! empty($Periodmessage))
    {{Form::open(array('url' => 'employees/sumarryReports/filter/export-report-csv'))}}
        <div class="alert alert-info" style="position: relative;">
            <h3><span class="label label-primary" style="left: 6px; top: 12px; position: absolute;">
                <span class="glyphicon glyphicon-info-sign" ></span>
                @if( ! empty($Period))
                {{ $Periodmessage }}
            </span></h3>
            <input type="hidden" name ="SearchPeriod" id="SearchPeriod" value="{{ $Period }}">
            @endif
        </div>
    {{Form::close()}}
@endif

<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="">
            <tr class="tr-custom">
                <td>{{trans('labels.stats.lbl_date')}}</td>
                <td>{{trans('labels.stats.lbl_time_in')}}</td>
                <td>{{trans('labels.stats.lbl_time_out')}}</td>
                <td>{{trans('labels.stats.lbl_overtime')}}</td>
                <td>Late</td>
                <td>{{trans('labels.stats.lbl_total_hrs')}}</td>
                <td>{{trans('labels.lbl_action')}}</td>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td class="active">{{ $employee->attendance_date }}</td>
                <td class="active">{{ $employee->time_in }}</td>
                <td class="active">{{ $employee->time_out }}</td>
                <td class="active">{{ $employee->time_ot }}</td>
                <td class="active">{{ ($employee->time_late == 0?0:number_format($employee->time_late,2,'.','')) }}</td>
                <td class="active">{{ $employee->time_total }}</td>
                <td class="active">
                    <a class="btn btn-small btn-default" href="{{ URL::to('employees/'. $employee->time_id .'/stats/edit') }}"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a class="btn btn-small btn-danger" href="{{ URL::to('employees/'. $employee->time_id .'/stats/delete') }}" id="deleteA">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="btn-group">
    <a class="btn btn-success" href="{{ URL::to('employees/'. $employee->emp_id .'/stats/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{trans('labels.stats.lbl_create_att')}}</a>
    <a class="btn btn-primary" href="{{ URL::to('employees/'. $employee->emp_id .'/stats/creates') }}"><span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> {{trans('labels.csv_import.lbl_title')}}</a>
    </div>
    <br>
    <!--pagination-->
    {{$employees->links()}}
</div>
   
    @stop