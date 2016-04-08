@extends('master')
@section('content')
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
     <td >{{trans('labels.tax.lbl_status')}}</td>
     <td>{{trans('labels.tax.lbl_income')}}</td>
     <td>{{trans('labels.tax.lbl_diff')}}</td>
     <td>{{trans('labels.tax.lbl_tax_payable')}}</td>
     <td>{{trans('labels.lbl_action')}}</td>
   </tr>
 </thead>
 <tbody>
  @foreach($taxes as $value)
  <tr>
    <td class="active">{{{$value->status}}}</td>
    <td class="active">{{{$value->basis}}}</td>
    <td class="active">{{{$value->excess}}}</td>
    <td class="active">{{{$value->excemption}}}</td>
    <td class="active">
     <a class="btn btn-small btn-default" href="{{ URL::to('employees/tax/update/' . $value->tax_id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {{trans('labels.tax.lbl_edit_tax')}}</a>
   </td>
 </tr>
 @endforeach
</tbody>
</table>
<div class="btn-group">
  <a class="btn btn-success" href="{{ URL::to('employees/tax/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{trans('labels.tax.lbl_insert_tax')}}</a>
</div>
</div>
@stop