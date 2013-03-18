<?php

use Carbon\Carbon;

class AuthController extends BaseController {

	public function __construct()
	{
		$this->tmhOAuth = new tmhOAuth(array(
			'consumer_key'    => 'VOHDAzuOuHxen293By9vjQ',
			'consumer_secret' => 'sDlD15hzFtXrYtzVBMJgjT2byYtvn7nnydCzB2yvBE'
		));
	}

	public function welcome()
	{
		return View::make('auth.login');
	}

	public function login()
	{
		$params = array(
			'oauth_callback' => "http://presidium.dev/auth/callback"
		);

		$code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('oauth/request_token', ''), $params);

		if ($code == 200)
		{
			$oauth = $this->tmhOAuth->extract_params($this->tmhOAuth->response['response']);
			Session::put('oauth', $oauth);
			$authurl = $this->tmhOAuth->url('oauth/authenticate', '') . "?oauth_token={$oauth['oauth_token']}";
			return Redirect::to($authurl);
		}
		else
		{
			var_dump($code);
			return "Error: " . $this->tmhOAuth->response['response'];
		}
	}

	public function callback()
	{
		$oauth = Session::get('oauth');
		$this->tmhOAuth->config['user_token']  = $oauth['oauth_token'];
		$this->tmhOAuth->config['user_secret'] = $oauth['oauth_token_secret'];

		$code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('oauth/access_token', ''), array(
		    'oauth_verifier' => Request::get('oauth_verifier')
		));

		if ($code == 200) {
			Session::put('access_token', $this->tmhOAuth->extract_params($this->tmhOAuth->response['response']));
			Session::forget('oauth');

			$token = Session::get('access_token');
			$this->tmhOAuth->config['user_token'] = $token['oauth_token'];
			$this->tmhOAuth->config['user_secret'] = $token['oauth_token_secret'];

			// Store user in session.
			$code =	$this->tmhOAuth->request('GET', $this->tmhOAuth->url('1.1/account/verify_credentials'));

			if ($code !== 200)
			{
				return "Details Error: " . $this->tmhOAuth->response['response'];
			}
			else
			{
				$userDetails = json_decode($this->tmhOAuth->response['response']);
				var_dump($userDetails);

				$exists = User::where('twitter_id', '=', $userDetails->id)->get();

				if (!count($exists))
				{
					// add to table
					$user = new User();

					$user->twitter_id = $userDetails->id;
					$user->email = "";
					$user->authorized = false;
				}

				else
				{
					$user = $exists[0];
				}
				$user->name = $userDetails->name;
				$user->screen_name = $userDetails->screen_name;
				$user->last_login = Carbon::now();
				$user->last_active = Carbon::now();

				$user->save();

				if ($user->authorized)
				{
					Session::put('user_id', $user->id);
					return Redirect::to('/');
				}
				else
				{
					return Redirect::to('/private');
				}
			}
		} else {
			var_dump($code);
			return "Auth Error: " . $this->tmhOAuth->response['response'];
		}
		return "Callback!";
	}

	public function sitePrivate()
	{
		return View::make('auth.private');
	}
}