<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LeadTest extends TestCase {
	private $lead;

	use DatabaseMigrations;

	protected function setUp() {
		parent::setUp();

		$this->lead = factory( Lead::class )->create();
	}

	public function test_unauthorized_user_cannot_crud_lead() {
		$this->withExceptionHandling()->unauthorizedUserSignIn();

		$this->get( route( 'leads.index' ) )->assertStatus( 403 );

		$this->get( route( 'leads.create' ) )->assertStatus( 403 );

		$this->get( route( 'leads.edit', $this->lead->id ) )->assertStatus( 403 );

		$this->get( route( 'leads.show', $this->lead->id ) )->assertStatus( 403 );

		$this->post( route( 'leads.destroy', $this->lead->id ), ['_method' => 'delete'] )->assertStatus( 403 );
	}

	public function test_authorized_user_can_read_lead() {
		$this->authorizedUserSignIn();

		$this->get( route( 'leads.index' ) )->assertStatus( 200 );

		$this->get( route( 'leads.show', $this->lead->id ) )->assertStatus( 200 );
	}

	public function test_authorized_user_can_create_lead() {
		$this->authorizedUserSignIn();

		$this->get( route( 'leads.create' ) )->assertStatus( 200 );

		$lead = make(Lead::class);
		$this->post( route( 'leads.store' ), $lead->toArray() )
		     ->assertRedirect( route( 'leads.index' ) );
	}

	public function test_authorized_user_can_edit_lead() {
		$this->authorizedUserSignIn();

		$this->get( route( 'leads.edit', $this->lead->id ) )
		     ->assertStatus( 200 )
		     ->assertSee( $this->lead->title );

		$lead = create(Lead::class);

		$this->put( route( 'leads.update', $lead->id ), $lead->toArray())->assertRedirect( route( 'leads.index' ) );

		$this->assertDatabaseHas( 'leads', [
			'id' => $lead->id
		] );
	}

	public function test_authorized_user_can_delete_lead() {
		$this->authorizedUserSignIn();

		$lead = create( Lead::class );

		$this->delete( route( 'leads.destroy', $lead->id ))->assertStatus( 200 );

		$this->assertSoftDeleted( 'leads', [
			'id' => $lead->id
		] );
	}

	public function test_authorized_user_can_delete_multiple_lead() {
  		$this->authorizedUserSignIn();

  		$lead1 = create( Lead::class, null );
  		$lead2 = create( Lead::class, null );

  		$this->delete( route( 'leads.destroys', [
  			'ids' => [$lead1->id, $lead2->id]
  		] ) )->assertStatus( 200 );

  		$this->assertSoftDeleted( 'leads', [
  			'id' => $lead1->id
  		] );

  		$this->assertSoftDeleted( 'leads', [
  			'id' => $lead2->id
  		] );
  	}
}
