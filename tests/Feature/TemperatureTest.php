<?php

namespace Tests\Feature;

use App\Log;
use App\User;
use Tests\TestCase;
use App\Temperature;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemperatureTest extends TestCase
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
    public function can_view_the_temperatures_page()
    {
        $this->get(route('temperatures.index'))
            ->assertSuccessful()
            ->assertSeeLivewire('temperatures.index');
    }

    /** @test */
    // public function owner_can_see_names()
    // {
    //     factory(Temperature::class)->create([
    //         'temperature' => '98.6',
    //         'user_id' => $this->user->id,
    //         'log_id' => $this->user->current_log_id
    //     ]);

    //     Livewire::actingAs($this->user)
    //         ->test('temperatures.index')
    //         ->assertSee($this->user->name);
    // }

    /** @test */
    // public function owner_can_download_results()
    // {
    //     Livewire::actingAs($this->user)
    //         ->test('temperatures.index')
    //         ->assertSee('Download');
    // }

    /** @test */
    public function can_delete_a_temperature()
    {
        $temp = factory(Temperature::class)->create([
            'temperature' => '98.6',
            'user_id' => $this->user->id,
            'log_id' => $this->user->current_log_id
        ]);

        Livewire::test('temperatures.index')
            ->assertSee('98.6')
            ->call('deleteTemperature', $temp->id)
            ->assertDontSee('98.6');

        $this->assertSoftDeleted('temperatures', ['id' => $temp->id]);
    }

    /** @test */
    public function redirects_to_logs_if_no_log_is_selected()
    {
        $this->user->update(['current_log_id' => null]);

        $this->get(route('temperatures.index'))
            ->assertRedirect(route('logs.index'));
    }
}
