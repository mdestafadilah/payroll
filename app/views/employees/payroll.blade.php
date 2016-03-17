@extends('master')
@section('content')
<script type="text/javascript">
    $(document).ready(function(event){
        $(document).on("click", "#regBtn", function(event) {
            confirmationClk();
        });
    });
    function confirmationClk(){
        if (confirm('Are you sure you want to regenerate record?')) {
            $(this).prev('button').remove();
        }else{
            event.preventDefault();
            return false;
        }
    }
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
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="">
            <tr class="tr-custom">
                <td class="">ID</td>
                <td class="">DATE</td>
                <td class="">{{trans('labels.payroll.lbl_grosspay')}}</td>
                <td class="">DEDUCTION</td>
                <td class="">NETPAY</td>
                <td class="">ACTION</td>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td class="active">{{ $employee->payroll_id }}</td>
                <td class="active">{{ $employee->coverage }}</td>
                <td class="active">{{ $employee->grosspay }}</td>
                <td class="active">{{ $employee->deduction }}</td>
                <td class="active">{{ $employee->netpay }}</td>
                <td class="active">
                    <a class="btn btn-small btn-default" href="{{ URL::to('employees/payslip/' . $employee->payroll_id ) }}"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Show this Payslip</a>
                    <a class="btn btn-small btn-danger" id="regBtn" href="{{ URL::to('employees/'.$employee->payroll_id.'/payslip/edit') }}"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Regenerate Payslip</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!--pagination-->
    {{$employees->links()}}
</div>
@if($employee->employee->del_flag == 0)
<div class="btn-group">
    <a class="btn btn-success" href="{{ URL::to('employees/'.$employee->employee->emp_id.'/payslip') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Payslip</a>
    <a class="btn btn-primary"
    @if(Session::has('bonus'))  href="{{ URL::to('employees/'.$employee->employee->emp_id.'/bonus') }}"
    @else  href="{{ URL::to('employees/'.$employee->payroll_id.'/bonus/edit') }}"
    @endif ><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span> 13th Month Pay</a>
</div>
@endif
@stop