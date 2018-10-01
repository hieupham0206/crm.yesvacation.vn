<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$tableNames = config( 'permission.table_names' );

		Schema::create( $tableNames['permissions'], function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'name' );
			$table->string( 'module' )->default( '' );
			$table->string( 'action' )->default( '' );
			$table->string( 'namespace' )->default( '' );
			$table->string( 'can_delete' )->default( 1 )->comment( '0: không được delete, 1: có thể delete' );
			$table->string( 'guard_name' )->default( 'web' );
			$table->timestamps();
		} );

		Schema::create( $tableNames['roles'], function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'name' );
			$table->string( 'guard_name' )->default( 'web' );
			$table->timestamps();
		} );

		Schema::create( $tableNames['model_has_permissions'], function ( Blueprint $table ) use ( $tableNames ) {
			$table->unsignedInteger( 'permission_id' );
			$table->morphs( 'model' );

			$table->foreign( 'permission_id' )
			      ->references( 'id' )
			      ->on( $tableNames['permissions'] )
			      ->onDelete( 'cascade' );

			$table->primary( [ 'permission_id', 'model_id', 'model_type' ] );
		} );

		Schema::create( $tableNames['model_has_roles'], function ( Blueprint $table ) use ( $tableNames ) {
			$table->unsignedInteger( 'role_id' );
			$table->morphs( 'model' );

			$table->foreign( 'role_id' )
			      ->references( 'id' )
			      ->on( $tableNames['roles'] )
			      ->onDelete( 'cascade' );

			$table->primary( [ 'role_id', 'model_id', 'model_type' ] );
		} );

		Schema::create( $tableNames['role_has_permissions'], function ( Blueprint $table ) use ( $tableNames ) {
			$table->unsignedInteger( 'permission_id' );
			$table->unsignedInteger( 'role_id' );

			$table->foreign( 'permission_id' )
			      ->references( 'id' )
			      ->on( $tableNames['permissions'] )
			      ->onDelete( 'cascade' );

			$table->foreign( 'role_id' )
			      ->references( 'id' )
			      ->on( $tableNames['roles'] )
			      ->onDelete( 'cascade' );

			$table->primary( [ 'permission_id', 'role_id' ] );

			app( 'cache' )->forget( 'spatie.permission.cache' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		$tableNames = config( 'permission.table_names' );

		Schema::drop( $tableNames['role_has_permissions'] );
		Schema::drop( $tableNames['model_has_roles'] );
		Schema::drop( $tableNames['model_has_permissions'] );
		Schema::drop( $tableNames['roles'] );
		Schema::drop( $tableNames['permissions'] );
	}
}