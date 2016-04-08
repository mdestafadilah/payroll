@extends('master')
@section('content')
    <style>
         @media print 
        {
            @page{size: landscape;
        }
     
    </style>
    <script type="text/javascript">
        window.onload = function () {
            if (typeof history.pushState === "function") {
                history.pushState("jibberish", null, null);
                window.onpopstate = function () {
                    if (window.location.href=="address to check" == "")
                        window.location = "";
                } 
            }
            else {
                var ignoreHashChange = true;
                window.onhashchange = function () {
                    if (!ignoreHashChange) {
                        ignoreHashChange = true;
                        window.location.hash = Math.random();
                    }
                    else {
                        ignoreHashChange = false;   
                    }
                };
            }
        }

    $(function() {

      $('input[name="yearly"]').daterangepicker({
            //singleDatePicker: true,
            autoUpdateInput: false,
            locale: {
            cancelLabel: 'Clear'
          }
      });

      $('input[name="yearly"]').on('apply.daterangepicker', function(ev, picker) {

        var DateOnly = picker.startDate.format('-DD');
        var MonthOnly = picker.startDate.format('MMMM');

        var EndDate = picker.endDate.format('DD, YYYY');

        var MMM = MonthOnly.substring(0, 3); 
        var DateFormat = MMM + DateOnly + '-' + EndDate;

        $(this).val(DateFormat);
          //$(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
      });

      $('input[name="yearly"]').on('cancel.daterangepicker', function(ev, picker) {
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
        <div class=" pull-left"  style="padding:1px; width: 819px;">
            {{ Form::open(array('url' => 'employees/reports/filter'))}}
            {{ Form::select('coverage',$coverage, array('class' => 'form-control noprint','style' => 'margin-top:600px', 'id' => 'coverage')) }}
            {{ Form::submit('View', array('class' => 'btn  btn-xs btn-default noprint','name' => 'show','id' => 'show')) }}
            {{ Form::hidden('yrholder', $yrholder, array('id' => 'yrholder')) }}
            {{ Form::text('yearly','', array('class' => 'field', 'placeholder' => 'Search Date...', 'id' => 'yearly')) }}
            <!-- <input id="dateRange" name="dateRange" style="width: 170px;" type="text" class="form-control" placeholder="Search Date..." required > -->
            {{ Form::submit('Filter', array('class' => 'btn  btn-xs btn-default noprint','name' => 'filter','id' => 'filter')) }}
            {{ Form::close() }}
        </div>        
        <h3 class="" style="display:inline;"> {{trans('labels.payroll_reports.lbl_payroll_report')}} : {{Session::get('cover')}} </h3>
 
        <div class="panel panel-default ">
            <table class="table table-bordered table-condensed f11 table-nowrap">
                <thead class="">
                    <tr class="tr-custom">
                        <td class=" text-center">Employee Name</td>
                        <td class=" text-center">Basic Salary</td>
                        <td class=" text-center">Allowance</td>
                        <td class=" text-center">Monthly Salary</td>
                        <td class=" text-center">Half Month</td>
                        <td class=" text-center">Daily Rate Salary</td>
                        <td class=" text-center">Hourly Rate Salary</td>
                        <td class=" text-center">No. of Days Present</td>
                        <td class=" text-center">Employer Share SSS</td>
                        <td class=" text-center">SSS</td>
                        <td class=" text-center">Employer Share PhilHealth</td>
                        <td class=" text-center">PhilHealth</td>
                        <td class=" text-center">Employer Share Pagibig</td>
                        <td class=" text-center">Pagibig</td>
                        <td class=" text-center">Overtime Pay</td>
                        <td class=" text-center">WTax</td>
                        <td class=" text-center">Total Deduction</td>
                        <td class=" text-center">Final Pay</td>
                    </tr>
                </thead>
                <tbody>
                   <?php $tpay=$sssER=$phER=$piER=$sss1=$ph1=$pi1=0;?>
                   @foreach($employee as $value)
                   <tr>
                    <td class="active">{{{ucwords($value->firstname) . ' '. ucwords($value->lastname)}}}</td>
                    <td class="active">{{ $value->salary }}</td>
                    <td class="active">{{ $value->allowance }}</td>
                    <td class="active">{{$msal = $value->salary + $value->allowance }}</td>
                    <td class="active">{{number_format($msal /2,2 ,'.',','); $sal = $msal/2}}</td>
                    <td class="active">{{number_format($dRate = ($msal*12)/261,2,'.',',')}}</td>
                    <td class="active">{{number_format($dRate/8,2,'.',',') }}</td>
                    <td class="active">{{number_format($days = $value->days,2,'.',',')}}</td>
                    <td class="active" style="background-color: #fbf069">{{$value->sssER/2 }}</td> <?php $sssER =$sssER + $value->sssER/2; ?>
                    <td class="active">{{number_format($sss =$value->sssContrib,2,'.',',') }}</td><?php $sss1 =$sss1 + $value->sssContrib; ?>
                    <td class="active" style="background-color: #fbf069">{{ $value->phER/2 }}</td> <?php $phER= $phER+ $value->phER/2 ?>
                    <td class="active">{{number_format($ph = $value->philHealthContrib,2,'.',',');}}</td><?php $ph1= $ph1+ $value->philHealthContrib; ?>
                    <td class="active" style="background-color: #fbf069">{{ $value->piER/2 }}</td> <?php $piER = $piER + $value->piER/2 ?>
                    <td class="active">{{number_format($pI= $value->pagibigContrib,2,'.',',') }}</td><?php $pi1 = $pi1 + $value->pagibigContrib ?>
                    <td class="active">{{$ot =$value->ot; number_format($value->ot,2,'.',',') }}</td>
                    <td class="active">{{$tax = $value->w_tax;number_format($value->w_tax,2,'.',',')}}</td>
                    <td class="active">{{number_format($value->deduction,2,'.',',') }}</td>
                    <td class="active">{{  number_format($fpay = $value->netpay,2,'.',',')}}</td>
                    <?php  $tpay = $tpay + $fpay;?>
                </tr>
                @endforeach
                <tr>
                    @for($i =1;$i<17;$i++)
                    @if($i==9)
                    <td class="active">{{number_format($sssER,2,'.',',')}}</td>
                    @elseif($i==10)
                    <td class="active">{{number_format($sss1,2,'.',',')}}</td>
                    @elseif($i==11)
                    <td class="active">{{number_format($phER,2,'.',',')}}</td>
                    @elseif($i==12)
                    <td class="active">{{number_format($ph1,2,'.',',')}}</td>
                    @elseif($i==13)
                    <td class="active">{{number_format($piER,2,'.',',')}}</td>
                    @elseif($i==14)
                    <td class="active">{{number_format($pi1,2,'.',',')}}</td>
                    @else
                    <td class="active"></td>
                    @endif
                    @endfor
                    <td class="active">Total: </td>
                    <td  class="active">{{number_format($tpay,2,'.',',')}}</td></tr>
                </tbody>
            </table>
        </div>
        <div class="btn-group">
          {{ Form::open(array('url' => 'employees/reports/batch_print','target' => '_blank'))}}
          <button type="button" class="btn btn-success noprint " onclick="javascript:window.print()"><span class="glyphicon glyphicon-print"></span> Print Report</button>
          <button type="submit" class="btn btn-success noprint " ><span class="glyphicon glyphicon-print"></span> Print Payslip</button>
          {{ Form::close() }}
      </div>
  </div>
</div>
@stop
