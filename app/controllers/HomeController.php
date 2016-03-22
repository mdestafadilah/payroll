<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showLogin()
	{
		return View::make('login');
	}


	public function doLogin()
	{
		$logAttempt = 0;
		$input = Input::all();
		$rules = array(
			'username' => 'required',
			'password' => 'required'
			);

		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::to('login')->withErrors($validator);
		} else {
			$credentials = array(
				'username' => $input['username'],
				'password' => $input['password'],
				'del_flg' => '0',
				);

			if(Auth::attempt($credentials))

			{	$langu=Auth::user()->langu;
				App::setLocale($langu);
				Session::put('my.locale',$langu);

				return Redirect::to('employees');
			} else {
				$user_get_id = User::where('username', $input['username'])->first();
				$condition = User::where('username', $input['username'])->count();

				if($condition > 0){
					$user_id = $user_get_id->user_id;
					$user = User::find($user_id);

					if($user->del_flg == 1){
						Session::flash('errormessage', 'User blocked! Contact your System Administrator');
					}else{
						Session::flash('errormessage', 'Username or Password is incorrect!');
						$user->save();
					}
				}else{
					Session::flash('errormessage', 'User does not exist!');
				}
				return Redirect::to('login');
			}
		}
	}


	public function getEmpRequest(){
		return View::make('payrollRequest');
	}


	public function postPayrollRecord(){

		if(Input::has('emp_id')){
			$emp_id= Input::get('emp_id');
			$employee = Payroll::where('emp_id', '=', $emp_id)->orderBy('payroll_id', 'ASC')->paginate(20);
			if($employee->count() < 1){
				Session::flash('errormessage', 'No such Payroll Record Found');
				return Redirect::to('request');
			}
			return View::make('payroll-records')->with('employee',$employee);

		}else{
			return Redirect::to('request');
		}


	}	


	public function postPayrollRecordRequest(){
		$Erequest = new EmpRequest;
		$pay_id = Input::get('payid');
		$pay_id_qry = EmpRequest::where('payroll_id', '=',$pay_id,'and', 'approve','=','0')->get();

		if ($pay_id_qry->count() > 0){
			Session::flash('errormessage', 'You already requested this payroll');
			return Redirect::to('request');
		}
		else {
			$Erequest->payroll_id = $pay_id;
			$Erequest->emp_id = Input::get('empid');
			$Erequest->user_id = null;
			$Erequest->save();
			Session::flash('message', 'Request successfully submitted!');
			return Redirect::to('request');
		}
	}
	

	public function logout()
	{
		Auth::logout();
		Session::flush();
		return Redirect::to('/');
	}

}
