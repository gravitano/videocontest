<?php

namespace Pingpong\Videocontest;

use Session;
use DB;
use Video;
use Participant;
use Config;
use Str;
use Crypt;
use Sharelog;

class Videocontest {

	/**
	 * Test for user login manually
	 *
	 * @return boolean
	 **/
	public function setLogin($id)
	{
		if(!Videocontest::hasUser())
		{
			Session::put('user_id', $id);
		}
	}

	/**
	 * Check login status of user
	 *
	 * @return boolean
	 **/
	public function hasUser(){
		return Session::has('user_id') AND $this->hasTwitter();
	}
	
	/**
	 * get user_id from logged user
	 *
	 * @return response
	 **/
	public function getUser()
	{
		return Session::get('user_id');
	}

	/**
	 * Check login status of twitter
	 *
	 * @return boolean
	 **/
	public function hasTwitter()
	{
		return Session::has('access_token');
	}

	/**
	 * get twitter session 
	 *
	 * @return response
	 **/
	public function getTwitter($key = null)
	{
		$access_token = Session::get('access_token');
		if(!is_null($key) and isset($access_token[$key]))
		{
			return $access_token[$key];
		}
		return $access_token;
	}

 	public function gallery($status = 'A')
 	{
 		return Video::where('status', $status)
 			->paginate(Config::get('Videocontest::app.gallery.video-perpage'))
 		;
 	}

 	public function leaderboard($status = 'A')
 	{
 		$limit = Config::get('Videocontest::leaderboard.limit');
		return DB::table('videos')
	        ->leftJoin('votes', 'videos.id', '=', 'votes.video_id')
	        ->where('status', $status)
	        ->select(array('videos.*', DB::raw('COUNT(*) as count')))
	        ->orderBy('count', 'desc')
	        ->groupBy('videos.id')
	        ->take($limit)
	        ->get()
	    ;
 	}

 	public function userRegistered($twitter_id)
 	{
 		$count = Participant::where('network_id','=', $twitter_id)->count();
 		return ! empty($count);
 	}

 	public function setUserLogin($twitter_id)
 	{
 		$data = Participant::where('network_id',$twitter_id);

 		if($data->count())
 		{
 			$user = $data->first();
 			Session::put('user_id', $user->id);
 			Session::put('network_id', $user->network_id);
 			return TRUE;
 		}
 		return FALSE;
 	}

 	public function uniqueURL($id)
 	{
 		$v = Video::find($id);
 		if(!empty($v)){			
	 		$ID = 'video/'. $v->slug;
	 		return url($ID);
 		}
 		return FALSE;
 	}

 	public function shorten($id)
 	{
 		$v = Video::find($id);
 		if(!empty($v)){			
	 		$ID = 'v/'. $id;
	 		return url($ID);
 		}
 		return FALSE; 		
 	}

 	public function singleVideo($slug)
 	{
 		$v = Video::where('slug','=',$slug)->where('status','=','A');
 		if($v->count())
 		{
 			return $v->first();
 		}
 		return FALSE;
 	}

 	public function isEventActive()
 	{
 		$startdate = Config::get('Videocontest::app.startdate');
 		$enddate = Config::get('Videocontest::app.enddate');
 		
 		$start = strtotime($startdate);
 		$end = strtotime($enddate);

 		$now = strtotime(date('Y-m-d H:i:s'));
 		if($now >= $start AND $now <= $end) return TRUE;
 		return FALSE;
 	}

 	public function autoText($text=null, $search = null, $replace = null)
 	{
 		return str_replace($search, $replace, $text);
 	}

 	public function timeAgo($ptime)
	{
	    $etime = time() - $ptime;

	    if ($etime < 1)
	    {
	        return '0 seconds';
	    }

	    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'minute',
	                1                       =>  'second'
	                );

	    foreach ($a as $secs => $str)
	    {
	        $d = $etime / $secs;
	        if ($d >= 1)
	        {
	            $r = round($d);
	            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
	        }
	    }
	}

	public function timeAgoFromDate($date)
	{
		$ptime = strtotime($date);
		return $this->timeAgo($ptime);
	}

	public function tweetCount($video_id)
	{
		$sl = Sharelog::where('video_id', $video_id)->count();
		if(!empty($sl))
		{
			return "($sl)";
		}
		return false;
	}
}
