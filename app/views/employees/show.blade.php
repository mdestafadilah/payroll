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
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $employee->firstname }} {{ $employee->lastname }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center">
                        @if($employee->avatar == null)
                        <img src="{{URL::to('uploads/avatar.png')}}" width="135px" height="135px" class="img-circle">
                        @else
                        <img src="{{URL::to('uploads/')}}/{{$employee->avatar}}" width="135px" height="135px" class="img-circle">
                        @endif
                        {{ Form::open(array('url' => '/upload-employee/'.$employee->emp_id,'files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('avatar', 'Avatar',array('class' => 'sr-only','id' => 'avatarupload')) }}
                            <div style="position:relative;">
                              <input type="file" class="filestyle" id="empavatar" data-input="false" name="employee_avatar" accept="image/*">
                              @if ($errors->has('employee_avatar')) <p class="help-block">Please select avatar first!</p> @endif
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary" aria-label="Left Align" id="btnUpload">
                        <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>{{trans('labels.show.lbl_upload_img')}}
                    </button>
                    {{ Form::close() }}
                </div>
                <div class=" col-md-9 col-lg-9 ">
                    <table class="table table-user-information">
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                               Other Information <span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('employees/'.$employee->emp_id.'/contribution/') }}">Employee Rate</a></li>
                            <li><a href="{{ URL::to('employees/'.$employee->emp_id.'/erc/') }}">Employer Share</a></li>
                            <li><a href="{{ URL::to('employees/'.$employee->emp_id.'/stats/') }}">Time Logs</a></li>
                            <li><a href="{{ URL::to('employees/'.$employee->emp_id.'/payroll/') }}">Payroll Logs</a></li>
                        </ul>
                    </div>
                    <tbody>
                        <tr>
                            <td>First Name:</td>
                            <td>{{ $employee->firstname }}</td>
                        </tr>
                        <tr>
                            <td>Last  Name:</td>
                            <td>{{ $employee->lastname }}</td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td>{{ $employee->gender }}</td>
                        </tr>
                        <tr>
                            <td>Birth Date:</td>
                            <td>{{ $employee->birthdate }}</td>
                        </tr>
                        <tr>
                            <td>Home Address:</td>
                            <td>{{ $employee->homeaddress }}</td>
                        </tr>
                        <tr>
                            <td>Contact No.:</td>
                            <td>{{ $employee->contactno }}</td>
                        </tr>
                        <tr>
                            <td>Email Address::</td>
                            <td>{{ $employee->email }}</td>
                        </tr>
                        <tr>
                            <td>Position:</td>
                            <td>{{ $employee->position }}</td>
                        </tr>
                        <tr>
                            <td>Hire Date:</td>
                            <td>{{ $employee->hired_date }}</td>
                        </tr>

                        <tr>
                            <td>SSS No.:</td>
                            <td>{{ $employee->sss_no }}</td>
                        </tr>

                        <tr>
                            <td>PhilHealth No.:</td>
                            <td>{{ $employee->ph_no }}</td>
                        </tr>
                        <tr>
                            <td>Pag-ibig No.:</td>
                            <td>{{ $employee->pi_no }}</td>
                        </tr>
                    </tbody>
                </table>
                LAST EDITED BY :  
                        @if($employee->user->avatar == null)
                        <img src="{{URL::to('uploads/avatar.png')}}" width="35px" height="35px" class="img-circle"> <span class="label label-danger">{{$employee->user->user_fullnm}}</span>
                        @else
                        <img src="{{URL::to('uploads/')}}/{{$employee->user->avatar}}" width="35px" height="35px" class="img-circle"> <span class="label label-danger">{{$employee->user->user_fullnm}}</span>
                        @endif
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <a class="btn btn-small btn-success" style="width: 100px; !important" href="{{ URL::to('employees/' . $employee->emp_id . '/edit') }}"><span class="glyphicon glyphicon-glyphicon glyphicon-edit" aria-hidden="true"></span>Edit&nbsp;</a>
        @if($employee->del_flag == '0')
        {{ Form::open(array('url' => 'employees/'. $employee->emp_id. '/delete' , 'class' => 'pull-right', 'id' => 'delete')) }}
        <button type="submit" class="btn btn-danger" style="width: 100px; !important" aria-label="Left Align">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Delete</button>
            {{ Form::close() }}
            @else
            {{ Form::open(array('url' => 'employees/'. $employee->emp_id .  '/activate' , 'class' => 'pull-right')) }}
            <button type="submit" class="btn btn-warning" style="width: 100px; !important" aria-label="Left Align">
                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>Activate</button>
                {{ Form::close() }}
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@stop