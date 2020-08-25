<?php

namespace Tests\Feature;

use App\Log;
use App\Notifications\TemperatureAlert;
use App\User;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordTemperatureTest extends TestCase
{
    use RefreshDatabase;

    public $user;
    public $log;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->log = factory(Log::class)->create(['user_id' => $this->user->id]);
        $this->user->update(['current_log_id' => $this->log->id]);
        $this->user->refresh();

        $this->be($this->user);
    }

    /** @test */
    public function can_view_the_record_temperature_page()
    {
        $this->get(route('temperatures.record'))
            ->assertSuccessful()
            ->assertSeeLivewire('temperatures.record');
    }

    /** @test */
    public function can_record_a_new_temperature()
    {
        Livewire::test('temperatures.record')
            ->set('temperature', '98.6')
            ->call('record')
            ->assertRedirect(route('temperatures.index'));

        $this->assertDatabaseHas('temperatures', [
            'temperature' => 986,
            'user_id' => $this->user->id,
            'log_id' => $this->user->current_log_id
        ]);
    }

    /** @test */
    public function temperature_is_required()
    {
        Livewire::test('temperatures.record')
            ->set('temperature', '')
            ->call('record')
            ->assertHasErrors(['temperature' => 'required']);
    }

    /** @test */
    public function sends_alert_when_temperature_is_above_normal()
    {
        $user = factory(User::class)->create(['current_log_id' => $this->log->id]);
        $user->availableLogs()->attach($this->log->id);

        $this->be($user);

        Notification::fake();

        Livewire::test('temperatures.record')
            ->set('temperature', '100')
            ->call('record');

        Notification::assertSentTo(
            [$this->log->owner],
            TemperatureAlert::class
        );
    }
}
