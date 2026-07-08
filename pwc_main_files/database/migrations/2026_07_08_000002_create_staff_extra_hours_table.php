<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_extra_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->string('route_id');
            $table->unsignedTinyInteger('week_number');
            $table->date('week_start_date');
            $table->date('service_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('duration_hours', 8, 2);
            $table->timestamps();

            $table->index(['staff_id', 'route_id', 'week_start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_extra_hours');
    }
};
