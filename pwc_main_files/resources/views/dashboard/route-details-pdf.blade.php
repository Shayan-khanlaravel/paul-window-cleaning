<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Details PDF</title>
    <!-- Font Awesome Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        @page {
            size: A4;
            margin: 10px;
        }
        /*.printArea{  position: relative;}*/
        .table_wrapper {width:20%;display:inline-block;vertical-align:top;}
    </style>
</head>

<body style=" font-family: Arial, sans-serif;font-size: 12px;margin: 0;padding: 0;width: 100%; -webkit-print-color-adjust: exact;">
    <div id="printArea" class="printArea">
        <h2 style="text-align: center" class="">{{$staffRoute->name??''}}</h2>
            @foreach ($mergedSchedules as $schedule)
                @php
                    $cashTotal = 0;
                    $invoiceTotal = 0;
                    foreach ($schedule['routes'] as $route) {
                        if ($route['payment_type'] === 'cash') {
                            $cashTotal += $route['invoice_amount'];
                        } elseif ($route['payment_type'] === 'invoice') {
                            $invoiceTotal += $route['invoice_amount'];
                        }
                    }
                    $total = $cashTotal + $invoiceTotal;
                @endphp
            <div class="week_block" style="display:inline-block; width: 23%; padding: 5px; vertical-align: top;">
                <div class="" style=" padding: 10px;display:inline-block;width: 100%; " >
                    <div style="border-radius: 10px; background: #CCEFFC; padding: 15px 5px; text-align: center; ">
                        <label class="small-text" style=" font-size: 10px;">Week {{ $schedule['week_number'] }}</label>
                        <span class="small-text" style=" font-size: 10px;">{{ \Carbon\Carbon::parse($schedule['start_date'])->format('d F') }} - {{ \Carbon\Carbon::parse($schedule['end_date'])->format('d F') }}</span>
                    </div>
                    <div class="small-text " style="padding: 10px 5px; border-bottom: 0.5px solid #D0D0D0;font-size: 10px;">
                        <div>
                            <label>Cash Total :</label>
                            <span style="float: right;">${{ number_format($cashTotal, 2) }}</span>
                        </div>
                        <div style="padding: 10px 0px;">
                            <label>Invoice Total :</label>
                            <span style="float: right;">${{ number_format($invoiceTotal, 2) }}</span>
                        </div>
                        <div>
                            <label>Total :</label>
                            <span style="float: right;">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
                @forelse ($schedule['routes'] as $key => $route)
                    <div class="" style=" border-radius: 20px; border: 1px solid #E7E7E7; background: #FFF; box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.05); padding: 5px; margin-top: 20px;display:inline-block;width: 100%;">
                        <div style="border-radius: 10px; background: #CCEFFC; padding: 5px;">
                            <h3 class="small-text" style=" font-size: 10px;">{{ ucfirst($route['client_name']) }}</h3>
                            <div>
                                <label>{{ ucfirst($route['payment_type']) }}</label>
                                <h6 class="small-text" style=" font-size: 10px;"><strong>Total: </strong>${{ number_format($route['invoice_amount'], 2) }}</h6>
                                @foreach($route['multiPrice'] ?? [] as $price)
                                    <h6 class="small-text" style=" font-size: 10px;"><strong>{{ $price['name'] ?? '' }}</strong>: ${{ number_format($price['value'],2) ??'' }}</h6>
                                @endforeach
                            </div>
                            <div>
                                <label>Best Time To Service:</label>
                                @foreach($route['client_hours'] ?? [] as $hour)
                                    <h6 class="small-text" style=" font-size: 10px;">{{ $hour['start_hour'] ?? '' }} - {{ $hour['end_hour'] ?? '' }}</h6>
                                @endforeach
                            </div>
                            <div>
                                <label>Address:</label>
                                <h6 class="small-text" style=" font-size: 10px;">{{ $route['address'] ?? 'Not Available' }}</h6>
                            </div>
                            <div>
                                <h5>Notes For Week {{ $schedule['week_number'] }} :</h5>
                                <h6 class="small-text" style=" font-size: 10px;">{{ $route['note'] }}</h6>
                            </div>
                            <div>
                                <h5>Job Description</h5>
                                <h6 class="small-text" style=" font-size: 10px;">{{ $route['client_job']??''}}</h6>
                            </div>
                        </div>
                        <div style="color: {{ $route['is_completed'] ? 'green' : 'black' }}; border-radius: 10px; background: #F5FAF2; padding: 10px 15px; margin-top: 10px;">
                            <span class="small-text" style=" font-size: 10px;">{{ $route['is_completed'] ? 'Completed' : 'Pending' }}</span>
                        </div>
                    </div>
                @empty
                    <div>
                        <h6 class="" style="text-align:center;font-size: 10px;">No Data Available</h6>
                    </div>
                @endforelse
            </div>
        @endforeach
    </div>
</body>


{{--second--}}
{{--<body style="font-family: Arial, sans-serif;font-size: 12px;margin: 0;padding: 0;width: 100%;height: 100%; -webkit-print-color-adjust: exact;vertical-align: top;">--}}
{{--<div>--}}
    {{--<div id="printArea">--}}
        {{--<h2 style="text-align: center";>{{$staffRoute->name??''}}</h2>--}}
        {{--@foreach ($mergedSchedules as $schedule)--}}
        {{--@php--}}
            {{--$cashTotal = 0;--}}
            {{--$invoiceTotal = 0;--}}
            {{--foreach ($schedule['routes'] as $route) {--}}
                {{--if ($route['payment_type'] === 'cash') {--}}
                    {{--$cashTotal += $route['invoice_amount'];--}}
                {{--} elseif ($route['payment_type'] === 'invoice') {--}}
                    {{--$invoiceTotal += $route['invoice_amount'];--}}
                {{--}--}}
            {{--}--}}
            {{--$total = $cashTotal + $invoiceTotal;--}}
        {{--@endphp--}}
        {{--<div class="table_wrapper">--}}
            {{--<table class="table" style="">--}}
                {{--<thead>--}}
                {{--<tr>--}}
                    {{--<th style="border-radius: 10px; background: #CCEFFC; padding: 15px 5px; text-align: center; ">--}}
                        {{--<label class="small-text" style=" font-size: 10px;">Week {{ $schedule['week_number'] }}</label>--}}
                        {{--<span class="small-text" style=" font-size: 10px;">{{ $schedule['start_date'] }} - {{ $schedule['end_date'] }}, {{ $schedule['month'] }}</span>--}}
                    {{--</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--<tr>--}}
                    {{--<td>--}}
                        {{--<div>--}}
                            {{--<label>Cash Total :</label>--}}
                            {{--<span style="float: right;">${{ number_format($cashTotal, 2) }}</span>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<label>Invoice Total :</label>--}}
                            {{--<span style="float: right;">${{ number_format($invoiceTotal, 2) }}</span>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<label>Total :</label>--}}
                            {{--<span style="float: right;">${{ number_format($total, 2) }}</span>--}}
                        {{--</div>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--</tbody>--}}
                {{--<tfoot>--}}
                {{--@forelse ($schedule['routes'] as $route)--}}
                    {{--<tr style="border-radius: 20px; border: 1px solid #E7E7E7; background: #FFF; box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.05); padding: 5px; margin-top: 20px;">--}}
                        {{--<td>--}}
                            {{--<div style="border-radius: 10px; background: #CCEFFC; padding: 5px;">--}}
                                {{--<h3 class="small-text" style=" font-size: 10px;">{{ ucfirst($route['client_name']) }}</h3>--}}
                                {{--<div>--}}
                                    {{--<label>{{ ucfirst($route['payment_type']) }}</label>--}}
                                    {{--<h6 class="small-text" style=" font-size: 10px;">${{ number_format($route['invoice_amount'], 2) }}</h6>--}}
                                {{--</div>--}}
                                {{--<div>--}}
                                    {{--<label>Address:</label>--}}
                                    {{--<h6 class="small-text" style=" font-size: 10px;">{{ $route['address'] ?? 'Not Available' }}</h6>--}}
                                {{--</div>--}}
                                {{--<div>--}}
                                    {{--<label>Additional Notes:</label>--}}
                                    {{--<h6 class="small-text" style=" font-size: 10px;">{{ $route['note'] }}</h6>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div style="border-radius: 10px; background: #F5FAF2; padding: 10px 15px; margin-top: 10px;">--}}
                                {{--<span class="small-text" style=" font-size: 10px;color: {{ $route['is_completed'] ? 'green' : 'black' }};">{{ $route['is_completed'] ? 'Completed' : 'Pending' }}</span>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--@empty--}}
                    {{--<tr>--}}
                        {{--<div>--}}
                            {{--<h6 class="" style="text-align:center;font-size: 10px;">No Data Available</h6>--}}
                        {{--</div>--}}
                    {{--</tr>--}}
                {{--@endforelse--}}
                {{--</tfoot>--}}
            {{--</table>--}}
        {{--</div>--}}

        {{--@endforeach--}}
    {{--</div>--}}
{{--</div>--}}
{{--</body>--}}

</html>
