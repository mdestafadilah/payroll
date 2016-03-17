<!DOCTYPE html>
<html>
<head>
    <title>Payroll</title>
    <link href="{{URL::to('css/app.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::to('css/loginstyle.css')}}">
    <link rel="stylesheet" href="{{URL::to('font/Roboto.css')}}">
    <script type="text/javascript" src="{{URL::to('js/jquery-1.11.3.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/bootstrap.min.js')}}"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="account-wall" style="padding: 10px; position:absolute;top:100px;width: 300px">
                    <h4 class="text-center login-title">{{date("h:i a")}} - {{date("Y/m/d")}}</h4>
                    <div class="panel-footer">
                        <a class="btn btn-block btn-lg btn-success " href="{{ URL::to('login') }}">ADMIN</a> <br>
                        <a class="btn btn-block btn-lg btn-primary" href="{{ URL::to('/request') }}">EMPLOYEE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>