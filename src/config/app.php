<?php

return array(
	/**
	 * Website/App/Event 
	 * ------------------------
	 */
	'title'		=>	'Pingpong Video Contest', 
	'appname'	=>	'Pingpong Video Contest', /* used to replace :appname */ 
	
	'startdate'	=>	'2013-12-01 00:00:00', 
	'enddate'	=>	'2014-01-01 23:00:00',

	'use-timer'	=>	false, /* use timercoutdown when event not start*/
	'maintenance'	=> false, /* lock the app when maintenance */
	
	/* leaderboard */
	'leaderboard'	=>	array(
		'limit'	=>	10
	),
	/**
	 * Gallery
	 * ----------------
	 */
	'gallery'	=>	array(
		'video-perpage'		=>	12,
		'thumbs'	=> array(
			'width'	=>	240,
			'height'=>	240
		),
		'single'	=> array(
			'width'	=>	800,
			'height'=>	800
		)
	),

	/**
	 * Twitter
	 * ----------------
	 */
	'twitter'	=>	array(
		'consumer_key'		=>	'97EFSvM3cG31NCWCMVsRgg',
		'consumer_secret'	=> 	'rQLeHMOvDubol4jsgBgAUY5XiDV5uExOXcVt1iXbPrM',

		'auto-tweet'	=>	array(
			'after-vote'	=>	'Baru aja ngvote video :video_name di :video_url!',
			'after-share'	=>	'Ayo dukung video :video_name  di :video_url dan ikutan :appname di :url!',
		)
	)
);	