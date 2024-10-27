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
                        @if(file_exists(public_path('storage/'.Auth::user()->business->business_logo)))
                            <td colspan="5" style="text-align: center;">
                                <img src="{{ public_path('storage/'.Auth::user()->business->business_logo) }}" alt="{{ Auth::user()->business->business_name }}" width="600px">
                            </td>
                        @else
                            <td colspan="5" style="text-align: center; border-bottom: 1px solid #000; padding: 5px;font-size:30px;font-weight:700">
                                {{ Auth::user()->business->business_name}}
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: center; border-bottom: 1px solid #000; padding: 5px;font-size:20px;font-weight:700">
                            STATEMENTS OF CAPITAL IS OUTSIDE ROTATIONS
                        </td>
                    </tr>
                    <tr style="text-align: center; border-bottom: 1px solid #000; padding: 5px;font-size:16px;font-weight:700;background-color:#000;">
                        <th colspan="2" align="left" style="color:#fff;padding-left:10px">CREDITED NAME</th>
                        <th colspan="3" align="left" style="color:#fff">BOSS HUSSEIN</th>
                    </tr>

                    <tr style="border-bottom:1px solid #000">
                        <th>DATE</th>
                        <th>NETWORK</th>
                        <th>NAME</th>
                        <th>CREDIT</th>
                        <th>PAID </th>
                    </tr>
                    @foreach ($data['entries'] as $loan)
                        <tr style="text-align:center;">
                            <td>{!! Carbon\Carbon::parse($loan['created_at'])->format('d.m.Y') !!}</td>
                            <td>{!! $loan['network'] !!}</td>
                            <td>{!! $loan['user'] !!}</td>
                            <td>{!! money($loan['credit'], currencyCode(), true) !!}</td>
                            <td>{!! money($loan['paid'], currencyCode(), true) !!}</td>
                        </tr>
                    @endforeach
                    <tr style="text-align:center;border-top:1px solid #000">
                        <td colspan=3></td>
                        <td>{!! money($data['total_credit'], currencyCode(), true) !!}</td>
                        <td>{!! money($data['total_paid'], currencyCode(), true) !!}</td>
                    </tr>
                    <tr style="text-align:center;border-top:1px solid #000">
                        <td colspan="3" style="font-size:18px">UNPAID</td>
                        <td colspan="2" style="font-size:30px;font-weight:700">{!! money(($data['total_paid'] - $data['total_credit']), currencyCode(), true) !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
   
    <hr>
</body>
</html>