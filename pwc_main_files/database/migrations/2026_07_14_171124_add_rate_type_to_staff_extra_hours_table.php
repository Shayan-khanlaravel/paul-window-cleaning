<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('staff_extra_hours', function (Blueprint $table) {
            $table->enum('rate_type', ['normal', 'training'])->default('normal')->after('end_time');
            $table->decimal('rate_amount', 10, 2)->nullable()->after('rate_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_extra_hours', function (Blueprint $table) {
            $table->dropColumn(['rate_type', 'rate_amount']);
        });
    }
};
