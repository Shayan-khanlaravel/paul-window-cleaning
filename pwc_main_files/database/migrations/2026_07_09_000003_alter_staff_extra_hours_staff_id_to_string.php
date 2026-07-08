<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('staff_extra_hours')) {
            return;
        }

        // In this project, `users.id` is stored as a string (UUID/char). Ensure matching type.
        DB::statement('ALTER TABLE staff_extra_hours MODIFY staff_id VARCHAR(255) NOT NULL');
    }

    public function down(): void
    {
        // No safe automatic down conversion (could lose UUID values).
    }
};

