@extends('master')
@section('content')
<script type="text/javascript">
  
  $(document).ready(function() {
    function Regen(){
        if(confirm("Are you sure you want to regenerate payslip?")){
            $(this).prev('button').remove();
        }else{
            event.preventDefault();
        }
    }
    $('#from').datetimepicker({
        format: "Y/m/d",
        clearBtn: true,
        orientation: "top auto",
        timepicker:false
    });

    $('#to').datetimepicker({
        format: "Y/m/d",
        clearBtn: true,
        orientation: "top auto",
        timepicker:false
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
<div class="row" >
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title span2">Please choose date to generate payslip.</h3>
            </div>
            <div class="panel-body">
                <div class="row" id="mydiv">
                   @if(Request::segment(4)=='edit')
                   {{Form::open(array('url'=>'employees/'.$employee->payroll_id.'/payslip/edit'))}}
                   @else
                   {{Form::open(array('url'=>'employees/'.$employee->emp_id.'/payslip'))}}
                   @endif
                   <div class="form-group text-center @if ($errors->has('from')) has-error @endif" style="width:250px;margin:auto;">
                       <div class="input-group @if ($errors->has('from')) has-error @endif">
                          <div class="input-group-addon">{{trans('labels.iPayslip.lbl_from')}}</div>
                          <input type="text" class="form-control" name="from" id="from">
                      </div>
                      <br/>
                      <div class="input-group @if ($errors->has('to')) has-error @endif">
                          <div class="input-group-addon">&nbsp;&nbsp; {{trans('labels.iPayslip.lbl_to')}} &nbsp;&nbsp;</div>
                          <input type="text" class="form-control" name="to" id="to">
                      </div>
                      <br/>
                      <div class="form-group  @if ($errors->has('to')) has-error @endif"></div>
                      {{ Form::submit('Submit', array('class' => 'btn  btn-md btn-success')) }}
                      <a @if(Session::has('flg'))href="{{URL::to('employees/'.$employee->emp_id)}}"
                          @else  href="{{URL::to('employees/'.$employee->emp_id.'/payroll')}}"
                          @endif
                          class="btn btn-md btn-danger">{{trans('labels.lbl_cancel')}}</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      @stop