<?php

namespace Pingpong\Videocontest;

use View;
use Session;
use Input;
use Redirect;
use Config;
use BaseController;
use Twitter;
use Videocontest;
use Video;
use Validator;
use Participant;
use Str;
use Vote;
use Request;
use Sharelog;

class AppController extends BaseController
{
	
	function __construct()
	{
		$this->consumer_key 	= Config::get('Videocontest::app.twitter.consumer_key');
		$this->consumer_secret	= Config::get('Videocontest::app.twitter.consumer_secret');

		if(Videocontest::hasTwitter())
		{
			$oauth_token 		= isset(Session::get('access_token')['oauth_token'])
				?
				Session::get('access_token')['oauth_token']
				:
				null
			;
			$oauth_token_secret = isset(Session::get('access_token')['oauth_token_secret'])
				?
				Session::get('access_token')['oauth_token_secret']
				:
				null
			;
			$this->twitter = new Twitter($this->consumer_key, $this->consumer_secret, $oauth_token, $oauth_token_secret);
		}else{
			$this->twitter = new Twitter($this->consumer_key, $this->consumer_secret);
		}

		/* Just for testing */
		// Videocontest::setLogin(1);

		/* Event::checker() */
		$this->beforeFilter(function()
        {        	
			if( ! Videocontest::isEventActive())
				return View::make('Videocontest::coming-soon');
        });
	}

	public function index()
	{
		if(Videocontest::hasUser()){
			return View::make("Videocontest::home", array());
		}
		return View::make("Videocontest::index", array());
	}

	/* Twitter authentication */
	public function redirect()
	{
		Session::forget('access_token');
		Session::forget('status');

		$callback = url('/twitter/callback');

		/* Build TwitterOAuth object with client credentials. */
		$this->twitter = new Twitter($this->consumer_key, $this->consumer_secret);
		$connection = $this->twitter;

		/* Get temporary credentials. */
		$request_token = $connection->getRequestToken($callback);

		$token 			= $request_token['oauth_token'];
		$token_secret 	= $request_token['oauth_token_secret'];

		/* Save temporary credentials to session. */
		Session::put('oauth_token', $token);
		Session::put('oauth_token_secret', $token_secret);

		/* If last connection failed don't display authorization link. */
		switch ($connection->http_code) {
			case 200:
				/* Build authorize URL and redirect user to Twitter. */
				$url = $connection->getAuthorizeURL($token);
				// header('Location: ' . $url); 
				return Redirect::to($url);
			break;
			default:
				/* Show notification if something went wrong. */
				return 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}
	
	/* Callback from twitter */
	public function callback()
	{
		/* If the oauth_token is old redirect to the connect page. */
		if(Input::has('oauth_token') AND Session::get('oauth_token') !== Input::get('oauth_token'))
		{
			return Redirect::to('/')
				->with('message-warning','Your session expired!')
			;
		}

		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$oauth_token 		= Session::get('oauth_token');
		$oauth_token_secret = Session::get('oauth_token_secret');

		$this->twitter = new Twitter($this->consumer_key,
			$this->consumer_secret,
			$oauth_token,
			$oauth_token_secret)
		;
		$connection = $this->twitter;

		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken(Input::get('oauth_verifier'));

		/* Save the access tokens. Normally these would be saved in a database for future use. */
		Session::put('access_token', $access_token);

		/* Remove no longer needed request tokens */
		Session::forget('oauth_token');
		Session::forget('oauth_token_secret');

		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {
			/* The user has been verified and the access tokens can be saved for future use */
			Session::put('status', 'verified');

			/*  User::check() */
			$twitter_id = Videocontest::getTwitter('user_id');
			if( ! Videocontest::userRegistered($twitter_id))
			{				
				/* must register */
				return Redirect::to('/register')
					->with('message-info','Welcome! Please register first')
				;
			}
			/* SET login */
			Videocontest::setUserlogin($twitter_id);

			/* redirecting */
			return Redirect::to('/')
				->with('message-success','Welcome! Login success!')
			;
		} else {
			/* Save HTTP status for error dialog on connnect page.*/
			return Redirect::to('/')
				->with('message-warning','Your session expired!')
			;
		}
	}

	/* Form upload */
	public function getUpload()
	{
		return View::make('Videocontest::form-upload');
	}

	public function postUpload()
	{
		$input = Input::all();
		$validation = Validator::make($input, Video::$rules_upload);
		if($validation->passes())
		{
			$input = array_add($input, 'participant_id', Videocontest::getUser());
			
			$slug = Input::get('caption');
			$slug = Str::slug($slug);
			$input = array_add($input, 'slug', $slug);

			Video::create($input);
			return Redirect::to('/gallery')
				->with('message-success', 'Your video has been submitted!')
			;
		}
		return Redirect::to('upload')
			->withInput()
			->withErrors($validation)
			->with('message-error','Please check the following errors!')
		;
	}

	public function gallery()
	{
		$videos = Videocontest::gallery();
		return View::make('Videocontest::gallery', compact('videos'));
	}

	public function leaderboard()
	{		
		$videos = Videocontest::leaderboard();
		return View::make('Videocontest::leaderboard', compact('videos'));
	}

	/* GET register */
	public function getRegister()
	{
		if(Videocontest::hasTwitter())
		{
			$twitter_id = Videocontest::getTwitter('user_id');
			if(! Videocontest::userRegistered($twitter_id)){
				return View::make('Videocontest::form-register');
			}else{				
				return Redirect::to('/')
					->with('message-warning', 'You have been registered!')
				;
			}
		}
		return Redirect::to('/')
			->with('message-warning', 'You must connect to twitter first!')
		;	
	}

	/* POST register */
	public function postRegister()
	{
		$input = Input::all();
		$validation = Validator::make($input, Participant::$rules);
		if($validation->passes())
		{
			$user_id = Videocontest::getTwitter('user_id');
			$input = array_add($input, 'network_id', $user_id);

			Participant::create($input);
			Videocontest::setUserlogin($user_id);	

			return Redirect::to('/')
				->with('message-success', 'Your account has been registered!')
			;
		}
		return Redirect::to('register')
			->withInput()
			->withErrors($validation)
			->with('message-error','Please check the following errors!')
		;
	}

	public function logout()
	{
		Session::forget('access_token');
		Session::forget('status');
		Session::forget('user_id');
		Session::forget('network_id');
		return Redirect::to('/')
			->with('message-success','Logout success!')
		;
	}

	public function singleVideo($slug=null)
	{
		$video = Videocontest::singleVideo($slug);
		if(empty($video)){			
			return View::make('Videocontest::video-404');
		}
		return View::make('Videocontest::single-video', compact('video'));
	}

	/* STATIC PAGE */
	public function terms()
	{
		return View::make('Videocontest::terms');
	}

	public function prize()
	{
		return View::make('Videocontest::prize');
	}

	/* Vote */
	public function postVote($id=null)
	{
		if(!Videocontest::hasUser())
		{
			$msg = "You must login first!";
			return Redirect::to('/')
				->with('message-error',$msg)
			;
		}
		$findVideo = Video::find($id);
		if(!empty($findVideo))
		{
			$user_id = Videocontest::getUser();
			$isVoted = Vote::where('participant_id', $user_id)
				->where('video_id', $id)
				->count()
			;
			if(empty($isVoted))
			{
				$values = array(
					'participant_id'	=> 	$user_id,
					'video_id'	=>	$id,
					'ip'		=>	Request::server('REMOTE_ADDR'),
					'detail'	=>	json_encode(array(
						'time'	=>	time(),
						'ip'	=>	Request::server('REMOTE_ADDR'),
						'agent'	=>	Request::server('HTTP_USER_AGENT'),
						'lang'	=>	Request::server('HTTP_ACCEPT_LANGUAGE')	
						)
					)
				);
				Vote::create($values);

				/* Auto Text fill */				
				$status = Config::get('Videocontest::app.twitter.auto-tweet.after-vote');
				$search = array(
					':video_name'	,
					':video_url'	,
					':url'			,
					':appname'		,
				);
				$replace = array(
					'"'.$findVideo->caption.'"',
					Videocontest::shorten($findVideo->id),
					url(),
					Config::get('Videocontest::app.appname')
				);
				$status = Videocontest::autoText($status, $search, $replace);
				// return $status;
				// exit;
				/* sent tweet to twitter */
				$this->twitter->post('statuses/update', array('status' => $status));

				$msg = 'Thanks for your voting!';
				return Redirect::back()
					->with('message-success',$msg)
				;
			}
			$msg = 'You have been vote this video before!';
			return Redirect::back()
				->with('message-error',$msg)
			;
		}
		$msg = "Video not found!";
		return Redirect::back()
			->with('message-error',$msg)
		;
	}

	/* share to twitter */
	public function postTweet($id=null)
	{
		if(!Videocontest::hasUser())
		{
			$msg = "You must login first!";
			return Redirect::to('/')
				->with('message-error',$msg)
			;
		}
		$findVideo = Video::find($id);
		if(!empty($findVideo))
		{
			$user_id = Videocontest::getUser();
			$values = array(
				'participant_id'	=> 	$user_id,
				'type'		=>	'twitter',
				'video_id'	=>	$id,
				'ip'		=>	Request::server('REMOTE_ADDR'),
				'detail'	=>	json_encode(array(
					'time'	=>	time(),
					'ip'	=>	Request::server('REMOTE_ADDR'),
					'agent'	=>	Request::server('HTTP_USER_AGENT'),
					'lang'	=>	Request::server('HTTP_ACCEPT_LANGUAGE')	
					)
				)
			);
			try{
				$status = Config::get('Videocontest::app.twitter.auto-tweet.after-share');
				/* Auto Text fill */
				$search = array(
					':video_name'	,
					':video_url'	,
					':url'			,
					':appname'		,
				);
				$replace = array(
					'"'.$findVideo->caption.'"',
					Videocontest::shorten($findVideo->id),
					url(),
					Config::get('Videocontest::app.appname')
				);
				$status = Videocontest::autoText($status, $search, $replace);
				// return $status;
				// exit;
				/* sent tweet to twitter */
				$this->twitter->post('statuses/update', array('status' => $status));
				/* save log tweet */
				Sharelog::create($values);
				/* redirecting */
				$msg = 'Thanks for your sharing!';
				return Redirect::to('/gallery')
					->with('message-success',$msg)
				;
			}catch(Exception $e){
				$msg = $e->getMessage();
				return Redirect::to('/gallery')
					->with('message-error',$msg)
				;
			}			
		}
		$msg = "Video not found!";
		return Redirect::to('/gallery')
			->with('message-error',$msg)
		;
	}

	public function v($id = null)
	{
		$v = Video::find($id);
		if(!empty($v))
		{
			$vURL = Videocontest::uniqueURL($id);
			return Redirect::to($vURL);
		}
		return View::make('Videocontest::video-404');
	}
}