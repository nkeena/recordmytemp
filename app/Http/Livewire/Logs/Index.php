<?php

namespace App\Http\Livewire\Logs;

use App\Log;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['removeLog' => 'remove', 'deleteLog' => 'delete'];

    public function render()
    {
        $logs = auth()->user()->logs->merge(auth()->user()->availableLogs)->sortBy('title');

        return view('livewire.logs.index', [
            'logs' => $logs,
        ]);
    }

    public function selectLog($id)
    {
        auth()->user()->update(['current_log_id' => $id]);

        redirect()->route('temperatures.index');
    }

    public function delete($id)
    {
        $log = Log::findOrFail($id);

        if (auth()->user()->current_log_id === $id) {
            auth()->user()->update(['current_log_id' => null]);
        }

        $log->delete();

        $this->dispatchBrowserEvent('log-deleted', ['log' => $log->title]);
    }

    public function remove($id)
    {
        if (auth()->user()->current_log_id === $id) {
            auth()->user()->update(['current_log_id' => null]);
        }

        auth()->user()->availableLogs()->detach($id);

        $this->dispatchBrowserEvent('log-removed', ['log' => Log::findOrFail($id)->title]);
    }
}
