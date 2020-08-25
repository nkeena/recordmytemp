<?php

namespace Tests\Feature;

use App\Log;
use App\User;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JoinLogTest extends TestCase
{
    use RefreshDatabase;

    public $user;
    public $log;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->log = factory(Log::class)->create();

        $this->be($this->user);
    }

    /** @test */
    public function can_view_the_join_page()
    {
        $this->get(route('logs.join'))
            ->assertSuccessful()
            ->assertSeeLivewire('logs.join');
    }

    /** @test */
    public function can_join_a_log()
    {
        Livewire::test('logs.join')
            ->set('code', $this->log->join_code)
            ->call('join')
            ->assertRedirect(route('temperatures.index'))
            ->assertSee($this->log->name);
    }

    /** @test */
    public function requires_join_code()
    {
        Livewire::test('logs.join')
            ->set('code', '')
            ->call('join')
            ->assertHasErrors(['code' => 'required']);
    }

    /** @test */
    public function requires_valid_join_code()
    {
        Livewire::test('logs.join')
            ->set('code', 'invalid')
            ->call('join')
            ->assertHasErrors(['code' => 'exists']);
    }
}
