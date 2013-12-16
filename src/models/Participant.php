<?php

class Participant extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'fullname'		=>	'required|max:45',
		'username'		=>	'required|min:4|max:45',
		'email'			=>	'required|email',
		'address'		=>	'required',
		'city'			=>	'required',
		'phone'			=>	'required|numeric',
	);

	public static function get($id = null, $get = 'fullname')
	{
		$p = Participant::find($id);
		if(!empty($p))
		{
			if(isset($p->$get))
			{
				return $p->$get;
			}
			return json_encode($p);
		}
		return false;
	}
}
