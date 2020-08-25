<?php

namespace App\Http\Livewire\People;

use App\User;
use Livewire\Component;

class Index extends Component
{
    public $search;

    protected $listeners = ['removePerson'];

    public function removePerson($id)
    {
        auth()->user()->currentLog->participants()->detach($id);

        $this->dispatchBrowserEvent('person-removed', ['person' => User::findOrFail($id)->name]);
    }

    public function snoozeNotifications($id)
    {
        auth()->user()->currentLog->participants()->updateExistingPivot($id, ['notifications' => false]);
    }

    public function enableNotifications($id)
    {
        auth()->user()->currentLog->participants()->updateExistingPivot($id, ['notifications' => true]);
    }

    public function render()
    {
        return view('livewire.people.index', [
            'people' => auth()->user()->currentLog->participants()
                ->when($this->search, fn ($q) => $q->where('name', 'like', "%$this->search%"))
                ->get()
        ]);
    }
}
