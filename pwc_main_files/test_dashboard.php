<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Deposit;
use App\Models\ClientPayment;
use App\Models\ClientSchedule;

$deposits = Deposit::all();
echo "Deposits:\n";
foreach($deposits->take(5) as $d) {
    echo "ID: {$d->id}, Total: {$d->total_amount}, Dep: {$d->deposit_amount}, is_dep: {$d->is_deposit}\n";
}

$payments = ClientPayment::where('payment_status', 'unpaid')->take(5)->get();
echo "\nUnpaid Payments:\n";
foreach($payments as $p) {
    echo "ID: {$p->id}, Status: {$p->payment_status}, Type: {$p->payment_type}\n";
}

