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
			'oauth_callback' => URL::route('twitterCallback')
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

				$exists = User::where('twitter_id', '=', $userDetails->id)->get();

				if (!count($exists))
				{
					// add to table
					$user = new User();

					$user->twitter_id = $userDetails->id;
					$user->email = "";

					$allowed_users = Config::get('access.allowed');

					$user->authorized = in_array($userDetails->screen_name, $allowed_users);
				}

				else
				{
					$user = $exists[0];
					if (!$user->authorized && in_array($userDetails->screen_name, $allowed_users))
					{
						$user->authorized = true;
					}
				}

				$user->name = $userDetails->name;
				$user->screen_name = $userDetails->screen_name;
				$user->last_login = Carbon::now();
				$user->last_active = Carbon::now();

				$user->save();

				if ($user->authorized)
				{
					$imgUrl = $userDetails->profile_image_url;

					$response = Requests::get($imgUrl);
					if ($response->status_code == 200)
					{
						file_put_contents(public_path() . '/images/profile/'.$user->id.'.jpg', $response->body);
						$user->profile_image = '/images/profile/'.$user->id.'.jpg';
						$user->save();
					}

					Session::put('user', $user);
					return Redirect::route('home');
				}
				else
				{
					return Redirect::route('private');
				}
			}
		} else {
			//var_dump($code);
			return "Auth Error: " . $this->tmhOAuth->response['response'];
		}
		return "Callback!";
	}

	public function sitePrivate()
	{
		return View::make('auth.private');
	}
}