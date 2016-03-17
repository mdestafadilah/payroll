@extends('master')
@section('content')
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
 <div class="panel panel-danger">
  <div class="panel-heading">{{trans('labels.request.lbl_title')}}</div>
  <div class="panel-body">
    <div class="form-group">
      <div class="btn-group">
       <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        View {{ucwords(Request::segment(3) ). " Requests"}} <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a href="{{ URL::to('/employees/request') }}">All Request</a></li>
        <li><a href="{{ URL::to('/employees/request/pending') }}">Pending Request</a></li>
        <li><a href="{{ URL::to('/employees/request/approved') }}">Approved Request</a></li>
      </ul>
    </div>
  </div>
  <div class="table-responsive">
   <table class="table table-hover table-bordered">
    <tbody>
      @foreach($employee as $request)
      <tr>
        <td class="active">
         @if($request->employee->avatar == null)
         <img src="{{URL::to('uploads/avatar.png')}}" width="35px" height="35px" class="img-circle">
         @else
         <img src="{{URL::to('uploads/')}}/{{Auth::user()->avatar}}" width="35px" height="35px" class="img-circle">
         @endif
         &nbsp;&nbsp;&nbsp;
         <?php echo ucwords($request->employee->firstname ." ". $request->employee->lastname); ?>
       </td>
       <td class="active">
         <a class="btn btn-small btn-default" name="showProfile" href="{{ URL::to('employees/' . $request->emp_id) }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Show Profile</a>
         <a class="btn btn-small btn-default" href="{{ URL::to('employees/payslip/' . $request->payroll_id ) }}"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Show Payslip</a>
         <a class="btn btn-small btn-default" href="{{URL::to('employees/payslip/'.$request->payroll_id.'/save')}}"><span class="glyphicon glyphicon-floppy-disk"></span> Save Payslip</a>
       </td>
       @if($request->approve == '0')
       <td class="active">
         <a href="{{URL::to('admin/mail/'.$request->req_id.'')}}" role="button" class="btn btn-success pull-right"><span class="glyphicon glyphicon-check"></span> Approve Request</a>
       </td>
       @endif
     </tr>
     @endforeach
   </tbody>
 </table>
</div>
<!--pagination-->
@if(Request::segment(3) != 'approved')
{{$employee->links()}}
@endif
</div>
</div>
</div>
@stop