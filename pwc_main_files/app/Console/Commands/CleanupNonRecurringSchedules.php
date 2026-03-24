<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClientSchedule;
use App\Models\Client;
use Carbon\Carbon;

class CleanupNonRecurringSchedules extends Command
{
    protected $signature = 'schedules:cleanup-non-recurring';
    protected $description = 'Delete schedules that exceed non-recurring iteration limits';

    public function handle()
    {
        $this->info('Starting cleanup of non-recurring schedules...');
        
        $clients = Client::where('service_frequency', 'normalWeek')
            ->where('recurring_type', 'non_recurring')
            ->get();
        
        $deletedCount = 0;
        
        foreach ($clients as $client) {
            $this->info("Processing client: {$client->name} (ID: {$client->id})");
            
            $schedules = ClientSchedule::where('client_id', $client->id)
                ->whereNotNull('note_type')
                ->whereNotNull('note_date')
                ->get();
            
            foreach ($schedules as $schedule) {
                $noteType = $schedule->note_type;
                $noteDate = $schedule->note_date;
                
                if (!$noteType || !$noteDate || $noteType === 'weekly') {
                    continue;
                }
                
                $maxIterations = 14;
                if ($noteType === '12_weeks') {
                    $maxIterations = 3;
                } elseif ($noteType === '24_weeks') {
                    $maxIterations = 6;
                } elseif ($noteType === '52_weeks') {
                    $maxIterations = 13;
                } elseif ($noteType === '8_weeks') {
                    $maxIterations = 2;
                } elseif ($noteType === '4_weeks') {
                    $maxIterations = 1;
                }
                
                $noteStartDate = Carbon::parse($noteDate);
                $scheduleStartDate = Carbon::parse($schedule->start_date);
                $weeksDiff = $noteStartDate->diffInWeeks($scheduleStartDate);
                $currentIteration = floor($weeksDiff / 4) + 1;
                
                if ($currentIteration > $maxIterations) {
                    $this->warn("  Deleting schedule ID {$schedule->id} (Iteration {$currentIteration} > Max {$maxIterations})");
                    $schedule->delete();
                    $deletedCount++;
                }
            }
        }
        
        $this->info("Cleanup complete! Deleted {$deletedCount} schedules.");
        
        return 0;
    }
}

