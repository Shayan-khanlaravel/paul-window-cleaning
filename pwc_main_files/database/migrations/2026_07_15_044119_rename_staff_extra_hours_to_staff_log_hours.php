<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('staff_extra_hours') && !Schema::hasTable('staff_log_hours')) {
            Schema::rename('staff_extra_hours', 'staff_log_hours');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('staff_log_hours') && !Schema::hasTable('staff_extra_hours')) {
            Schema::rename('staff_log_hours', 'staff_extra_hours');
        }
    }
};
