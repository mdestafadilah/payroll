<?php

class HomeController extends BaseController {

	public function showLogin()
	{
		return Redirect::to("http://". $_SERVER['HTTP_HOST']);
	}


	public function doLogin()
	{	
		if(isset($_COOKIE["userid"]) && isset($_COOKIE["PHPSESSID"])){
			$userId = $_COOKIE["userid"];
            $sessionId = $_COOKIE["PHPSESSID"];
            $count = User::where('user_id', $userId)->where('session_id',$sessionId)->count();

            if ($count > 0 ) { 
				$userInfo = User::where('user_id', $userId)->where('session_id',$sessionId)->first();
				$passwordSalt = 'xQvVxnnZ9MH4HGNUeQScDhguEcNQtsCN';
		        $decPassword = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $passwordSalt, base64_decode($userInfo->password), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
				
				$credentials = array(
					'username' => $userInfo->username,
					'password' => $decPassword,
					'del_flg' => '0',
					);

				if(Auth::attempt($credentials))

				{	
					$langu=Auth::user()->langu;
					App::setLocale($langu);
					Session::put('my.locale',$langu);

					return Redirect::to('employees');
				} else {
					$this->cookie();
					return Redirect::to("http://". $_SERVER['HTTP_HOST']);
				}


            } else {
            	$this->cookie();
           		return Redirect::to("http://". $_SERVER['HTTP_HOST']);
            }

	        
		} else {
			
            $this->cookie();
			return Redirect::to("http://". $_SERVER['HTTP_HOST']);
		}


	}

	public function cookie(){
		// Cookie::queue('error', 'value', '1');
		Cookie::queue(Cookie::forget('PHPSESSID'));
		Cookie::queue(Cookie::forget('userid'));
    	Cookie::queue(Cookie::forget('laravel_session'));
		Cookie::queue(Cookie::forget('ci_session'));
		Cookie::queue(Cookie::forget('csrf_cookie'));
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


}
