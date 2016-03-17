<?php

class ErrorController extends \BaseController {
	public function notfound()
	{
		return View::make('error.404');
	}
	

	public function internalerror()
	{
		return View::make('error.500');
	}
}