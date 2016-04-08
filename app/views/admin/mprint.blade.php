@extends('master')
@section('content')
    <div class="row" >
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
            {{--@for($i =0;$i<6;$i++)--}}
            @foreach($employees as $emp)
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title span2">Ring System Development Inc.</h3>
                </div>
                <div class="panel-body">
                    <div class="row" id="mydiv">
                        <h3 style="text-align:center;">{{trans('labels.iPayslip.lbl_title')}}</h3>
                      {{--  <div class="text-center"><p>Covers: {{$coverage}}</p></div>--}}
                        <table class="table table-user-information">
                            <thead>
                            <td class="upp" colspan="2" style="padding:0px; text-align: center"><h4>Employee</h4></td>
                            <td  class="upp" colspan="2" style="padding:0px;  text-align: center"><h4>Contributions</h4></td>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="style1">Name:</td>
                                <td class="style2">{{{ucwords($emp->firstname) . ' '. ucwords($emp->lastname)}}} </td>
                                <td class="style1">SSS:</td>
                                <td class="style2">{{number_format($emp->sssContrib,2,'.',',')}}</td>
                            </tr>
                            <tr>
                                <td class="style1">Position:</td>
                                <td class="style2">{{ucwords($emp->position)}}</td>
                                <td class="style1">Pagibig:</td>
                                <td>{{number_format($emp->pagibigContrib,2,'.',',')}}</td>
                            </tr>
                            <tr>
                                <td class="style1">Hired Date:</td>
                                <td class="style2">{{$emp->hired_date}}</td>
                                <td class="style1" >Philhealth:</td>
                                <td class="style2" >{{number_format($emp->philHealthContrib,2,'.',',')}}</td>
                            </tr>
                            <tr>
                                <td class="style1">Salary:</td>
                                <td class="style2">{{number_format($emp->salary,2,'.',',')}}</td>
                                <td class="style1" style="border-bottom: solid">W Tax:</td>
                                <td class="style2" style="border-bottom: solid">{{number_format($emp->w_tax,2,'.',',')}}</td>
                            </tr>
                            <tr>
                                <td class="style1">Allowance:</td>
                                <td class="style2">{{number_format($emp->allowance,2,'.',',')}}</td>
                                <td class="style1" >Total Deduction:</td>
                                <td class="style2">{{number_format($emp->deduction,2,'.',',')}}</td>
                            </tr>
                            <tr>
                                <td class="style1"></td>
                                <td class="style2"></td>
                                <td class="style1"></td>
                                <td class="style2"></td>
                            </tr>
                            <tr>
                                <td class="style1">Daily Rate:</td>
                                <td class="style2">{{number_format($emp->rate,2,'.',',')}}</td>
                                <td class="style1">Gross Pay:</td>
                                <td class="style2">{{number_format($emp->grosspay,2,'.',',')}}</td>
                            </tr>
                            <tr>
                                <td class="style1">Overtime Pay:</td>
                                <td class="style2">{{number_format($emp->ot,2,'.',',')}}</td>
                                <td colspan="2" class="style1"><pre>Net Pay:            {{number_format($emp->netpay,2,'.',',')}}</pre></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary noprint" onclick="javascript:window.print()"><span class="glyphicon glyphicon-print"></span> Print Payslip</button>
                  {{--  <a href="{{URL::to('employees/payslip/'.$payroll->payroll_id.'/save')}}" role="button" class="btn btn-success btn-large noprint"><span class="glyphicon glyphicon-floppy-disk"></span> Save Payslip</a>--}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
@stop