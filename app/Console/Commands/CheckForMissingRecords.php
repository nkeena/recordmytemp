<?php

namespace App\Console\Commands;

use App\Log;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Notifications\RecordMissing;

class CheckForMissingRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'records:missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for missing records.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::where('notify_daily_count', true)
            ->cursor()
            ->each(function ($log) {
                $people = [];

                foreach ($log->participants()->cursor() as $person) {
                    if ($this->shouldReport($person, $log)) {
                        array_push($people, $person->name);
                    }
                }

                if (count($people)) {
                    $log->owner->notify(
                        (new RecordMissing($people, $log->title))->delay(now()->addSeconds(10))
                    );
                }
            });
    }

    private function shouldReport($person, $log)
    {
        if (!$this->assertReportingHour($log)) {
            return false;
        }

        if ($person->is($log->owner)) {
            return false;
        }

        if (!$person->pivot->notifications) {
            return false;
        }

        if ($this->getTemperatureCount($person, $log) >= $log->daily_count) {
            return false;
        }

        return true;
    }

    private function assertReportingHour($log)
    {
        return Carbon::create($log->daily_count_at, $log->owner->timezone)->between(
            now($log->owner->timezone)->startOfHour(),
            now($log->owner->timezone)->endOfHour(),
        );
    }

    private function getTemperatureCount($person, $log)
    {
        return $person->temperatures()->whereBetween('created_at', [
            today($log->owner->timezone)->timezone('UTC'),
            today($log->owner->timezone)->endOfDay()->timezone('UTC')
        ])->count();
    }
}
