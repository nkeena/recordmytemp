<?php

namespace App\Http\Livewire\Temperatures;

use App\Notifications\TemperatureAlert;
use Livewire\Component;

class Record extends Component
{
    public $temperature;
    public $scale = 'F';
    public $recorded = false;
    public $placeholderTemp = 98.6;

    protected $listeners = ['record'];

    public function updatedScale()
    {
        if ($this->scale === 'F') {
            $this->placeholderTemp = 98.6;
        }

        if ($this->scale === 'C') {
            $this->placeholderTemp = 37;
        }
    }

    public function record()
    {
        $this->validate([
            'temperature' => ['required', 'numeric']
        ]);

        $temperature = auth()->user()->temperatures()->create([
            'temperature' => $this->temperature,
            'scale' => $this->scale,
            'log_id' => auth()->user()->currentLog->id
        ]);

        if ($this->shouldBeReported($temperature)) {
            $temperature->log->owner->notify(new TemperatureAlert($temperature));
        }

        $this->recorded = true;
        $this->temperature = null;
        $this->scale = 'F';

        return redirect()->route('temperatures.index');
    }

    public function render()
    {
        return view('livewire.temperatures.record');
    }

    private function shouldBeReported($temperature)
    {
        return $temperature->log->notify_max_temp
            && $temperature->temperature > $temperature->log->max_temp
            && $temperature->user_id != $temperature->log->user_id
            && $temperature->log->participants()->where('user_id', $temperature->user_id)->first()->pivot->notifications;
    }
}
