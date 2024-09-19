<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>

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
        tr td{padding:5px;text-transform: uppercase;border-bottom:1px solid #000;font-style: italic;font-weight:600;font-size:16px;text-align: center;border-right:1px solid #000;}
        tr td:last-child{border-right:0}
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
                        <td colspan="6" style=" font-size:30px;font-weight:700; ">
                            {{ Auth::user()->business->business_name}} Report
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right:0">PHYSICAL BALANCES</td>
                        <td style="border-right:0">1000</td>
                        <td style="border-right:0;font-size:22px;text-transform:capitalize">credit</td>
                        <td colspan=3 style="font-size:22px;text-transform:capitalize">85,000</td>

                    </tr>
                    <tr>
                        <td style="border-right:0">Capital</td>
                        <td style="border-right:0">1000 </td>
                        <td style="border-right:0;font-size:22px;text-transform:capitalize">debit</td>
                        <td colspan=3 style="border-right:0;font-size:22px;text-transform:capitalize">0</td>

                    </tr>
                    <tr>
                        <td style="font-size:22px;font-weight:700;border-right:0">Differ</td>
                        <td style="font-size:22px;font-weight:700;  border-right:0">17187</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Companies</td>
                        <td>physical balances</td>
                        <td>CAPITAL BALANCES</td>
                        <td>DIFFER </td>
                        <td>jina</td>
                        <td>nadai</td>
                    </tr>
                    <tr>
                        <td>cash</td>
                        <td>92,000</td>
                        <td>5,00,000</td>
                        <td>-4,95,000 </td>
                        <td>kalthium</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>selcom super</td>
                        <td></td>
                        <td>3,00,000</td>
                        <td>-3,00,000 </td>
                        <td>tgshop</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>tigopesa normal</td>
                        <td>4035</td>
                        <td>1,00,000</td>
                        <td> -9,95,965 </td>
                        <td>taylor</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>tigopesa super</td>
                        <td>0</td>
                        <td>1,00,000</td>
                        <td> -1,00,000 </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>mpesa super</td>
                        <td>40,837</td>
                        <td>5,00,000</td>
                        <td>-4,59,163 </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>halopesa Normal</td>
                        <td>4268</td>
                        <td>3,00,000</td>
                        <td>-2,95,732 </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>halopesa super</td>
                        <td>0</td>
                        <td>2,00,000</td>
                        <td>-2,00,000 </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="height:24px"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style=" height:24px"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style=" height:24px"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="height:24px"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>1,59,881</td>
                        <td>4,500,000</td>
                        <td>4,434,009 </td>
                        <td></td>
                        <td>300,000</td>
                    </tr>
                    <tr>
                        <td style="border-bottom:0"></td>
                        <td style="border-bottom:0">332,921</td>
                        <td style="border-bottom:0">11,261,000</td>
                        <td style="border-bottom:0"> -2,153,951 </td>
                        <td style="border-bottom:0"></td>
                        <td style="border-bottom:0"></td>
                    </tr>

                    {{-- @php
                        $totalcredit = $loan['amount'];
                        $totalpaid = 0;
                    @endphp
                    @endphp
                    <tr style="border-bottom:1px solid #000">
                        <th>Date</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Credit</th>
                        <th>Paid </th>
                    </tr>
                    <tr style="text-align:center;">
                        <td>{!! Carbon\Carbon::parse($loan['created_at'])->format('d.m.Y') !!}</td>
                        <td>paid</td>
                        <td>{!! $loan['network'] ? $loan['network']['name'] : "Cash" !!}</td>
                        <td>0</td>
                        <td>{!! money($loan['amount'], currencyCode(), true) !!}</td>
                    </tr>
                    @foreach($loan['payments'] as $payment)
                        @php $totalpaid += $payment['amount']; @endphp
                        <tr style="text-align:center;">
                            <td>{!! Carbon\Carbon::parse($payment['created_at'])->format('d.m.Y') !!}</td>
                            <td>Payment</td>
                            <td>{!! $payment['network'] ? $payment['network']['name'] : "Cash" !!}</td>
                            <td>{!! money($payment['amount'], currencyCode(), true) !!}</td>
                            <td>0</td>
                        </tr>
                    @endforeach
                    <tr style="text-align:center;border-top:1px solid #000">
                        <td colspan=3></td>
                        <td>{!! money($totalcredit, currencyCode(), true) !!}</td>
                        <td>{!! money($totalpaid, currencyCode(), true) !!}</td>
                    </tr>
                    <tr style="text-align:center;border-top:1px solid #000">
                        <td colspan="3" style="font-size:18px">Statement</td>
                        <td colspan="2" style="font-size:30px;font-weight:700">{!! money(($totalpaid - $totalcredit), currencyCode(), true) !!}</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
   
    <hr>
</body>
</html>

