<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $user;

    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_unauthorized_user_cannot_crud_user()
    {
        $this->withExceptionHandling()->unauthorizedUserSignIn();

        $this->get(route('users.index'))->assertStatus(403);

        $this->get(route('users.create'))->assertStatus(403);

        $this->get(route('users.edit', $this->user->id))->assertStatus(403);

        $this->get(route('users.show', $this->user->id))->assertStatus(403);

        $this->post(route('users.destroy', $this->user->id), ['_method' => 'delete'])->assertStatus(403);
    }

    public function test_authorized_user_can_read_user()
    {
        $this->authorizedUserSignIn();

        $this->get(route('users.index'))->assertStatus(200);

        $this->get(route('users.show', $this->user->id))->assertStatus(200);
    }

    public function test_authorized_user_can_create_user()
    {
        $this->authorizedUserSignIn();

        $this->get(route('users.create'))->assertStatus(200);

        $user = make(User::class);

        $this->post(route('users.store'), array_merge($user->toArray(), [
            'password'              => '123456',
            'password_confirmation' => '123456'
        ]))->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'username' => $user->username,
        ]);
    }

    public function test_authorized_user_can_edit_user()
    {
        $this->authorizedUserSignIn();

        $this->get(route('users.edit', $this->user->id))
             ->assertStatus(200)
             ->assertSee($this->user->title);

        $user = create(User::class);

        $this->put(route('users.update', $user->id), array_merge($user->toArray(), [
            'password'              => '123456',
            'password_confirmation' => '123456'
        ]))->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function test_authorized_user_can_edit_multiple_user()
    {
        $this->authorizedUserSignIn();

        $this->post(route('users.edits'))->assertStatus(200);

        $user1 = create(User::class);
        $user2 = create(User::class);

        $this->put(route('users.updates', [
            'ids' => "$user1->id,$user2->id"
        ]), [
            'password'              => '123',
            'password_confirmation' => '123'
        ])->assertStatus(200);

//		$this->assertDatabaseHas( 'users', [
//			'id' => $user1->id,
//		] );
    }

    public function test_authorized_user_can_delete_user()
    {
        $this->authorizedUserSignIn();

        $user = create(User::class, null);

        $this->delete(route('users.destroy', $user->id))->assertStatus(200);

        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);
    }

    public function test_authorized_user_can_delete_multiple_user()
    {
        $this->authorizedUserSignIn();

        $user1 = create(User::class, null);
        $user2 = create(User::class, null);

        $this->delete(route('users.destroys', [
            'ids' => [$user1->id, $user2->id]
        ]))->assertStatus(200);

        $this->assertSoftDeleted('users', [
            'id' => $user1->id
        ]);

        $this->assertSoftDeleted('users', [
            'id' => $user2->id
        ]);
    }

    public function test_inactive_user_muts_be_kick_out()
    {
        $this->withExceptionHandling()->authorizedUserSignIn($this->user);

        $this->get(route('home'))->assertStatus(200);

        $this->user->update(['state' => 0]);

        $this->get(route('home'))->assertStatus(403);
    }
}
