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
    @php
        $physical_balance = $capital = $differ = 0;
    @endphp

    <div class="receiptHolder" style="border: 1px solid #000;">
        
        <!-- header -->
        <div style="width: 100%">
            <table cellpadding="0" cellspacing="0" class="header-table" style="width: 100%; font-size: 9pt">
                <tbody>
                    <tr>
                        <td colspan="6" style=" font-size:30px;font-weight:700; ">
                            {{ $bussiness_summary['name'] }} Report
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right:0">PHYSICAL BALANCES</td>
                        <td style="border-right:0">{{session('currency').' '.number_format($bussiness_summary['physical_balance'],2)}}</td>
                        <td style="border-right:0;font-size:22px;text-transform:capitalize">credit</td>
                        <td colspan=3 style="font-size:22px;text-transform:capitalize">{{session('currency').' '.number_format($bussiness_summary['credit'],2)}}</td>

                    </tr>
                    <tr>
                        <td style="border-right:0">Capital</td>
                        <td style="border-right:0">{{session('currency').' '.number_format($bussiness_summary['capital'],2)}}</td>
                        <td style="border-right:0;font-size:22px;text-transform:capitalize">debit</td>
                        <td colspan=3 style="border-right:0;font-size:22px;text-transform:capitalize">{{session('currency').' '.number_format($bussiness_summary['debit'],2)}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:22px;font-weight:700;border-right:0">Differ</td>
                        <td style="font-size:22px;font-weight:700;  border-right:0">{{session('currency').' '.number_format($bussiness_summary['differ'],2)}}</td>
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
                    @foreach($branch_summary as $summary)
                    @php
                        $physical_balance += $summary['physical_balance'];
                        $capital += $summary['capital'];
                        $differ += $summary['differ'];
                    @endphp
                    <tr>
                        <td>{{ $summary['name'] }}</td>
                        <td>{{session('currency').' '.number_format($summary['physical_balance'],2)}}</td>
                        <td>{{session('currency').' '.number_format($summary['capital'],2)}}</td>
                        <td>{{session('currency').' '.number_format($summary['differ'],2)}} </td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    @endforeach
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
                        <td>{{session('currency').' '.number_format($physical_balance,2)}}</td>
                        <td>{{session('currency').' '.number_format($capital,2)}}</td>
                        <td>{{session('currency').' '.number_format($differ,2)}} </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
   
    <hr>
</body>
</html>

