<?php

namespace Tests\Feature;

use App\Log;
use App\User;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_logs_page()
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $this->get(route('logs.index'))
            ->assertSuccessful()
            ->assertSeeLivewire('logs.index');
    }

    /** @test */
    public function can_only_see_my_logs()
    {
        $user = factory(User::class)->create();

        factory(Log::class)->create([
            'title' => 'My Log',
            'user_id' => $user->id
        ]);

        $log = factory(Log::class)->create(['title' => 'Log I joined']);
        $user->availableLogs()->syncWithoutDetaching($log->id);
        $user->update(['current_log_id' => $log->id]);

        factory(Log::class)->create(['title' => 'Your Log']);

        $this->be($user);

        $this->get(route('logs.index'))
            ->assertSuccessful()
            ->assertSee('My Log')
            ->assertSee('Log I joined')
            ->assertDontSee('Your Log');
    }

    /** @test */
    public function can_select_a_log()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create([
            'title' => 'My Log',
            'user_id' => $user->id
        ]);

        $this->be($user);

        Livewire::test('logs.index')
            ->call('selectLog', $log->id)
            ->assertRedirect(route('temperatures.index'))
            ->assertSee('My Log');
    }

    /** @test */
    public function can_delete_a_log()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create([
            'title' => 'My Log',
            'user_id' => $user->id
        ]);

        $user->update(['current_log_id' => $log->id]);

        $this->be($user);

        Livewire::test('logs.index')
            ->assertSee('My Log')
            ->call('delete', $log->id)
            ->assertDispatchedBrowserEvent('log-deleted', ['log' => $log->title]);

        $this->assertSoftDeleted('logs', ['title' => 'My Log']);
        $this->assertNull($user->current_log_id);
    }

    /** @test */
    public function can_remove_a_log()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create(['title' => 'Your Log', ]);
        $user->availableLogs()->syncWithoutDetaching($log->id);
        $user->update(['current_log_id' => $log->id]);

        $this->assertDatabaseHas('log_user', ['user_id' => $user->id, 'log_id' => $log->id]);

        $this->be($user);

        Livewire::test('logs.index')
            ->assertSee('Your Log')
            ->call('remove', $log->id)
            ->assertDispatchedBrowserEvent('log-removed', ['log' => $log->title]);

        $this->assertNull($user->current_log_id);
        $this->assertDatabaseMissing('log_user', ['user_id' => $user->id, 'log_id' => $log->id]);
    }
}
