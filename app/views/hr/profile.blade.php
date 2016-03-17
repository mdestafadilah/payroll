@extends('master')
@section('content')
@if (Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
    {{ Session::get('message') }}
</div>
@endif
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $user->fullname }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="/img/avatar.png" class="img-circle"> </div>

                    <div class=" col-md-9 col-lg-9 ">
                        <table class="table table-user-information">
                            <tbody>
                                <tr>
                                    <td>Full Name:</td>
                                    <td>{{$user->fullname }}</td>
                                </tr>
                                <tr>
                                    <td>Position:</td>
                                    <td>{{ $user->position }}</td>
                                </tr>
                                <tr>
                                    <td>Role:</td>
                                    @if(Auth::user()->usr_role == 1)
                                    <td>{{'Admin'}}</td>
                                    @else
                                    <td>{{'HR'}}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop