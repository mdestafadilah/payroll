<html moznomarginboxes mozdisallowselectionprint>
<head>

    <style type="text/css">
        .tdhead{
            width: 400px;
        }
        .tdbody{
            width: 100px;
        }
        tr.border_bottom td {
            border-bottom:2pt solid black;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        tr.border_remover{
            border: 0 !important;
        }
        tr.border_remover td{
            border: 0 !important;
        }
        @page {
           size: A4;
           margin: 10mm 45mm 2mm 45mm; 
       }
   </style>
   <script type="text/javascript">
       window.onload = function() { window.print();}
   </script>
</head>
<body>
 @foreach($employee as $value)
 <table border="1">
    <tr>
     <td  colspan="3"><h4 style="text-align:center;">RING SYSTEM DEVELOPMENT INC. </h4><p style="text-align:center;">* PAY SLIP *</p></td>
 </tr>
 <tr>
    <td colspan="3">{{ $value->coverage }}</td>
</tr>
<tr>
    <td>Name:</td>
    <td colspan="2">{{{ucwords($value->lastname) . ' '. ucwords($value->firstname)}}}</td>
</tr>
<tr>
    <td>Basic Pay</td>
    <td colspan="2">{{ $value->salary }}</td>
</tr>
<tr>
    <td>Allowance</td>
    <td colspan="2">{{ $value->allowance }}</td>
</tr>
<tr>
    <td>Overtime</td>
    <td colspan="2">{{$ot =$value->ot; number_format($value->ot,2,'.',',') }}</td>
</tr>
<tr>
    <td>Salary Adjustment</td>
    <td colspan="2"></td>
</tr>
<tr class="border_bottom">
    <td>Gross Pay</td>
    <td colspan="2"><b>{{number_format($value->grosspay,2,'.',',') }}</b></td>
</tr>
<tr>
    <td>W/Tax</td>
    <td colspan="2">{{$tax = $value->w_tax;number_format($value->w_tax,2,'.',',')}}</td>
</tr>
<tr>
    <td>SSS</td>
    <td colspan="2">{{number_format($sss =$value->sssContrib,2,'.',',') }}</td>
</tr>
<tr>
    <td>HDMF</td>
    <td colspan="2">{{number_format($pI= $value->pagibigContrib,2,'.',',') }}</td>
</tr>
<tr>
    <td>PHIC</td>
    <td colspan="2">{{number_format($ph = $value->philHealthContrib,2,'.',',');}}</td>
</tr>
<tr>
    <td>Late Penalty</td>
    <td colspan="2"></td>
</tr>
<tr>
    <td>Absences</td>
    <td colspan="2"></td>
</tr>
<tr>
    <td>Undertime</td>
    <td colspan="2"></td>
</tr>
<tr class="border_bottom">
    <td>Total Deductions</td>
    <td colspan="2">{{number_format($value->deduction,2,'.',',') }}</td>
</tr>
<tr>
    <td>Net Take Home Pay</td>
    <td colspan="2"><b>{{  number_format($fpay = $value->netpay,2,'.',',')}}</b></td>
</tr>
<tr>
    <td colspan="3" style="height:30px;"></td>
</tr>
<tr>
    <td class="tdbody">Print Name</td>
    <td class="tdbody">Signature</td>
    <td class="tdbody">Date</td>
</tr>
</table>
<br/><br/><br/>
@endforeach
</body>
</html>

