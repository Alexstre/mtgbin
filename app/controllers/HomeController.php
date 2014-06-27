<?php

class HomeController extends \BaseController {

	public function getIndex() {
		return View::make('user.login');
	}

	public function postIndex() {
		$username = Input::get('username');
		$password = Input::get('password');

		if (Auth::attempt(array('username' => $username, 'password' => $password))) {
			return Redirect::intended('/admin');
		}
		return Redirect::back()->withInput()->withErrors('What are you doing?!');
	}

	public function getLogin() {
		return Redirect::to('user');
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::to('/');
	}

}
