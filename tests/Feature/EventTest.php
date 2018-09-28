<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EventTest extends TestCase
{
    private $event;

    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->event = factory(Event::class)->create();
    }

    public function test_unauthorized_user_cannot_crud_event()
    {
        $this->withExceptionHandling()->unauthorizedUserSignIn();

        $this->get(route('events.index'))->assertStatus(403);

        $this->get(route('events.create'))->assertStatus(403);

        $this->get(route('events.edit', $this->event->id))->assertStatus(403);

        $this->get(route('events.show', $this->event->id))->assertStatus(403);

        $this->post(route('events.destroy', $this->event->id), ['_method' => 'delete'])->assertStatus(403);
    }

    public function test_authorized_user_can_read_event()
    {
        $this->authorizedUserSignIn();

        $this->get(route('events.index'))->assertStatus(200);

        $this->get(route('events.show', $this->event->id))->assertStatus(200);
    }

    public function test_authorized_user_can_create_event()
    {
        $this->authorizedUserSignIn();

        $this->get(route('events.create'))->assertStatus(200);

        $event = make(Event::class);
        $this->post(route('events.store'), $event->toArray())
             ->assertRedirect(route('events.index'));
    }

    public function test_authorized_user_can_edit_event()
    {
        $this->authorizedUserSignIn();

        $this->get(route('events.edit', $this->event->id))
             ->assertStatus(200)
             ->assertSee($this->event->title);

        $event = create(Event::class);

        $this->put(route('events.update', $event->id), $event->toArray())->assertRedirect(route('events.index'));

        $this->assertDatabaseHas('events', [
            'id' => $event->id
        ]);
    }

    public function test_authorized_user_can_delete_event()
    {
        $this->authorizedUserSignIn();

        $event = create(Event::class);

        $this->delete(route('events.destroy', $event->id))->assertStatus(200);

        $this->assertDatabaseMissing('events', [
            'id' => $event->id
        ]);
    }

    public function test_authorized_user_can_delete_multiple_event()
    {
        $this->authorizedUserSignIn();

        $event1 = create(Event::class, null);
        $event2 = create(Event::class, null);

        $this->delete(route('events.destroys', [
            'ids' => [$event1->id, $event2->id]
        ]))->assertStatus(200);

        $this->assertDatabaseMissing('events', [
            'id' => $event1->id
        ]);

        $this->assertDatabaseMissing('events', [
            'id' => $event2->id
        ]);
    }
}
