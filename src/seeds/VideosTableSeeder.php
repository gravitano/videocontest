<?php

class VideosTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('videos')->truncate();

		$videos = array(
			array(
				'participant_id'		=>	1,
				'url'			=>	'http://www.youtube.com/watch?v=m5Jmh9JKnyQ',
				'caption'		=>	'Lorem ipsum dolor sit amet',
				'slug'			=>	Str::slug('Lorem ipsum dolor sit amet 1'),
				'desc'			=>	'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
				'status'		=>	'A',	// A: Approved R: Rejected N: New				
				'created_at'		=>	new Datetime,
				'updated_at'		=>	new Datetime
			),
			array(
				'participant_id'		=>	1,
				'url'			=>	'http://www.youtube.com/watch?v=9Nt8urdHDrs',
				'slug'			=>	Str::slug('Lorem ipsum dolor sit amet 2'),
				'caption'		=>	'Lorem ipsum dolor sit amet',
				'desc'			=>	'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
				'status'		=>	'A',	// A: Approved R: Rejected N: New				
				'created_at'		=>	new Datetime,
				'updated_at'		=>	new Datetime
			),
			array(
				'participant_id'		=>	2,
				'url'			=>	'http://www.youtube.com/watch?v=Zz_R73eW3OU',
				'slug'			=>	Str::slug('Lorem ipsum dolor sit amet 3'),
				'caption'		=>	'Lorem ipsum dolor sit amet',
				'desc'			=>	'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
				'status'		=>	'A',	// A: Approved R: Rejected N: New				
				'created_at'		=>	new Datetime,
				'updated_at'		=>	new Datetime
			),
			array(
				'participant_id'		=>	2,
				'url'			=>	'http://www.youtube.com/watch?v=TvQwtOX_dCc',
				'slug'			=>	Str::slug('Lorem ipsum dolor sit amet 4'),
				'caption'		=>	'Lorem ipsum dolor sit amet',
				'desc'			=>	'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
				'status'		=>	'A',	// A: Approved R: Rejected N: New				
				'created_at'		=>	new Datetime,
				'updated_at'		=>	new Datetime
			)
		);

		// Uncomment the below to run the seeder
		DB::table('videos')->insert($videos);
	}

}
