<?php

namespace Tests\Feature;

use App\Models\Department;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DepartmentTest extends TestCase {
	private $department;

	use DatabaseMigrations;

	protected function setUp() {
		parent::setUp();

		$this->department = factory( Department::class )->create();
	}

	public function test_unauthorized_user_cannot_crud_department() {
		$this->withExceptionHandling()->unauthorizedUserSignIn();

		$this->get( route( 'departments.index' ) )->assertStatus( 403 );

		$this->get( route( 'departments.create' ) )->assertStatus( 403 );

		$this->get( route( 'departments.edit', $this->department->id ) )->assertStatus( 403 );

		$this->get( route( 'departments.show', $this->department->id ) )->assertStatus( 403 );

		$this->post( route( 'departments.destroy', $this->department->id ), ['_method' => 'delete'] )->assertStatus( 403 );
	}

	public function test_authorized_user_can_read_department() {
		$this->authorizedUserSignIn();

		$this->get( route( 'departments.index' ) )->assertStatus( 200 );

		$this->get( route( 'departments.show', $this->department->id ) )->assertStatus( 200 );
	}

	public function test_authorized_user_can_create_department() {
		$this->authorizedUserSignIn();

		$this->get( route( 'departments.create' ) )->assertStatus( 200 );

		$department = make(Department::class);
		$this->post( route( 'departments.store' ), $department->toArray() )
		     ->assertRedirect( route( 'departments.index' ) );
	}

	public function test_authorized_user_can_edit_department() {
		$this->authorizedUserSignIn();

		$this->get( route( 'departments.edit', $this->department->id ) )
		     ->assertStatus( 200 )
		     ->assertSee( $this->department->title );

		$department = create(Department::class);

		$this->put( route( 'departments.update', $department->id ), $department->toArray())->assertRedirect( route( 'departments.index' ) );

		$this->assertDatabaseHas( 'departments', [
			'id' => $department->id
		] );
	}

	public function test_authorized_user_can_delete_department() {
		$this->authorizedUserSignIn();

		$department = create( Department::class );

		$this->delete( route( 'departments.destroy', $department->id ))->assertStatus( 200 );

		$this->assertSoftDeleted( 'departments', [
			'id' => $department->id
		] );
	}

	public function test_authorized_user_can_delete_multiple_department() {
  		$this->authorizedUserSignIn();

  		$department1 = create( Department::class, null );
  		$department2 = create( Department::class, null );

  		$this->delete( route( 'departments.destroys', [
  			'ids' => [$department1->id, $department2->id]
  		] ) )->assertStatus( 200 );

  		$this->assertSoftDeleted( 'departments', [
  			'id' => $department1->id
  		] );

  		$this->assertSoftDeleted( 'departments', [
  			'id' => $department2->id
  		] );
  	}
}
