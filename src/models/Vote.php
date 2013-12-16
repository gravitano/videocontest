<?php

class Vote extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public static function getCount($video_id)
	{
		$v = Vote::where('video_id',$video_id)->count();
		if(!empty($v))
		{
			return "($v)";
		}
		return FALSE;
	}
}
