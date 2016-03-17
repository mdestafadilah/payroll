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
                <div class="account-wall">
                    <img class="profile-img" src="{{URL::to('img/rsdlogo.png')}}"
                    alt="">
                    @if (Session::has('errormessage'))
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        {{ Session::get('errormessage') }}
                    </div>
                    @endif
                    {{ Form::open(array('url' => 'login' ,'class'=>'form-signin')) }}
                    <div class="form-group @if ($errors->has('username')) has-error @endif">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control input-sm" name="username" placeholder="Enter Username">
                        @if ($errors->has('username')) <p class="help-block">
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            Username field is required
                        </div>
                    </p>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('password')) has-error @endif">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control input-sm" name="password" placeholder="Enter Password">
                    @if ($errors->has('password')) <p class="help-block">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        Password field is required
                    </div>
                </p>
                @endif
            </div>
            <div class="row">
                {{ Form::submit('LOGIN', array('class' => 'btn btn-block btn-lg btn-success')) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>