@extends('master')
@section('content')

@if (Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
    {{ Session::get('message') }}
</div>
@endif
<div class="row" >
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
        <div class="table-responsive" style="background-color:white;">
          <table class="table table-bordered" width="500px">
            <tr>
                <td colspan="3"><h4 style="text-align:center;">{{trans('labels.showPayslip.lbl_company_name')}} </h4><p style="text-align:center;">* {{trans('labels.showPayslip.lbl_payslip')}} *</p></td>
            </tr>
            <tr>
                <td colspan="3">{{$payroll->coverage}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_name')}}</td>
                <td colspan="2" width="200px;">{{ucwords($payroll->employee->lastname) . ' '. ucwords($payroll->employee->firstname)}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_basic_pay')}}</td>
                <td colspan="2">{{number_format($rate->salary,2,'.',',')}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_allowance')}}</td>
                <td colspan="2">{{number_format($rate->allowance,2,'.',',')}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_overTime')}}</td>
                <td colspan="2">{{$payroll->ot}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_salary_adjustment')}}</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_gross_pay')}}</td>
                <td colspan="2">{{number_format($payroll->grosspay,2,'.',',')}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_wtax')}}</td>
                <td colspan="2">{{number_format($payroll->w_tax,2,'.',',')}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_sss')}}</td>
                <td colspan="2">{{number_format($payroll->sssContrib,2,'.',',')}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_hdmf')}}</td>
                <td colspan="2">{{number_format($payroll->pagibigContrib,2,'.',',')}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_phic')}}</td>
                <td colspan="2">{{number_format($payroll->philHealthContrib,2,'.',',')}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_late_penalty')}}</td>
                <td colspan="2">{{number_format($payroll->late_deduction,2,'.',',')}}</td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_absences')}}</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td width="200px;">{{trans('labels.showPayslip.lbl_undertime')}}</td>
                <td colspan="2">
                </td></tr>
                <tr class="border_bottom">
                    <td width="200px;">{{trans('labels.showPayslip.lbl_total_ded')}}</td>
                    <td colspan="2">{{number_format($payroll->deduction,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">{{trans('labels.showPayslip.lbl_netpay')}}</td>
                    <td colspan="2">{{number_format($payroll->netpay,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="height:40px;"></td>
                </tr>
                <tr>
                    <td>{{trans('labels.showPayslip.lbl_emp_name')}}</td>
                    <td>{{trans('labels.showPayslip.lbl_signature')}}</td>
                    <td>{{trans('labels.showPayslip.lbl_date')}}</td>
                </tr>
            </table>
        </div>
        <button type="button" class="btn btn-primary noprint" onclick="javascript:window.print()"><span class="glyphicon glyphicon-print"></span> {{trans('labels.showPayslip.lbl_print_payslip')}}</button>
        <a href="{{URL::to('employees/payslip/'.$payroll->payroll_id.'/save')}}" role="button" class="btn btn-success btn-large noprint"><span class="glyphicon glyphicon-floppy-disk"></span> {{trans('labels.showPayslip.lbl_save_payslip')}}</a>
    </div>
</div>
@stop