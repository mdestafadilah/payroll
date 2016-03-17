<?php

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});


Route::filter('admin', function()
{

	if (Auth::guest()){
		Session::flash('errormessage', 'Please login first!');
		return Redirect::to('login');
	} 

	if (Auth::user()->usr_role != 1){
		Session::flash('errormessage', 'Ooh oh.You do not have rights to view the page you entered.');
		return Redirect::to('employees');
	}
	
});

Route::filter('hr', function()
{

	if (Auth::guest()){
		Session::flash('errormessage', 'Please login first!');
		return Redirect::to('login');
	} 
	
	if (Auth::user()->usr_role != 0){
		Session::flash('errormessage', 'Ooh oh.You do not have rights to view the page you entered.');
		return Redirect::to('employees');
	}
	
});


Route::filter('auth', function()
{
	if (Auth::guest()){
		Session::flash('errormessage', 'Please login first!');
		return Redirect::to('login');
	} 
	
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()){
		return Redirect::to('/employees');
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

App::after(function ($request, $response) {
	$response->headers->set("Cache-Control","no-cache,no-store, must-revalidate");
	$response->headers->set("Pragma", "no-cache"); 
	$response->headers->set("Expires"," Sat, 26 Jul 1997 05:00:00 GMT"); 
});

Route::filter('invalidate-browser-cache', function($route, $request, $response)
{
	$response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
	$response->headers->set('Pragma','no-cache');
	$response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
	return $response;
});