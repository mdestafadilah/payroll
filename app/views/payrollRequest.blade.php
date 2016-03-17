<!DOCTYPE html>
<html>
<head>
  <title>Payroll</title>
  <link rel="stylesheet" href="{{URL::to('css/loginstyle.css')}}">
  <link rel="stylesheet" href="{{URL::to('css/app.css')}}">
  <link rel="stylesheet" href="{{URL::to('font/Roboto.css')}}">
  <script type="text/javascript" src="{{URL::to('js/jquery-1.11.3.min.js')}}"></script>
  <script type="text/javascript" src="{{URL::to('js/bootstrap.min.js')}}"></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-md-4 col-md-offset-4">
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
        <div class="account-wall" >
          <h4 class="text-center login-title">EMPLOYEE PAYROLL REQUEST</h4>
        </p>
        {{ Form::open(array('url'=>'payroll-records/', 'class'=>'form-signin')) }}

        <div class="form-group @if ($errors->has('emp_id')) has-error @endif">
          <label for="emp_id">Employee ID</label>
          <input type="text" id="emp_id" class="form-control input-sm" name="emp_id" placeholder="Enter Employee ID" value="{{ Input::old('employee_id') }}">
          @if ($errors->has('emp_id')) <p class="help-block">{{ $errors->first('emp_id') }}</p> @endif
        </div>
               <div class="row">
                <button type="submit" name="SUBMIT" class="btn btn-block btn-lg btn-primary" aria-label="Left Align" id="submit">SUBMIT</button>
              </div>
              <div class="row" style="margin-top:10px; !important">
               <a class="btn btn-block btn-lg btn-danger" href="/">CANCEL</a>
             </div>
           </div>
         </div>
       </div>
     </div>
   </body>
   </html>