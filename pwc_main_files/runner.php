<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Schema::dropIfExists('payroll_bonuses');

Schema::create('payroll_bonuses', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('staff_id');
    $table->string('month_name'); 
    $table->integer('year');
    $table->integer('week_number'); 
    $table->decimal('amount', 10, 2)->default(0);
    $table->timestamps();
});

echo "Table created successfully\n";
