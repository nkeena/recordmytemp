<?php

namespace App\Http\Livewire\Logs;

use App\Log;
use Livewire\Component;

class Edit extends Component
{
    public $logId;
    public $title = '';
    public $dailyCount = 1;
    public $maxTemp;
    public $scale = 'F';
    public $notifyMaxTemp;
    public $notifyDailyCount;
    public $dailyCountAt;

    public function mount(Log $log)
    {
        $this->logId = $log->id;
        $this->title = $log->title;
        $this->dailyCount = $log->daily_count;
        $this->maxTemp = $log->max_temp;
        $this->scale = $log->scale;
        $this->notifyMaxTemp = $log->notify_max_temp;
        $this->notifyDailyCount = $log->notify_daily_count;
        $this->dailyCountAt = $log->daily_count_at;
    }

    public function render()
    {
        return view('livewire.logs.edit');
    }

    public function edit()
    {
        $this->validate([
            'title' => ['required', 'max:60'],
            'dailyCount' => ['required', 'numeric'],
            'maxTemp' => ['required', 'numeric'],
            'notifyMaxTemp' => ['boolean'],
            'notifyDailyCount' => ['boolean'],
            'dailyCountAt' => ['required']
        ]);

        $log = Log::findOrFail($this->logId);

        $log->update([
            'title' => $this->title,
            'daily_count' => $this->dailyCount,
            'max_temp' => $this->maxTemp,
            'notify_max_temp' => $this->notifyMaxTemp,
            'notify_daily_count' => $this->notifyDailyCount,
            'daily_count_at' => $this->dailyCountAt
        ]);

        redirect()->route('logs.index');
    }
}
