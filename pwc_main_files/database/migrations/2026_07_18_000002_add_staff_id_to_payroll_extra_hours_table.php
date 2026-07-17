<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\PayrollExtraHour;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_extra_hours', function (Blueprint $table) {
            // A plain index on route_id must exist before the unique index (which
            // currently backs the route_id foreign key) can be dropped.
            $table->index('route_id', 'payroll_extra_hours_route_id_index');
        });

        Schema::table('payroll_extra_hours', function (Blueprint $table) {
            $table->dropUnique('payroll_extra_hours_route_id_period_start_period_end_unique');
        });

        Schema::table('payroll_extra_hours', function (Blueprint $table) {
            $table->foreignUuid('staff_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        });

        // Backfill: this table pre-dates the staff scoping, existing rows were
        // only ever entered from a single staff's payroll detail page, so the
        // route's assigned staff (via completed schedules in that period) is
        // the correct owner.
        foreach (PayrollExtraHour::whereNull('staff_id')->get() as $extraHours) {
            $staffId = DB::table('client_schedules')
                ->join('client_routes', 'client_routes.client_id', '=', 'client_schedules.client_id')
                ->where('client_routes.route_id', $extraHours->route_id)
                ->where('client_schedules.status', 'completed')
                ->whereBetween('client_schedules.service_date', [$extraHours->period_start, $extraHours->period_end])
                ->value('client_schedules.staff_id');

            if ($staffId) {
                PayrollExtraHour::where('id', $extraHours->id)->update(['staff_id' => $staffId]);
            }
        }

        // Any row that couldn't be backfilled (no matching schedule found) is
        // orphaned data from before staff-scoping and is no longer meaningful.
        PayrollExtraHour::whereNull('staff_id')->delete();

        // Raw statement to avoid requiring doctrine/dbal just for a NOT NULL change.
        DB::statement('ALTER TABLE payroll_extra_hours MODIFY staff_id CHAR(36) NOT NULL');

        Schema::table('payroll_extra_hours', function (Blueprint $table) {
            $table->unique(['staff_id', 'route_id', 'period_start', 'period_end'], 'payroll_extra_hours_staff_route_period_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_extra_hours', function (Blueprint $table) {
            $table->dropUnique('payroll_extra_hours_staff_route_period_unique');
            $table->dropConstrainedForeignId('staff_id');
            $table->dropIndex('payroll_extra_hours_route_id_index');
        });

        Schema::table('payroll_extra_hours', function (Blueprint $table) {
            $table->unique(['route_id', 'period_start', 'period_end']);
        });
    }
};
