<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table( 'users' )->truncate();
		DB::table( 'users' )->insert( [
			[
				'name'       => "Administrator",
				'username'   => "admin",
				'email'      => "admin@local.dev",
				'password'   => bcrypt( "pass123" ),
				'created_at' => date( 'Y-m-d H:i:s' ),
				'updated_at' => date( 'Y-m-d H:i:s' ),
			]
		] );
	}
}
