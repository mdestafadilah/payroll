<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payroll</title>
    <link rel="stylesheet" href="{{URL::to('css/app.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{URL::to('font/Roboto.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <style>
        .centered-form{
            margin-top: 20px;
        }
        .centered-form .panel{
            background: rgba(255, 255, 255, 0.8);
            box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
        }
        @media print
        {
            .noprint {display:none;}
            .nomargin {margin-top: 0;}
        }
        @page {
         size: A4;
         margin: 2mm 35mm 45mm 35mm; 
        }
     
 </style>

 <link rel="stylesheet" type="text/css" href="{{URL::to('css/jquery.datetimepicker.css')}}"/>

 <script type="text/javascript" src="{{URL::to('js/jquery.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/jquery-ui.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/jquery-1.10.2.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/jquery-1.11.3.min.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/bootstrap.min.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/bootstrap-filestyle.min.js')}}"> </script>
 <script type="text/javascript" src="{{URL::to('js/bootstrap-datepicker.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/moment.min.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/daterangepicker.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/script.js')}}"></script>
 <script type="text/javascript" src="{{URL::to('js/jquery.datetimepicker.js')}}"></script>

 <script type="text/javascript">


    //Delete Emp
    $(document).ready(function(){
        $(document).on("click", "#delete", function() {
            if (confirm('Are you sure you want to delete employee record?')) {
                $(this).prev('button').remove();
            }else{
                event.preventDefault();
            }
        });
    });


  
</script>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="{{URL::to('img/rsdlogo.png')}}" width="50px" height="50px" class="img-circle">&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class=""><a href="{{ URL::to('employees/') }}">{{trans('labels.master.lbl_all_employees')}}<span class="sr-only">(current)</span></a></li>
                    <li><a href="{{ URL::to('employees/create') }}">{{trans('labels.master.lbl_create_employee')}}<span class="sr-only">(current)</span></a></li>
                    <li><a href="{{ URL::to('employees/request') }}">PAYROLL REQUEST<span id="reqcount" class="badge"></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">REPORTS<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{URL::to('employees/reports')}}"><span class="glyphicon glyphicon-list-alt"></span> {{trans('labels.master.lbl_payroll_reports')}}</a></li>
                            <li><a href="{{URL::to('employees/sumarryReports')}}"><span class="glyphicon glyphicon-folder-open"></span> {{trans('labels.payroll_reports.lbl_summary_report')}}</a></li>                            
                        </ul>
                    </li>
                </ul>
                @if(Request::segment(1)=='admin')
                {{Form::open(array('url' => 'admin/search', 'class' => 'navbar-form navbar-left'))}}
                <div class="form-group">
                    <input type="text" name="id" class="form-control" id="search">
                </div>
                <button type="submit" class="btn btn-default" id="searchBtn">Search</button>
                {{Form::close()}}
                @else
                {{Form::open(array('url' => 'employees/search', 'class' => 'navbar-form navbar-left'))}}
                <div class="form-group">
                    <input type="text" name="id" class="form-control" id="search">
                </div>
                <button type="submit" class="btn btn-default"  id="searchBtn">Search</button>
                {{Form::close()}}
                @endif
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::user()->avatar == null)
                    <li><img src="{{URL::to('uploads/avatar.png')}}" width="45px" height="45px" class="img-circle"></li>
                    @else
                    <li><img src="{{URL::to('uploads/')}}/{{Auth::user()->avatar}}" width="45px" height="45px" class="img-circle"></li>
                    @endif
                    <?php 
                    $cd2 = MCode::where('idnt_id','000001')->where('cd1',Auth::user()->position)->pluck('cd2');
                    ?>
                    @if($cd2 == 1)
                    <li><a href="{{URL::to('admin/profile/'.Auth::user()->user_id.'/')}}">{{ ucwords(Auth::user()->user_fullnm) }}</a></li>
                    @else
                    <li><a href="{{URL::to('hr/profile/'.Auth::user()->user_id.'/')}}">{{ ucwords(Auth::user()->user_fullnm) }}</a></li>
                    @endif
                    <!-- <li><a href="{{ "http://".$_SERVER['HTTP_HOST']."/menu.php" }}"><span class="glyphicon glyphicon-share"></span></a></li> -->

                    <li>
                      <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href = '<?php echo "http://".$_SERVER['HTTP_HOST']."/menu.php";?>'" style="margin-top:10px!important;margin-right:15px!important;margin-left:15px!important;">
                        <span title="Back to Menu" class="glyphicon glyphicon-share" aria-hidden="true"></span>
                      </button>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> MENU<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @if($cd2 == 1)
                            <li><a href="{{URL::to('admin/')}}"><span class="glyphicon glyphicon-th-list"></span> ALL ACCOUNTS</a></li>
                            <li><a href="{{URL::to('admin/register')}}"><span class="glyphicon glyphicon-plus"></span> CREATE ACCOUNT</a></li>
                            <li><a href="{{URL::to('employees/tax')}}"><span class="glyphicon glyphicon-usd"></span> TAX</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ URL::to('/logout') }}"><span class="glyphicon glyphicon-off"></span> LOGOUT</a></li>
                            @else
                            <li><a href="{{URL::to('hr/profile/'.Auth::user()->user_id.'/')}}"><span class="glyphicon glyphicon-user"></span> SHOW PROFILE</a></li>
                            <li><a href="{{URL::to('hr/validate')}}"><span class="glyphicon glyphicon-pencil"></span> CHANGE PASSWORD</a></li>
                            <li><a href="{{URL::to('employees/tax')}}"><span class="glyphicon glyphicon-usd"></span> TAX</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ URL::to('/logout') }}"><span class="glyphicon glyphicon-off"></span> LOGOUT</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 100px !important;">
        @yield('content')
    </div>
</body>
</html>