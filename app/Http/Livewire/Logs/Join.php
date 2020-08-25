<?php

namespace App\Http\Livewire\Logs;

use App\Log;
use Livewire\Component;

class Join extends Component
{
    /** @var string */
    public $code = '';

    public function render()
    {
        return view('livewire.logs.join');
    }

    public function join()
    {
        $this->validate([
            'code' => ['required', 'exists:logs,join_code']
        ]);

        $log = Log::whereJoinCode($this->code)->firstOrFail();

        auth()->user()->availableLogs()->syncWithoutDetaching($log->id);

        auth()->user()->update(['current_log_id' => $log->id]);

        redirect()->route('temperatures.index');
    }
}
