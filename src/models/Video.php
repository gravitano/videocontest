<?php

class Video extends Eloquent {
	protected $guarded = array();

	public static $rules_upload = array(
		'url'		=>	'required|url',
		'caption'	=>	'required|max:500',
		'desc'		=>	'required|max:1000'
	);
}
