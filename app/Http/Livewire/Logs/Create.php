<?php

namespace App\Http\Livewire\Logs;

use App\Log;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{
    /** @var string **/
    public $title = '';

    public function render()
    {
        return view('livewire.logs.create');
    }

    public function createLog()
    {
        $this->validate([
            'title' => ['required', 'max:60']
        ]);

        $log = Log::create([
            'title' => $this->title,
            'join_code' => Str::random(8),
            'user_id' => auth()->id(),
            'daily_count' => 1,
            'max_temp' => 99,
            'scale' => 'F',
            'notify_max_temp' => true,
            'notify_daily_count' => true
        ]);

        auth()->user()->update(['current_log_id' => $log->id]);

        redirect()->route('logs.edit', $log);
    }
}
