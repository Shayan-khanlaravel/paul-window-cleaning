<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import QuickBooks Customers - Paul Window Cleaning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }

        .container {
            max-width: 1400px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
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

        .customer-row.already-imported {
            background-color: #f8f9fa;
            opacity: 0.7;
        }

        .btn-import {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border: none;
            color: white;
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <h5 class="text-muted mb-2">Total in QuickBooks</h5>
                    <h2 class="text-primary mb-0">{{ $total ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h5 class="text-muted mb-2">Already Imported</h5>
                    <h2 class="text-success mb-0">{{ $already_imported ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h5 class="text-muted mb-2">Available to Import</h5>
                    <h2 class="text-warning mb-0">{{ ($total ?? 0) - ($already_imported ?? 0) }}</h2>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">
                    <i class="bi bi-cloud-download"></i> Import Customers from QuickBooks
                </h3>
            </div>
            <div class="card-body">
                @if (session('title'))
                    <div class="alert alert-{{ session('type', 'info') }}">
                        <strong>{{ session('title') }}:</strong> {{ session('message') }}
                        @if (session('errors'))
                            <ul class="mt-2 mb-0">
                                @foreach (session('errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif

                @if (isset($error))
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ $error }}
                    </div>
                @endif

                @if (count($customers) > 0)
                    <form action="{{ route('quickbooks.import.process') }}" method="POST" id="importForm">
                        @csrf

                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">
                                <i class="bi bi-check-all"></i> Select All New
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                                <i class="bi bi-x-circle"></i> Deselect All
                            </button>
                            <span class="ms-3 text-muted">
                                <span id="selectedCount">0</span> customer(s) selected
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleAll(this)">
                                        </th>
                                        <th>QB ID</th>
                                        <th>Name</th>
                                        <th>Matched</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Address</th>
                                        <th>Address</th>
                                        <th>Address</th>
                                        <th>Address</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $item)
                                        @php
                                            $customer = $item['qb_data'];
                                            $alreadyImported = $item['already_imported'];
                                        @endphp
                                        <tr class="customer-row {{ $alreadyImported ? 'already-imported' : '' }}">
                                            <td>
                                                @if (!$alreadyImported)
                                                    <input type="checkbox" name="customer_ids[]"
                                                        value="{{ $customer->Id }}" class="customer-checkbox"
                                                        onchange="updateCount()">
                                                @else
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                @endif
                                            </td>
                                            <td><code>{{ $customer->Id }}</code></td>
                                            <td>
                                                <strong>{{ $customer->DisplayName ?? ($customer->CompanyName ?? 'N/A') }}</strong>
                                                @if ($alreadyImported)
                                                    <span class="badge bg-success ms-2">Imported</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($alreadyImported)
                                                    <span class="badge bg-primary">
                                                        <i class="bi bi-check-circle"></i> Matched in Database
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Not in Pauls DB</span>
                                                @endif
                                            </td>
                                            <td>{{ $customer->PrimaryEmailAddr->Address ?? 'N/A' }}</td>
                                            <td>{{ $customer->PrimaryPhone->FreeFormNumber ?? 'N/A' }}</td>
                                            <td>
                                                <strong>{{ $customer->BillAddr->Line1 ?? '' }}</strong> <br>
                                            </td>
                                            <td>
                                                <strong>{{ $customer->BillAddr->City ?? '' }}</strong> <br>
                                            </td>
                                            <td>
                                                <strong>{{ $customer->BillAddr->CountrySubDivisionCode ?? '' }}</strong>
                                                <br>
                                            </td>
                                            <td>
                                                <strong>{{ $customer->BillAddr->PostalCode ?? '' }}</strong> <br>
                                            </td>
                                            <td>
                                                <strong>{{ $customer->BillAddr->Country ?? '' }}</strong> <br>
                                            </td>
                                            <td>
                                                <strong>{{ $customer->BillAddr->Line2 ?? '' }}</strong> <br>
                                            </td>

                                            <td>
                                                @if ($customer->Active ?? true)
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

                        <div class="mt-4">
                            <button type="submit" class="btn btn-import btn-lg" id="importBtn" disabled>
                                <i class="bi bi-cloud-download"></i> Import Selected Customers
                            </button>
                            <a href="/dashboard_index" class="btn btn-secondary btn-lg">
                                <i class="bi bi-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning">
                        <strong>No customers found!</strong>
                        @if (isset($message))
                            {{ $message }}
                        @else
                            Please make sure you have customers in QuickBooks.
                        @endif
                    </div>
                    <div class="mt-3">
                        <a href="/dashboard_index" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateCount() {
            const checked = document.querySelectorAll('.customer-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = checked;
            document.getElementById('importBtn').disabled = checked === 0;
        }

        function toggleAll(checkbox) {
            const checkboxes = document.querySelectorAll('.customer-checkbox');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
            updateCount();
        }

        function selectAll() {
            const checkboxes = document.querySelectorAll('.customer-checkbox');
            checkboxes.forEach(cb => cb.checked = true);
            document.getElementById('selectAllCheckbox').checked = true;
            updateCount();
        }

        function deselectAll() {
            const checkboxes = document.querySelectorAll('.customer-checkbox');
            checkboxes.forEach(cb => cb.checked = false);
            document.getElementById('selectAllCheckbox').checked = false;
            updateCount();
        }

        // Confirm before import
        document.getElementById('importForm')?.addEventListener('submit', function(e) {
            const count = document.querySelectorAll('.customer-checkbox:checked').length;
            if (!confirm(`Are you sure you want to import ${count} customer(s)?`)) {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>
