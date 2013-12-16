<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('users')->truncate();

		$users = array(
			array(
				'fullname'		=>	'Administrator',
				'username'		=>	'admin',
				'password'		=>	Hash::make('zxc123'),
				'email'			=>	'pingpong.labs@gmail.com',
				'status'		=>	'confirmed',
				'created_at'	=>	new Datetime,
				'updated_at'	=>	new Datetime,
			)
		);

		// Uncomment the below to run the seeder
		DB::table('users')->insert($users);
	}

}
