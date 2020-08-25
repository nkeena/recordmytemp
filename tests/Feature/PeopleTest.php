<?php

namespace Tests\Feature;

use App\Log;
use App\User;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PeopleTest extends TestCase
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
    public function can_view_the_people_page()
    {
        $this->get(route('people.index'))
            ->assertSuccessful()
            ->assertSeeLivewire('people.index');
    }

    /** @test */
    public function only_see_people_on_current_log()
    {
        $participant = factory(User::class)->create();
        $participant->availableLogs()->attach($this->log->id);

        $differentLog = factory(Log::class)->create(['user_id' => $this->user->id]);
        $nonParticipant = factory(User::class)->create();
        $nonParticipant->availableLogs()->attach($differentLog->id);

        Livewire::test('people.index')
            ->assertSee($participant->name)
            ->assertDontSee($nonParticipant->name);
    }

    /** @test */
    public function remove_a_person_from_the_current_log()
    {
        $participant = factory(User::class)->create();
        $participant->availableLogs()->attach($this->log->id);

        Livewire::test('people.index')
            ->assertSee($participant->name)
            ->call('removePerson', $participant->id)
            ->assertDispatchedBrowserEvent('person-removed', ['person' => $participant->name])
            ->assertDontSee($participant->name);
    }

    /** @test */
    public function snooze_notifications_for_a_person()
    {
        $participant = factory(User::class)->create();
        $participant->availableLogs()->attach($this->log->id);

        Livewire::test('people.index')
            ->assertSee('turn off')
            ->call('snoozeNotifications', $participant->id)
            ->assertSee('turn on');
    }

    /** @test */
    public function enable_notifications_for_a_person()
    {
        $participant = factory(User::class)->create();
        $participant->availableLogs()->attach($this->log->id, ['notifications' => false]);

        Livewire::test('people.index')
            ->assertSee('turn on')
            ->call('enableNotifications', $participant->id)
            ->assertSee('turn off');
    }
}
