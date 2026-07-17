<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_extra_hours', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('route_id')->constrained('staff_routes')->onDelete('cascade');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('per_hour_amount', 10, 2)->default(0);
            $table->decimal('total_extra_hours', 10, 2)->default(0);
            $table->decimal('total_extra_amount', 10, 2)->default(0);
            $table->foreignUuid('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['route_id', 'period_start', 'period_end']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_extra_hours');
    }
};
