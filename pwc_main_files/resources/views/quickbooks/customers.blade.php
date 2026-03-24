<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickBooks Customers - Paul Window Cleaning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .container {
            max-width: 1200px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .table {
            margin-bottom: 0;
        }
        .badge {
            padding: 8px 12px;
            font-size: 12px;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">
                    <i class="bi bi-people-fill"></i> QuickBooks Customers
                </h3>
            </div>
            <div class="card-body">
                @if(isset($error))
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ $error }}
                    </div>
                @endif

                @if(isset($message))
                    <div class="alert alert-info">
                        {{ $message }}
                    </div>
                @endif

                @if(count($customers) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Available</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td><code>{{ $customer->Id }}</code></td>
                                        <td><strong>{{ $customer->DisplayName ?? $customer->CompanyName ?? 'N/A' }}</strong></td>
                                        <td>
                                            @if($customer->is_matched)
                                                <span class="badge bg-primary">
                                                    <i class="fa fa-check-circle"></i> Matched in Database
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">Not in Local DB</span>
                                            @endif
                                        </td>
                                        <td>{{ $customer->PrimaryEmailAddr->Address ?? 'N/A' }}</td>
                                        <td>{{ $customer->PrimaryPhone->FreeFormNumber ?? 'N/A' }}</td>
                                        <td>
                                            @if(isset($customer->BillAddr))
                                                {{ $customer->BillAddr->Line1 ?? '' }}<br>
                                                {{ $customer->BillAddr->City ?? '' }} {{ $customer->BillAddr->PostalCode ?? '' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ isset($customer->MetaData->CreateTime) ? \Carbon\Carbon::parse($customer->MetaData->CreateTime)->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            @if($customer->Active === 'true' || $customer->Active === true)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <strong>No customers found!</strong> Create a client in your system to sync to QuickBooks.
                    </div>
                @endif

                <div class="mt-4">
                    <a href="/dashboard_index" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Dashboard
                    </a>
                    <a href="{{ route('quickbooks.test') }}" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Test Connection
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

