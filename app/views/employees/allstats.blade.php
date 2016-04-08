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
    {{Form::open(array('url' => 'employees/sumarryReports/filter'))}}
      <div class="@if ($errors->has('searchforMonth')) has-error @endif">
        <div class="input-group">
          <input id="dateRange" name="dateRange" style="" type="text" class="form-control" placeholder="Search Date..." required >
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary" type="button">Go!</button>
          </span>
        </div>
      </div> 
    {{Form::close()}}

  </div>

  <div class="col-lg-3">
  </div>

  </div>


<br/>
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
            
            <button type="submit" style="left: 1025px; top: 8px; position: absolute;" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-download-alt"></span> EXPORT CSV</button>
        </div>
    {{Form::close()}}
@endif

<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <thead class="">
            <tr class="tr-custom">
                <td style="width: 280px;">{{trans('labels.stats.lbl_name')}}</td>
                <td style="width: 280px;">TOTAL {{trans('labels.stats.lbl_overtime')}}</td>
                <td style="width: 280px;">TOTAL LATE</td>
                <td>{{trans('labels.stats.lbl_total_hrs')}}</td>
            </tr>
        </thead>
        
        <tbody style="height: 450px; width: 1140px; overflow-y: scroll; position: absolute;">
    
            @foreach($employeequerytoallstat as $info)
            <tr style="width: 100%; display: inline-table; table-layout: fixed;">
                <td class="active">       
                    @if($info->avatar == null)
                        <img src="{{URL::to('uploads/avatar.png')}}" width="60px" height="60px" class="img-circle">
                    @else
                        <img src="{{URL::to('uploads/')}}/{{$info->avatar}}" width="60px" height="60px" class="img-circle"> 
                    @endif
                      @if($info->time_ot == null and $info->time_late == null and $info->time_total == null)
                        {{{$info->firstname}}} {{{$info->lastname}}}
                      @else
                        <a href="{{ URL::to('employees/'.$info->emp_id.'/sumarryReports/filter/singleview?testdate='.$Period) }}">{{{$info->firstname}}} {{{$info->lastname}}} </a>
                      @endif
                </td>

                <td class="active">{{ round($info->time_ot, 2) }}</td>
                <td class="active">{{ round($info->time_late, 2) }}</td>
                <td class="active">{{ round($info->time_total, 2) }}</td>
                
            </tr>
            @endforeach
     
        </tbody>
        
        </table>
    </div>

    <br>
    <!--pagination-->

   
    @stop 