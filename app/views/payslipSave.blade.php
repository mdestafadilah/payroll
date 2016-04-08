<html>
<head>
    <style>
        body{
         font-family: arial, sans-serif;
         font-size: small;
         margin-left: 1in;
         color:#463C54;
     }
     td{
        padding: 5px;
        border-bottom: solid;
        border-color: #f0f0f0;
        padding-right: 20px;
    }
</style>
</head>
<body>
    <div class="row" >
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
            <div class="table-responsive" style="background-color:white;">
              <table class="table table-bordered" width="500px">
                <tr>
                    <td colspan="3"><h4 style="text-align:center;">RING SYSTEM DEVELOPMENT INC. </h4><p style="text-align:center;">* PAY SLIP *</p></td>
                </tr>
                <tr>
                    <td colspan="3">{{$coverage}}</td>
                </tr>
                <tr>
                    <td width="200px;">Name</td>
                    <td colspan="2" width="200px;">{{{ucwords($fullname)}}}</td>
                </tr>
                <tr>
                    <td width="200px;">Basic Pay</td>
                    <td colspan="2">{{number_format($salary,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">Allowance</td>
                    <td colspan="2">{{number_format($allowance,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">Overtime</td>
                    <td colspan="2">{{number_format($ot,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">Salary Adjustment</td>
                    <td colspan="2"></td>
                </tr>
                <tr class="border_bottom">
                    <td width="200px;">Gross Pay</td>
                    <td colspan="2">{{number_format($gross,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">W/Tax</td>
                    <td colspan="2">{{number_format($tax,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">SSS</td>
                    <td colspan="2">{{number_format($sss,2,',','.')}}</td>
                </tr>
                <tr>
                    <td width="200px;">HDMF</td>
                    <td colspan="2">{{number_format($pI,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">PHIC</td>
                    <td colspan="2">{{number_format($ph,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">Late Penalty</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td width="200px;">Absences</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td width="200px;">Undertime</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td width="200px;">Total Deductions</td>
                    <td colspan="2">{{number_format($deduction,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td width="200px;">Net Take Home Pay</td>
                    <td colspan="2">{{number_format($net,2,'.',',')}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="height:30px;"></td>
                </tr>
                <tr>
                    <td>Print Name</td>
                    <td>Signature</td>
                    <td>Date</td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>