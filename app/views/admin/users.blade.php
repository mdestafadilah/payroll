@extends('master')
@section('content')
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
            <div class="panel-heading">{{trans('labels.users.lbl_title')}}</div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <tbody>
                   @foreach($user as $value)
                   <tr>
                     <td class="active">
                      @if($value->avatar == null)
                      <img src="{{URL::to('uploads/avatar.png')}}" width="35px" height="35px" class="img-circle">
                      @else
                      <img src="{{URL::to('uploads/')}}/{{$value->avatar}}" width="35px" height="35px" class="img-circle">
                      @endif
                    </td>
                    <td class="active">{{{$value->user_fullnm}}}</td>
                    <td class="active"><!-- {{ $value->position }} --></td>
                    <td class="active">
                      <a class="btn btn-small btn-default" href="{{ URL::to('admin/profile/' . $value->user_id) }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{trans('labels.master.lbl_show_profile')}}</a>
                      <a class="btn btn-small btn-default" href="{{ URL::to('admin/update/' . $value->user_id ) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {{trans('labels.users.lbl_edit_profile')}}</a>
                    </td>
                    <td class="active">
                      @if($value->del_flg == '0')
                      {{ Form::open(array('url' => 'admin/'. $value->user_id. '/delete' , 'class' => 'pull-right')) }}
                      <button type="submit" class="btn btn-danger" aria-label="Left Align" id="delete">
                       <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 
                     </button>
                     {{ Form::close() }}
                     @else
                     {{ Form::open(array('url' => 'admin/'. $value->user_id .  '/activate' , 'class' => 'pull-right')) }}
                     <button type="submit" class="btn btn-success" aria-label="Left Align">
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
             {{$user->links()}}
           </div>
         </div>
       </div>
     </div>
     <div class="col-md-3 col-md-pull-9">
      <div class="panel panel-danger">
        <div class="panel-heading"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp; {{trans('labels.index.lbl_new_reg_emp')}}</div>
        <div class="panel-body">
          <?php 
          $dt = new DateTime();
          $dt->format('Y-m-d');
          $empNew = DB::table('employees')->orderBy('created_at','DESC')->take(3) ->get();
          ?>
          @foreach($empNew as $empNew)
          <ul>
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
      <div class="panel panel-danger">
        <div class="panel-heading"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp; {{trans('labels.users.lbl_reg_user')}}</div>
        <div class="panel-body">
          <?php 
          $dt = new DateTime();
          $dt->format('Y-m-d');
          $ringConn = DB::connection('ringdb');
          $userNew = $ringConn->table('m_user')->orderBy('created_at','DESC')->take(3)->get();
          ?>
          @foreach($userNew as $userNew)
          <ul>
            @if($userNew->avatar == null)
            <img src="{{URL::to('uploads/avatar.png')}}" width="35px" height="35px" class="img-circle">
            @else
            <img src="{{URL::to('uploads/')}}/{{$userNew->avatar}}" width="35px" height="35px" class="img-circle">
            @endif
            <a href="{{URL::to('admin/profile/')}}/{{$userNew->user_id}}">{{{$userNew->user_fullnm}}}</a>
          </ul>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@stop