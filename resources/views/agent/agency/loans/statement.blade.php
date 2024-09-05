<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loan Statement</title>

    <style>
        
        .receiptHolder {
            font-size: 10px;
            font-family: sans-serif;
            margin: 50px 50px;
        }
        .notdBorder {
            border: 0;
            padding: 0 5px;
        }
        .rightBorder {
            border-right: 1px solid #000;
        }
        tr td{padding:5px 0;}
        tr th{padding:5px 0}      
  
    </style>
</head>
<body>
    
    <div class="receiptHolder" style="border: 1px solid #000;">
        
        <!-- header -->
        <div style="width: 100%">
            <table cellpadding="0" cellspacing="0" class="header-table" style="width: 100%; font-size: 9pt">
                <tbody>
                    <tr>
                        <td colspan="4" style="text-align: center; border-bottom: 1px solid #000; padding: 5px;font-size:30px;font-weight:700">
                            {{ Auth::user()->business->business_name}}
                        </td>
                    </tr>
                    @php
                        $totalcredit = $loan['amount'];
                        $totalpaid = 0;
                    @endphp
                    @endphp
                    <tr style="border-bottom:1px solid #000">
                        <th>Date</th>
                        <th>Name</th>
                        <th>Credit</th>
                        <th>Paid </th>
                    </tr>
                    <tr style="text-align:center;">
                        <td>{!! Carbon\Carbon::parse($loan['created_at'])->format('d.m.Y') !!}</td>
                        <td>paid</td>
                        <td>0</td>
                        <td>{!! money($loan['amount'], currencyCode(), true) !!}</td>
                    </tr>
                    @foreach($loan['payments'] as $payment)
                        @php $totalpaid += $payment['amount']; @endphp
                        <tr style="text-align:center;">
                            <td>{!! Carbon\Carbon::parse($payment['created_at'])->format('d.m.Y') !!}</td>
                            <td>Payment</td>
                            <td>{!! money($payment['amount'], currencyCode(), true) !!}</td>
                            <td>0</td>
                        </tr>
                    @endforeach
                    <tr style="text-align:center;border-top:1px solid #000">
                        <td></td>
                        <td></td>
                        <td>{!! money($totalcredit, currencyCode(), true) !!}</td>
                        <td>{!! money($totalpaid, currencyCode(), true) !!}</td>
                    </tr>
                    <tr style="text-align:center;border-top:1px solid #000">
                        <td colspan="2" style="font-size:18px">Statement</td>
                        <td colspan="2" style="font-size:30px;font-weight:700">{!! money(($totalpaid - $totalcredit), currencyCode(), true) !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
   
    <hr>
</body>
</html>

