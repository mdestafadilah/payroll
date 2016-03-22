@extends('master')
@section('content')
<script>
    $(document).ready(function() {
        $("#btnUpload").bind('click', function () {
            if($("#upload").val()==''){
                event.preventDefault();
            }else{

            }
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
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $user->user_fullnm }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center">
                        @if($user->avatar == null)
                        <img src="{{URL::to('uploads/avatar.png')}}" width="125px" height="125px" class="img-circle">
                        @else
                        <img src="{{URL::to('uploads/')}}/{{$user->avatar}}" width="125px" height="125px" class="img-circle">
                        @endif
                        {{ Form::open(array('url' => '/upload-admin/'.$user->user_id,'files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('avatar', 'Avatar',array('class' => 'sr-only')) }}
                            <div class=" @if ($errors->has('admin_avatar')) has-error @endif" style="position:relative;">
                               <input type="file" class="filestyle" id="adminavatar" data-input="false" name="admin_avatar" accept="image/*">
                               @if ($errors->has('admin_avatar')) <p class="help-block">Please select avatar first!</p> @endif
                           </div>
                       </div>
                       <button type="submit" class="btn btn-primary" aria-label="Left Align" id="btnUpload">
                        <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> {{trans('labels.show.lbl_upload_img')}}

                    </button>
                    {{ Form::close() }}
                </div>
                <div class=" col-md-9 col-lg-9 ">
                    <table class="table table-user-information">
                        <tbody>
                            <tr>
                                <td>{{trans('labels.profile.lbl_fullname')}}:</td>
                                <td>{{$user->user_fullnm }}</td>
                            </tr>
                            <tr>
                                <td>{{trans('labels.profile.lbl_position')}}:</td>
                                <td>{{ $user->position }}</td>
                            </tr>
                            <tr>
                                <td>{{trans('labels.profile.lbl_role')}}:</td>
                                @if($user->usr_role == '1')
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
        <div class="panel-footer">
            <a class="btn btn-small btn-success"  href="{{ URL::to('admin/update/' . $user->user_id) }}"><span class="glyphicon glyphicon-glyphicon glyphicon-edit" aria-hidden="true"></span>{{trans('labels.users.lbl_edit_profile')}}</a>
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/validate') }}"><span class="glyphicon glyphicon-glyphicon glyphicon-edit" aria-hidden="true"></span>{{trans('labels.master.lbl_change_password')}}</a>
            @if($user->del_flg == '0')
            {{ Form::open(array('url' => 'admin/'. $user->user_id. '/delete' , 'class' => 'pull-right', 'id' => 'delete')) }}
            <button type="submit" class="btn btn-danger" style="width: 100px; !important" aria-label="Left Align">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>{{trans('labels.show.lbl_delete')}}</button>
                {{ Form::close() }}
                @else
                {{ Form::open(array('url' => 'admin/'. $user->user_id .  '/activate' , 'class' => 'pull-right')) }}
                <button type="submit" class="btn btn-warning" style="width: 100px; !important" aria-label="Left Align">
                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span>{{trans('labels.show.lbl_activate')}}</button>
                    {{ Form::close() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @stop