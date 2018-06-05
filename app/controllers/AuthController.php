<?php

class AuthController extends BaseController {
	public function show() {
		return View::make('auth.login');
	}

	public function login() {
	    if (! Auth::attempt(array(
   	    	'email' => Input::get('email'),
        	'password' => Input::get('password')))) {
    		return Redirect::to('/login')->withInput(Input::except('password'))
        		->with('message', 'Die Anmeldung ist fehlgeschlagen');
		}
        Config::set('session.driver', 'cookie');
		//setcookie('laravel_cache', '0');

        return Redirect::intended('/');
	}

	public function logout() {
		Auth::logout();
		//setcookie('laravel_cache', '', time() - 3600);

		return Redirect::to('/');
	}
}

?>
