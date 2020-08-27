<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;

class Profile extends Component
{
    public $name;
    public $email;
    public $profileUpdated = false;

    public function mount()
    {
        $user = auth()->user();

        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        $validated = $this->validate([
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore(auth()->id())
            ]
        ]);

        auth()->user()->update($validated);

        $this->profileUpdated = true;
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
