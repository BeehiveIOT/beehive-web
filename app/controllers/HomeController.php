<?php

class HomeController extends BaseController {
	public function index() {
		if (Auth::check()) {
			return Redirect::to('dashboard');
		}
		return View::make('home.index');
	}

	public function login() {
		if (Auth::check()) {
			return Redirect::to('dashboard');
		}
		return View::make('home.login');
	}

	public function doLogin() {
		if (Auth::attempt(['username'=>Input::get('username'),
			'password' =>Input::get('password')])) {

			return Redirect::to('/');
		}
		return Redirect::to('login')
			->with('error', 'Invalid credentials');
	}

	public function doLogout() {
		Auth::logout();

		return Redirect::to('/');
	}

	public function register() {
		return View::make('home.register');
	}

	public function doRegister() {
		return "";
	}
}
