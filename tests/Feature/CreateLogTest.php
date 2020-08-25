<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_the_create_new_log_page()
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $this->get(route('logs.create'))
            ->assertSuccessful()
            ->assertSeeLivewire('logs.create');
    }

    /** @test */
    public function title_is_required()
    {
        Livewire::test('logs.create')
            ->set('title', '')
            ->call('createLog')
            ->assertHasErrors(['title' => 'required']);
    }

    /** @test */
    public function can_create_new_log()
    {
        $user = factory(User::class)->create();

        $this->be($user);

        Livewire::test('logs.create')
            ->set('title', 'My Log')
            ->call('createLog')
            ->assertRedirect(route('logs.edit', $user->current_log_id));

        $this->assertDatabaseHas('logs', [
            'id' => $user->current_log_id,
            'title' => 'My Log',
            'daily_count' => 1,
            'max_temp' => 990,
            'scale' => 'F',
            'notify_max_temp' => true,
            'notify_daily_count' => true,
            'daily_count_at' => '17:00'
        ]);
    }
}
