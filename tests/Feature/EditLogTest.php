<?php

namespace Tests\Feature;

use App\Log;
use App\User;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_the_edit_log_page()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create(['user_id' => $user->id]);

        $this->be($user);

        $this->get(route('logs.edit', $log))
            ->assertSuccessful()
            ->assertSeeLivewire('logs.edit');
    }

    /** @test */
    public function can_edit_a_log()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create(['title' => 'New Log', 'user_id' => $user->id]);

        $this->be($user);

        Livewire::test('logs.edit', ['log' => $log])
            ->set('title', 'Updated log')
            ->call('edit')
            ->assertRedirect(route('logs.index'));

        $log->refresh();

        $this->assertEquals('Updated log', $log->title);
    }

    /** @test */
    public function title_is_required()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create(['user_id' => $user->id]);

        $this->be($user);

        Livewire::test('logs.edit', ['log' => $log])
            ->set('title', '')
            ->call('edit')
            ->assertHasErrors(['title' => 'required']);
    }

    /** @test */
    public function daily_count_is_required()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create(['user_id' => $user->id]);

        $this->be($user);

        Livewire::test('logs.edit', ['log' => $log])
            ->set('dailyCount', '')
            ->call('edit')
            ->assertHasErrors(['dailyCount' => 'required']);
    }

    /** @test */
    public function max_temp_is_required()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create(['user_id' => $user->id]);

        $this->be($user);

        Livewire::test('logs.edit', ['log' => $log])
            ->set('maxTemp', '')
            ->call('edit')
            ->assertHasErrors(['maxTemp' => 'required']);
    }

    /** @test */
    public function daily_count_at_is_required()
    {
        $user = factory(User::class)->create();

        $log = factory(Log::class)->create(['user_id' => $user->id]);

        $this->be($user);

        Livewire::test('logs.edit', ['log' => $log])
            ->set('dailyCountAt', '')
            ->call('edit')
            ->assertHasErrors(['dailyCountAt' => 'required']);
    }
}
