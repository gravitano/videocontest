<?php

class ParticipantsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('participants')->truncate();

		$participants = array(
			array(
				'network_id'		=>	'77428989',
				'fullname'			=>	'Gravitano',
				'username'			=>	'gravitano',
				'email'				=>	'gue.warsono@gmail.com',
				'address'			=>	'Babakan Wates 3',
				'city'				=>	'Bandung',
				'phone'				=>	'0897900000',
				'created_at'		=>	new Datetime,
				'updated_at'		=>	new Datetime
			),
			array(
				'network_id'		=>	'743428989',
				'fullname'			=>	'Pingpong Labs',
				'username'			=>	'pingpong',
				'email'				=>	'pingpong.labs@gmail.com',
				'address'			=>	'Bandung 3',
				'city'				=>	'Bandung',
				'phone'				=>	'089790343400',
				'created_at'		=>	new Datetime,
				'updated_at'		=>	new Datetime
			)
		);

		// Uncomment the below to run the seeder
		DB::table('participants')->insert($participants);
	}

}
