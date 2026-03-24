@extends('theme.layout.master')
@push('css')

@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Invoice </h2>
    </div>

    <div class="custom_search txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input custom_search_box">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection
@section('content')
    <section class="client_management staff_manag">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <div class="clients_tab custom_justify_between">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
{{--                                <li class="nav-item" role="presentation">--}}
{{--                                    <button class="nav-link " id="pills-clients-tab" data-bs-toggle="pill"--}}
{{--                                            data-bs-target="#pills-clients" type="button" role="tab"--}}
{{--                                            aria-controls="pills-clients" aria-selected="true">Staff--}}
{{--                                    </button>--}}
{{--                                </li>--}}
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-potential_clients-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-potential_clients" type="button" role="tab"
                                            aria-controls="pills-potential_clients" aria-selected="false">Client
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
{{--                            <div class="tab-pane fade" id="pills-clients" role="tabpanel"--}}
{{--                                 aria-labelledby="pills-clients-tab" tabindex="0">--}}
{{--                                <div class="custom_table">--}}
{{--                                    <div class="table-responsive">--}}
{{--                                        <table class="table ">--}}
{{--                                            <thead>--}}
{{--                                            <tr>--}}
{{--                                                <th>Name</th>--}}
{{--                                                <th>Gross Pay</th>--}}
{{--                                                <th>Bonus</th>--}}
{{--                                                <th>Total Pay</th>--}}
{{--                                            </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}
{{--                                            @forelse($staffInvoices as $staffInvoice)--}}
{{--                                                <tr>--}}
{{--                                                    <td colspan="1"><h4 class="pt-3">{{ strtoupper('Staff Payroll') }}</h4></td>--}}
{{--                                                    <td colspan="2"> </td>--}}
{{--                                                    <td colspan="1" class="d-flex justify-content-end align-items-center">--}}
{{--                                                        <h4 style="margin-right: 20px">--}}
{{--                                                            {{ strtoupper($staffInvoice['start_date']) }}--}}
{{--                                                            - {{ strtoupper($staffInvoice['end_date']) }}--}}
{{--                                                        </h4>--}}
{{--                                                        <button type="button" id="exportExcel"--}}
{{--                                                                class="btn_global btn_dark_blue exportBtn exportExcel">Export Excel <i--}}
{{--                                                                class="fa-solid fa-file-excel"></i>--}}
{{--                                                        </button>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                @foreach($staffInvoice['staffs'] as $staffIndex => $staff)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{{ $staffIndex ?? '' }}</td>--}}
{{--                                                        <td>$ {{ $staff->sum('invoice_amount') }} </td>--}}
{{--                                                        <td>$0.00</td>--}}
{{--                                                        <td>$ {{ $staff->sum('invoice_amount') }}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
{{--                                                <tr style="border:1px solid #ce0d0d;">--}}
{{--                                                    <td colspan="1"><h3>{{ strtoupper('Total Gross') }}</h3></td>--}}
{{--                                                    <td colspan="1"><h3>$ {{ $staffInvoice['total_gross'] ?? '' }}</h3>--}}
{{--                                                    </td>--}}
{{--                                                    <td colspan="2"> </td>--}}
{{--                                                </tr>--}}
{{--                                            @empty--}}
{{--                                                <tr>--}}
{{--                                                    <td colspan="4">No staffs invoices found!</td>--}}
{{--                                                </tr>--}}
{{--                                            @endforelse--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="tab-pane active show fade" id="pills-potential_clients" role="tabpanel"
                                 aria-labelledby="pills-potential_clients-tab" tabindex="0">
                                <div class="custom_table">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Route</th>
                                                <th>Gross Total</th>
{{--                                                <th>50% / Bonus</th>--}}
{{--                                                <th>Net Pay</th>--}}
{{--                                                <th>Date Paid</th>--}}
{{--                                                <th>Cash Received</th>--}}
                                                <th>View Invoice's</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($routeInvoices as $invoice)
                                                @foreach($invoice['routes'] as $routIndex => $route)
                                                    <tr class="route-invoice">
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($invoice['start_date'])->format('M,') }}
                                                            {{ \Carbon\Carbon::parse($invoice['start_date'])->format('d') }}
                                                            thru
                                                            {{ \Carbon\Carbon::parse($invoice['end_date'])->format('d') }}
                                                            {{ \Carbon\Carbon::parse($invoice['end_date'])->format('M, Y') }}
                                                        </td>
                                                        <td>{{ $routIndex }}</td>
                                                        <td>$ {{ $route->sum('invoice_amount') }}</td>
{{--                                                        <td>$0.00</td>--}}
{{--                                                        <td>$0.00</td>--}}
{{--                                                        <td>N/A</td>--}}
{{--                                                        <td>--}}
{{--                                                            $ {{ $route->where('payment_type' , 'cash')->sum('invoice_amount') }}--}}
{{--                                                        </td>--}}
                                                        <td>
                                                            <a href="{{ route('schedule.route.invoices', $route->id) }}?start_date={{ Carbon\Carbon::parse($invoice['start_date'])->format('Y-m-d') }}&end_date={{ Carbon\Carbon::parse($invoice['end_date'])->format('Y-m-d') }}"
                                                               class="btn btn-primary">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr style="border:1px solid black;">
                                                    <td colspan="2"><h3>{{ strtoupper('Total Week Gross') }}</h3></td>
                                                    <td colspan="1"><h3>
                                                            $ {{ $invoice['week_gross_total'] ?? '0.00' }}</h3>
                                                    </td>
                                                    <td colspan="5" class="text-end" style="padding-right:20px ">
                                                        <button type="button" id="exportClientExcel"
                                                                class="btn_global btn_dark_blue exportBtn exportClientExcel">Export Excel <i
                                                                class="fa-solid fa-file-excel"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8">No route invoice found!</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>

        $(document).ready(function () {
``
            $(".exportClientExcel").click(function () {
                let exportData = [];

                let currentRow = $(this).closest("tr").prev();
                console.log(currentRow);
                let startDate = currentRow.find("td:nth-child(1)").text().trim();
                let endDate = currentRow.find("td:nth-child(2)").text().trim();

                currentRow.prevAll().each(function () {
                        if (!$(this).find("td:first").text().includes("TOTAL WEEK GROSS")) {
                            let date = $(this).find("td:nth-child(1)").text().trim();
                    let route = $(this).find("td:nth-child(2)").text().trim();
                    let grossTotal = $(this).find("td:nth-child(3)").text().trim();
                    let bonus = $(this).find("td:nth-child(4)").text().trim();
                    let netPay = $(this).find("td:nth-child(5)").text().trim();
                    let datePaid = $(this).find("td:nth-child(6)").text().trim();
                    let cashReceived = $(this).find("td:nth-child(7)").text().trim();

                    exportData.push({
                        "Date": date,
                        "Route": route,
                        "Gross Total": grossTotal,
                        "50% / Bonus": bonus,
                        "Net Pay": netPay,
                        "Date Paid": datePaid,
                        "Cash Received": cashReceived,
                    });
                    }else{
                        console.log($(this));
                        return false;

                    }
                });

                if (exportData.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "No Data Available!",
                        text: "There is no data to export for this invoice.",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                let fileName = "Route_Invoice_Report_" + startDate.replace(/\//g, '-') + "_" + endDate.replace(/\//g, '-') + ".xlsx";

                let ws = XLSX.utils.json_to_sheet(exportData);

                let wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Route Invoice');

                XLSX.writeFile(wb, fileName);

                Swal.fire({
                    icon: "success",
                    title: "Export Successful!",
                    text: "Your Excel file has been downloaded.",
                    confirmButtonColor: "#28a745",
                    confirmButtonText: "OK"
                });
            });

            $(".exportExcel").click(function () {
                let exportData = [];

                let currentRow = $(this).closest("tr");

                let startDate = currentRow.find("td:last").text().split(" - ")[0].trim();
                let endDate = currentRow.find("td:last").text().split(" - ")[1].trim();

                let totalGross = 0;
                currentRow.nextAll().each(function () {
                    if ($(this).find("td").length > 1 && !$(this).find("td:first").text().includes("TOTAL GROSS")) {
                        let name = $(this).find("td:nth-child(1)").text().trim();
                        let grossPay = $(this).find("td:nth-child(2)").text().trim();
                        let bonus = $(this).find("td:nth-child(3)").text().trim();
                        let totalPay = $(this).find("td:nth-child(4)").text().trim();

                        totalGross += parseFloat(grossPay.replace('$', '').replace(',', ''));

                        exportData.push({
                            "Start Date": startDate,
                            "End Date": endDate,
                            "Name": name,
                            "Gross Pay": grossPay,
                            "Bonus": bonus,
                            "Total Pay": totalPay,
                        });
                    }

                    if ($(this).find("td:first").text().includes("TOTAL GROSS")) {
                        let totalGrossRow = $(this).find("td:nth-child(2)").text().trim();
                        exportData.push({
                            "Name": "TOTAL GROSS",
                            "Gross Pay": totalGrossRow,
                            "Bonus": "",
                            "Total Pay": totalGrossRow,
                        });
                        return false;
                    }
                });

                if (exportData.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "No Data Available!",
                        text: "There is no data to export for this invoice.",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                let fileName = "Staff_Invoice_Report_" + startDate.replace(/\//g, '-') + "_" + endDate.replace(/\//g, '-') + ".xlsx";

                let ws = XLSX.utils.json_to_sheet(exportData);
                let wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Staff Invoice');

                XLSX.writeFile(wb, fileName);

                Swal.fire({
                    icon: "success",
                    title: "Export Successful!",
                    text: "Your Excel file has been downloaded.",
                    confirmButtonColor: "#28a745",
                    confirmButtonText: "OK"
                });
            });

        });

    </script>
@endpush
