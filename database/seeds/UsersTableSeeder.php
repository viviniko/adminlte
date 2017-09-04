<?php

use Viviniko\Permission\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
    {
		User::create([
			'firstname' => 'VIVINIKO',
            'lastname' => 'SHOP',
			'email' => 'viviniko.shop@gmail.com',
			'password' => '123456',
			'is_active' => true,
			'phone' => null,
			'extra' => [],
			'log_num' => 0,
		]);
	}
}
