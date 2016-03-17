<!DOCTYPE html>
<html>
<head>
    <title>Payroll</title>
    <link rel="stylesheet" href="{{URL::to('css/app.css')}}">
    <link rel="stylesheet" href="{{URL::to('font/Roboto.css')}}">
    <script type="text/javascript" src="{{URL::to('js/jquery-1.11.3.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript">
        $(function(){
           $("#submit").click(function(event){      
               if ($("input:radio[name='payid']:checked").length <=0 ) {
                   alert('Nothing is checked! Please check one.');
                   event.preventDefault();
                   return false; 
               } 
           });
       });

        $(function() {
            $('table tr').click(function() {
              $(this).find('input:radio').prop('checked', true);
          });
        }); 
    </script>
    <style>
        .table {
            width: 650px !important;
            table-layout: fixed;
            margin: 0 auto;
            margin-bottom: 20px;
        }
        #btnReq{
            clear: both;

            width: 100px !important;
            margin: 0 auto !important;
        }

        .center-block {float: none !important}
    </style>
</head>
<body>
    @if (Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        {{ Session::get('message') }}
    </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="tr-custom">
                <tr class="tr-custom">
                    <td class="tr-custom">Payroll Date</td>
                    <td class="tr-custom">Payroll Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($employee as $req)
                {{ Form::open(array('url' => 'payroll-records/request', 'id' => 'reqForm' )) }}
                <tr>
                    <td class="hidden"><input type="hidden" id="payid" name="payid" value="{{$req->payroll_id}}"></td>
                    <td class="hidden"><input type="text" name="empid" id="empid" value="{{$req->emp_id}}"/></td>
                    <td class="active">{{ $req->coverage }}</td>
                    <td class="active">
                        {{ Form::open(array('url' => 'payroll-records/request' , 'class' => 'pull-right')) }}
                        <button type="submit" name="activateProfile" class="btn btn-block btn-success" aria-label="Left Align">
                            <span class="glyphicon glyphicon-check" aria-hidden="true"></span> REQUEST
                        </button>
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    
    