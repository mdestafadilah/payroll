@extends('master')
@section('content')
<script type="text/javascript" src="{{URL::to('chartjs/Chart.js')}}"></script>
    <div class="container" style="">
        @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
        <div class="row">
          <div class="col-md-9 col-md-push-3">
            <div class="panel panel-danger">
              <div class="panel-heading"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp; {{trans('labels.index.lbl_all_registered')}}</div>
              <div class="panel-body">
                <div class="form-group"> 
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              @if(Request::segment(2) =='active')
                                {{trans('labels.index.lbl_view_act')}}
                              @elseif(Request::segment(2) =='inactive')
                                {{trans('labels.index.lbl_view_ina')}}
                              @else
                                {{trans('labels.index.lbl_view')}}
                              @endif
                               <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('/employees') }}">{{trans('labels.index.lbl_all_acc')}}</a></li>
                            <li><a href="{{ URL::to('/employees/active') }}">{{trans('labels.index.lbl_act_acc')}}</a></li>
                            <li><a href="{{ URL::to('/employees/inactive') }}">{{trans('labels.index.lbl_ina_acc')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tbody>
                            @foreach($employee as $value)
                            <tr>
                                <td class="active">
                                    @if($value->avatar == null)
                                    <img src="{{URL::to('uploads/avatar.png')}}" width="35px" height="35px" class="img-circle">
                                    @else
                                    <img src="{{URL::to('uploads/')}}/{{$value->avatar}}" width="35px" height="35px" class="img-circle">
                                    @endif </td>
                                    <td class="active">{{{ucwords($value->firstname)}}} {{{ucwords($value->lastname)}}}</td>
                                    <td class="active">{{{$value->gender}}}</td>
                                    <td class="active">{{{$value->position}}}</td>
                                    <td class="active">{{{$value->hired_date}}}</td>
                                    <td class="active"> 
                                       <a class="btn btn-small btn-default" name="showProfile" href="{{ URL::to('employees/' . $value->emp_id) }}"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{trans('labels.index.lbl_shw_profile')}}</a>
                                       <a class="btn btn-small btn-default" name="editProfile" href="{{ URL::to('employees/' . $value->emp_id . '/edit') }}"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {{trans('labels.index.lbl_edit_profile')}}</a>
                                   </td>
                                   <td class="active"> 
                                    @if($value->del_flag == '0')
                                    {{ Form::open(array('url' => 'employees/'. $value->emp_id. '/delete', 'class' => 'pull-right')) }}
                                    <button type="submit" name="deleteProfile" class="btn btn-danger" aria-label="Left Align" id="delete">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 
                                    </button>
                                    {{ Form::close() }}
                                    @else
                                    {{ Form::open(array('url' => 'employees/'. $value->emp_id .  '/activate' , 'class' => 'pull-right')) }}
                                    <button type="submit" name="activateProfile" class="btn btn-success" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span> 
                                    </button>
                                    {{ Form::close() }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--pagination-->
                    {{$employee->links()}}
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-3 col-md-pull-9">
        <div class="panel panel-danger">
          <div class="panel-heading"><span class="glyphicon glyphicon-random" aria-hidden="true"></span>&nbsp;&nbsp;{{trans('labels.index.lbl_emp_stat')}}</div>
          <div class="panel-body">
            <div id="canvas-holder"><canvas id="chart-area"/></div>
            <?php
            $usercount_active = Employee::where('del_flag', '=', '0')->count();
            $usercount_inactive = Employee::where('del_flag', '=', '1')->count();
            $usercount_all = $usercount_active + $usercount_inactive;
            ?>
            <span class="label label-primary">{{trans('labels.index.lbl_all')}} </span>&nbsp;&nbsp;: <b>{{$usercount_all}}</b>&nbsp;
            <span class="label label-success">{{trans('labels.index.lbl_act')}} </span>&nbsp;&nbsp;: <b>{{$usercount_active}}</b>&nbsp;
            <span class="label label-danger">{{trans('labels.index.lbl_ina')}}</span>&nbsp;&nbsp;: <b>{{$usercount_inactive}}</b>&nbsp;
        </div>
    </div>
    <div class="panel panel-danger">
      <div class="panel-heading"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp; {{trans('labels.index.lbl_new_reg_emp')}}</div>
      <div class="panel-body" style="margin-top:10px; !important">
        <?php $empNew = DB::table('employees')->orderBy('created_at','DESC')->take(10)->get(); ?>
        @foreach($empNew as $empNew)
        <ul style="margin-left:-15px; !important">
            @if($empNew->avatar == null)
            <img src="{{URL::to('uploads/avatar.png')}}" width="35px" height="35px" class="img-circle">
            @else
            <img src="{{URL::to('uploads/')}}/{{$empNew->avatar}}" width="35px" height="35px" class="img-circle">
            @endif
            <a href="{{URL::to('employees/')}}/{{$empNew->emp_id}}">{{{$empNew->firstname}}} {{{$empNew->lastname}}}</a>
        </ul>
        @endforeach
    </div>
</div>
</div>
</div>
<?php
$usercount_active = Employee::where('del_flag', '=', '0')->count();
$usercount_inactive = Employee::where('del_flag', '=', '1')->count();
?>
<script>
    var doughnutData = [
    {
        value: {{$usercount_inactive}},
        color:"#D9534F",
        highlight: "#FF5A5E",
        label: "Inactive Employees"
    },
    {
        value: {{$usercount_active}},
        color: "#5CB85C",
        highlight: "#00cc00",
        label: "Active Employees"
    },
    ];
    window.onload = function(){
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});
    };
</script>
<div class="well">
    <center>
     Copyright © 2015 Ring System Development Inc. All Rights Reserved.
 </center>
</div>
</div>
@stop