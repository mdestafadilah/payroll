<?php

class PayrollController extends \BaseController {


	public function getAttend($emp_id){
		$emp_id = Employee::find($emp_id);
		return View::make('employees.attendance')
		->with('employees',$emp_id);
	}


	public function postAttend(){

		$emp_id=Input::get('empid');

		$condition=Employee::where('emp_id',$emp_id)->where('del_flag',0);

		if($condition->count() == 0){
			return Redirect::back()->with("errormessage","Employee is disabled. Please enable first!");
		}

		$rules=array(

			'attendance'	=> 'required',
			'timeIn'		=> 'required',
			'timeOut'		=> 'required'
			);
		$v = Validator::make(Input::all(),$rules);
		if($v->fails()){
			return Redirect::to('employees/'.$emp_id.'/stats/create')->withErrors($v);
		}else{
			$day 		= Input::get('attendance');
			$timeIn 	= Input::get('timeIn');
			$timeOut	= Input::get('timeOut');
			$aLate		= Input::get('acceptedLate');

			if(HTMLHelper::duplicateDate($emp_id,$day)) {
				return Redirect::back()->with('errormessage','Attendance date already exist');
			}
			$dType = Input::get('holidayType');
			if($dType == null){
				$dType = 0;
			}
			$data = HTMLHelper::calculate($timeIn, $timeOut,$dType,$day,$aLate);
			$time	=	 new Time;
			$time->emp_id 			= $emp_id;
			$time->attendance_date 	= $day;
			$time->time_in 			= $timeIn;
			$time->time_out 		= $timeOut;
			$time->time_ot 			= $data['ot'];
			$time->time_late 		= $data['late'];
			$time->time_total 		= $data['total'];
			$time->user_id 			= Auth::user()->user_id;
			$time->day_type			=$dType;
			$time->save();

			$max_time_id = Time::where('emp_id','=',$emp_id)->max('time_id');
			
			return Redirect::back()->with('message','Successfully Added!'.' '.'<b><font color="black">Date : </font></b>'.$day.'<b><font color="black"> Time in : </font></b>'.$timeIn.'<b><font color="black"> Time out : </font></b>'.$timeOut.'. If made mistake please <a href="/employees/'.$max_time_id.'/stats/edit">CLICK HERE</a>');

		}
	}


	public function getAttendC($emp_id){
		$emp	=	Employee::find($emp_id);
		return View::make('employees.csvimport')->with('employee',$emp);
	}


	public function postAttendC($emp_id){
		$data = Input::all();
		$rule = array(
			'csv' => 'required'
			);
		$v = Validator::make($data,$rule);
		if($v->fails()){
			return Redirect::to('employees/'.$emp_id.'/stats/creates')->withErrors($v);
		}

		$file_ex = $data['csv']->getClientOriginalExtension();

		if (!in_array($file_ex, array('csv'))){
			Session::flash('errormessage', 'Only CSV format only. Please try again.');
			return Redirect::back();
		}

		if ($data['csv'] != '') {
			$file = $data['csv'];
			$file->move(base_path().'/csv', $file->getClientOriginalName());
			$pathToFile = base_path().'/csv/' . $file->getClientOriginalName();
		}
		$some="";
		$handle = fopen($pathToFile,'r');
		while ($data = fgetcsv($handle,1000,",","'")) {
			if ($data[0]) {
				$dType=0;
				//return count($data);
				if(count($data)>3){
					$dType = ($data[3]==null?0:$data[3]);
					if($dType >2){
						return	Redirect::back()->with('errormessage','Invalid holiday type on '.$data[0].' ');
					}
				}
				if(count($data)<5){
					$data[4]=0;
				}
				$com = HTMLHelper::calculate($data[1], $data[2],$dType,$data[0],$data[4]);
				if(!HTMLHelper::duplicateDate($emp_id,$data[0])) {

					$time = new Time;
					$time->emp_id 			=	 $emp_id;
					$time->attendance_date 	=	 $data[0];
					$time->time_in 			=	 $data[1];
					$time->time_out 		= 	 $data[2];
					$time->time_ot 			=	 $com['ot'];
					$time->time_late 		=	 $com['late'];
					$time->time_total 		=	 $com['total'];
					$time->user_id 			=	 Auth::user()->user_id;
					$time->day_type 		= 	 $dType;
					$time->save();
				}else{
					return Redirect::back()->with('errormessage','Attendance date '.$data[0].' already exist');
				}

			}
		}

		fclose($handle);
		Session::flash('message','Successfully imported');
		return Redirect::to('employees/'.$emp_id.'/stats/');
	}


	public function getEditAttend($emp_id){
		$employee = Time::find($emp_id);
		return View::make('employees.editTime')->with('employee',$employee);
	}


	public function postEditAttend($time_id){
		$rules=array(

			'attendance' 	=>	 'required',
			'timeIn'		=>	 'required',
			'timeOut' 		=>	 'required'
			);

		$v = Validator::make(Input::all(),$rules);
		if($v->fails()){
			return Redirect::to('employees/'.$time_id.'/stats/edit')->withErrors($v);
		}else{
			$dType = Input::get('holidayType');
			if($dType == null){
				$dType = 0;
			}
			$day		=	Input::get('attendance');
			$timeIn 	=	Input::get('timeIn');
			$timeOut	= 	Input::get('timeOut');
			$aLate		=	Input::get('acceptedLate');

			$data = HTMLHelper::calculate($timeIn,$timeOut ,$dType,$day,$aLate);

			$time= Time::find($time_id);
			$time->attendance_date	 =	 $day;
			$time->time_in	 		 = 	 $timeIn;
			$time->time_out			 =	 $timeOut;
			$time->time_ot			 =	 $data['ot'];
			$time->time_late		 =	 $data['late'];
			$time->time_total 		 =	 $data['total'];
			$time->user_id			 =	 Auth::user()->user_id;
			$time->day_type			 =	 $dType;
			$time->save();
			Session::flash('message','Successfully save');
			return Redirect::to('employees/'.$time->emp_id.'/stats/');
		}
	}


	public function doDeleteAttend($time_id){
		$time = Time::find($time_id);
		$time->delete();
		return Redirect::back()->with('message','Attendace successfully deleted');
	}


	public function getPayroll($emp_id){
		$employee	=	Payroll::where('emp_id','=',$emp_id)->paginate(5);
		$stay = Payroll::where('emp_id',$emp_id)
		->where('coverage','LIKE','%13th Mo. '.date('Y').'%')
		->get();

		if($stay->count()==0){
			Session::flash('bonus',1);
		}

		if($employee->count()<1){
			Session::flash('errormessage', 'No Payroll logs available. Please create one.');
			Session::flash('flg',1);
			return Redirect::to('employees/'.$emp_id.'/payslip');
		}else{
			return View::make('employees.payroll')
			->with('employees', $employee);
		}
	}


	public function getPayslip($emp_id){

		$employee = DB::table('employees')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->where('employees.emp_id', '=', $emp_id)
		->select(DB::raw('*'))
		->first();
		return View::make('admin.iPayslip')->with('employee', $employee);

	}


	public function postPayslip($emp_id){
		$chEmp= Payroll::where('emp_id',$emp_id)->get();

		if($chEmp->count()<1){
			Session::flash('flg',1);
		}
		$input=Input::all();
		$rules = array(
			'from'	 =>	 'required',
			'to'	 =>	 'required'
			);
		$v = Validator::make($input,$rules);

		if($v->fails()){
			return Redirect::to('employees/'.$emp_id.'/payslip')->withErrors($v);
		}else {
			$from	 =	 $input['from'];
			$to		 =	 $input['to'];

			$rate = Rate::where('emp_id', $emp_id)->first();
			if($rate->salary <=0){
				return Redirect::back()->
				with('errormessage','Kindly set employee\'s salary first');
			}

			if(Carbon\Carbon::now() < date('Y-m-d',strtotime($from)) ||
				Carbon\Carbon::now() < date('Y-m-d',strtotime($to)) ){
				Session::flash('errormessage', 'Invalid input date');

			return Redirect::to('employees/'.$emp_id.'/payslip');
			}

		$employee = DB::table('employees')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->join('employer_contribution', 'employees.emp_id', '=', 'employer_contribution.emp_id')
		->where('employees.emp_id', '=', $emp_id)
		->select(DB::raw('*'))
		->first();

		$total = HTMLHelper::salary($emp_id, $from, $to);
		if($total == false){
			Session::flash('errormessage', 'No attendance for the requested dates');
			return Redirect::to('employees/'.$emp_id.'/payslip');
		}
		$deductions = HTMLHelper::deductions($emp_id);
		$ot = HTMLHelper::overTime($emp_id,$from, $to);
		$late = HTMLHelper::late($emp_id,$from,$to);
		$cover = date('M-j',strtotime($from)).'-'. date('j, Y', strtotime( $to));
		$w_tax = ($employee->salary==0?0:HTMLHelper::TaxCompute($emp_id,$ot,$deductions));

		if(HTMLHelper::duplicate($emp_id,$cover)){
			Session::flash('errormessage','Payroll already exist');
			return Redirect::to('employees/'.$emp_id.'/payslip');
		}
		$payroll	 =	 new Payroll;
		$payroll->emp_id	 =	 $emp_id;
		$payroll->grosspay 	 =	 $total;
		$payroll->days		 =	 HTMLHelper::days($emp_id,$from,$to);
		if(substr($from,8,2) < 16){
			$payroll->sssContrib		 =	 ($employee->salary == 0?0:$employee->sss_tax);
			$payroll->philHealthContrib	 =	 ($employee->salary == 0?0:$employee->philhealth_tax);
			$payroll->pagibigContrib	 =	 ($employee->salary == 0?0:$employee->pagibig_tax);
			$payroll->sssER				 =	 ($employee->salary == 0?0:$employee->sssERC);
			$payroll->phER				 =	 ($employee->salary == 0?0:$employee->philHealthERC);
			$payroll->piER				 =	 ($employee->salary == 0?0:$employee->pagibigERC);
			$payroll->w_tax				 = 	 '0';
			$deductions					 =	 $deductions+$late;

		}else {
			$payroll->sssContrib		 =	 0;
			$payroll->philHealthContrib	 =	 0;
			$payroll->pagibigContrib	 =	 0;
			$payroll->w_tax				 =	 $w_tax;
			$deductions				 	 =	 $w_tax +$late;
		}
		$payroll->late_deduction		 =	 $late;
		$payroll->netpay				 =	 $total - $deductions;
		$payroll->deduction				 =	 $deductions;
		$payroll->coverage				 = 	 $cover;
		$payroll->user_id				 =	 Auth::user()->user_id;
		$payroll->ot					 =	 $ot;
		// return $payroll;
		$payroll->save();
		$pId = Payroll::all()->last();

		return Redirect::to('employees/'.$emp_id.'/payroll')->with('message','Payslip generated successfully!');
		}
	}


	public  function showPayslip($payroll_id){
		$employee	 =	 Payroll::find($payroll_id);
		if($employee	==	null){
			Session::flash('errormessage','Payslip not available');
			return Redirect::back();
		}
		$rate = Rate::find($employee->emp_id);
		return View::make('showPayslip')->with('payroll',$employee)
		->with('rate',$rate);
	}


	public function getReport(){
		$year	 =	 '';
		$cov = Payroll::distinct()->lists('coverage');

		if($cov == null){
			return Redirect::to('employees')->with('errormessage','No Reports Found.');
		}
		$emp = $employee = DB::table('employees')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
		->where('employee_payroll.coverage','=',$cov[0])
		->select(DB::raw('*'))
		->orderBy('employees.emp_id')
		->get();

		Session::flash('cover',$cov[0]);
		Session::put('sess_month',0);

		return View::make('employees.payrollReport')->with('employee',$emp)
		->with('coverage',$cov)->with('yrholder',$year);
	}


	public function postReport(){

		$coverage	 =	 Input::get('coverage');
		$year	 	 =	 Input::get('yrholder');

		$cov = Payroll::distinct()->where('employee_payroll.coverage', 'LIKE', '%'.$year.'%')->lists('coverage');

		$emp  = DB::table('employees')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
		->where('employee_payroll.coverage','=',$cov[$coverage])
		->select(DB::raw('*'))
		->orderBy('employees.emp_id')
		->get();

		Session::flash('cover', $cov[$coverage]);
		Session::put('sess_month', $coverage);
		Session::put('sess_year',$year);

		return View::make('employees.payrollReport')->with('employee',$emp)
		->with('coverage',$cov)->with('yrholder',$year);
	}


	public function getSave($payroll_id){

		$data = DB::table('employees')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
		->where('employee_payroll.payroll_id', '=', $payroll_id)
		->select(DB::raw('*'))
		->first();
		if($data == null&& $data == ""){
			Session::flash('errormessage','Payroll not available');
			return Redirect::back();
		}

		$payroll = array(
			'fullname'	 =>	 $data->firstname .' ' .$data->lastname,
			'hired'		 =>	 $data->hired_date,
			'pos'		 =>	 $data->position,
			'sss'		 =>	 $data->sssContrib,
			'ph'		 =>	 $data->philHealthContrib,
			'pI'		 =>	 $data->pagibigContrib,
			'salary'	 =>	 $data->salary,
			'rate'		 =>	 $data->rate,
			'gross'		 =>	 $data->grosspay,
			'net'		 =>	 $data->netpay,
			'deduction'	 =>	 $data->deduction,
			'coverage'	 =>	 $data->coverage,
			'allowance'	 =>	 $data->allowance,
			'ot'		 =>	 $data->ot,
			'tax'		 =>	 $data->w_tax
			);

		$pdf = \App::make('dompdf');
		$pdf->loadView('payslipSave', $payroll);

		return $pdf->download(ucwords($data->firstname.' '. $data->lastname).' '.$data->coverage .' payroll.pdf');
	}


	public function getRPayslip($payroll_id){

		$employee = DB::table('employees')
		->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->where('employee_payroll.payroll_id', '=', $payroll_id)
		->select(DB::raw('*'))
		->first();
		return View::make('admin.iPayslip')->with('employee', $employee);

	}


	public function postRPayslip($payroll_id){

		$input=Input::all();
		$rules = array(
			'from' => 'required',
			'to' => 'required'
			);
		$v = Validator::make($input,$rules);
		if($v->fails()){
			return Redirect::to('employees/'.$payroll_id.'/payslip/edit')->withErrors($v);
		}else {

			$from =$input['from'];
			$to =$input['to'];
			if(Carbon\Carbon::now() < date('Y-m-d',strtotime($from)) ||
				Carbon\Carbon::now() < date('Y-m-d',strtotime($to)) ){
				Session::flash('errormessage', 'Invalid input date');

			return Redirect::to('employees/'.$payroll_id.'/payslip/edit');
		}
		$employee = DB::table('employees')
		->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->join('employer_contribution', 'employees.emp_id', '=', 'employer_contribution.emp_id')
		->where('employee_payroll.payroll_id', '=', $payroll_id)
		->select(DB::raw('*'))
		->first();
		$emp_id = $employee->emp_id;
		$total = HTMLHelper::salary($emp_id, $from, $to);
		$deductions = HTMLHelper::deductions($emp_id);
		$ot = HTMLHelper::overTime($emp_id,$from, $to);
		$late = HTMLHelper::late($emp_id,$from,$to);
		$cover = date('M-j',strtotime($from)).'-'. date('j, Y', strtotime( $to));
		$w_tax = HTMLHelper::TaxCompute($emp_id,$ot,$deductions);

		$payroll = Payroll::find($payroll_id);
		$payroll->emp_id = $emp_id;
		$payroll->grosspay = $total;
		if(substr($from,8,2) < 16){

			$payroll->sssContrib		 = ($employee->salary == 0? 0:$employee->sss_tax);
			$payroll->philHealthContrib	 = ($employee->salary == 0?0:$employee->philhealth_tax);
			$payroll->pagibigContrib	 = ($employee->salary == 0?0:$employee->pagibig_tax);
			$payroll->sssER				 = ($employee->salary == 0?0:$employee->sssERC);
			$payroll->phER				 = ($employee->salary == 0?0:$employee->philHealthERC);
			$payroll->piER				 = ($employee->salary == 0?0:$employee->pagibigERC);
			$payroll->w_tax				 ='0';
			$deductions					 = $deductions+$late;
		}else{
			$payroll->sssContrib		 = 0;
			$payroll->philHealthContrib	 = 0;
			$payroll->pagibigContrib	 = 0;
			$payroll->w_tax				 = $w_tax;
			$deductions				 	 = $w_tax + $late;
		}
		$payroll->late_deduction		 = $late;
		$payroll->netpay				 = $total - $deductions;
		$payroll->deduction				 = $deductions;
		$payroll->coverage				 = $cover;
		$payroll->user_id				 = Auth::user()->user_id;
		$payroll->ot					 = $ot;
		$payroll->days					 = HTMLHelper::days($emp_id,$from,$to);
				//$payroll->save();
		return $payroll;
		$pId = Payroll::find($payroll_id);

		return Redirect::to('employees/'.$emp_id.'/payroll')->with('message','Payslip generated successfully!');
		}
	}


	public function payrollhandler()
	{
		if(Input::get('show')) {
				//$getFIlter = $this->getFilter();
				//$postreport = $this->postreport();

				//return $this->getFilter();
			return $this->postreport();
		} elseif(Input::get('filter')) {
			return $this->search();
		} else{
			return $this->getreport();
			return $this->postreport();
		}

	}


	public function search()
	{
		if(Input::has('yearly')){
			$year = Input::get('yearly');

			$cov = Payroll::distinct()->where('employee_payroll.coverage', 'LIKE', '%'.$year.'%')
			->lists('coverage');

			if($cov == null){
				Session::flash('errormessage','No Reports Found.');
				return $this->getreport();
				return $this->postreport();
			}

			$emp = DB::table('employees')
			->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
			->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
			->where('employee_payroll.coverage', '=', $cov[0])
			->orderBy('employees.emp_id')
			->get();

			Session::flash('cover', $cov[0]);


			return View::make('employees.payrollReport')->with('employee',$emp)
			->with('coverage',$cov)->with('yrholder',$year);
		}else{
			Session::flash('errormessage','Input Filter!');
			return $this->getreport();
			return $this->postreport();
		}

	}


	public function getFilter()
	{
		$year = Input::get('yrholder');

		$cov = Payroll::distinct()->where('employee_payroll.coverage', 'LIKE', '%'.$year.'%')
		->lists('coverage');

		if($cov == null){
			return $this->getreport();
			return $this->postreport();
		}

		$emp = DB::table('employees')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
		->where('employee_payroll.coverage', '=', $cov[0])
		->orderBy('employees.emp_id')
		->get();

		Session::flash('cover', $cov[0]);
		return View::make('employees.payrollReport')->with('employee',$emp)
		->with('coverage',$cov)->with('yrholder',$year);
	}


	public function Bonus($emp_id){
		if(date('m') == 12 && date('d')<24){
			$stay = Payroll::where('emp_id',$emp_id)
			->where('coverage','LIKE','%'.date('Y').'%')
			->get();
			$cover ='13th Mo. '.date('Y');
			if(HTMLHelper::duplicate($emp_id,$cover)){
				Session::flash('errormessage','Payroll already exist');
				return Redirect::back();
			}
			$rate = Rate::where('emp_id', $emp_id)->first();

			$employee = DB::table('employees')
			->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
			->join('employer_contribution', 'employees.emp_id', '=', 'employer_contribution.emp_id')
			->where('employees.emp_id', '=', $emp_id)
			->select(DB::raw('*'))
			->first();
			$p = ($rate->salary * $stay->count())/12;

			$payroll	 =	 new Payroll;
			$payroll->emp_id		 	 = $emp_id;
			$payroll->grosspay		 	 = $p;
			$payroll->days				 = 0;
			$payroll->sssContrib		 = 0;
			$payroll->philHealthContrib	 = 0;
			$payroll->pagibigContrib	 = 0;
			$payroll->w_tax				 = 0;
			$payroll->netpay			 = $p;
			$payroll->deduction			 = 0;
			$payroll->coverage			 ='13th Mo. '.date('Y');
			$payroll->user_id			 = Auth::user()->user_id;
			$payroll->ot				 =0;
			$payroll->save();
			$pId = Payroll::all()->last();

			return View::make('admin.payslip')->with('employee', $employee)
			->with('total', $p)
			->with('deduction', 0)
			->with('net', $p)
			->with('coverage','13th Mo. '.date('Y'))
			->with('payroll', $pId)
			->with('wtax', 0)
			->with('ot',0);

				//return $sum/12;
		}else{
			return Redirect::back()->with('errormessage','Sorry! It is still '. date('F'));
		}
	}


	public function rBonus($p_id){
		if(date('m') == 12 && date('d')<24){
			$payroll = Payroll::find($p_id);
			$stay = Payroll::where('emp_id',$payroll->emp_id)
			->where('coverage','LIKE','%'.date('Y').'%')
			->where('coverage','NOT LIKE','%13th%')
			->get();

			$rate = Rate::where('emp_id', $payroll->emp_id)->first();

			$employee = DB::table('employees')
			->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
			->join('employer_contribution', 'employees.emp_id', '=', 'employer_contribution.emp_id')
			->where('employees.emp_id', '=',$payroll->emp_id)
			->select(DB::raw('*'))
			->first();
			$p = ($rate->salary * $stay->count())/12;

			$payroll->grosspay			 = $p;
			$payroll->days				 = 0;
			$payroll->sssContrib		 = 0;
			$payroll->philHealthContrib	 = 0;
			$payroll->pagibigContrib	 = 0;
			$payroll->w_tax				 = 0;
			$payroll->netpay			 = $p;
			$payroll->deduction			 = 0;
			$payroll->coverage			 ='13th Mo. '.date('Y');
			$payroll->user_id			 = Auth::user()->user_id;
			$payroll->ot				 = 0;
			$payroll->save();
			$pId = Payroll::all()->last();

			return View::make('admin.payslip')->with('employee', $employee)
			->with('total', $p)
			->with('deduction', 0)
			->with('net', $p)
			->with('coverage','13th Mo. '.date('Y'))
			->with('payroll', $pId)
			->with('wtax', 0)
			->with('ot',0);

				//return $sum/12;
		}else{
			return Redirect::back()->with('errormessage','Sorry! It is still '. date('F'));
		}
	}


	public function  getHoliday($time_id){
		$time = Time::find($time_id);
		return Redirect::back()
		->with('time',$time->time_id)
		->with('error',5)
		->with('type', $time->day_type);

	}


	public function postHoliday($time_id){
		$time = Time::find($time_id);
		$time->day_type = Input::get('holiday');
		$time->save();
		return Redirect::back()->with('message', 'Successfully Saved')
		->with('holiVal',$time->day_type);
	}


	public function getBatchPrint()
	{
		$year = '';
		$cov = Payroll::distinct()->lists(Session::get('sess_month'));
		if($cov == null){
			return Redirect::to('employees')->with('errormessage','No Reports Found.');
		}
		$emp = $employee = DB::table('employees')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
		->where('employee_payroll.coverage','=',$cov[0])
		->select(DB::raw('*'))
		->orderBy('employees.emp_id')
		->get();

		Session::flash('cover',$cov[0]);
		return View::make('employees.batchprint')->with('employee',$emp)
		->with('coverage',$cov)->with('yrholder',$year);

	        // return View::make('employees.batchprint');
	}


	public function postBatchPrint()
	{
		$coverage = Session::get('sess_month');
		$year = Session::get('sess_year');
		$cov = Payroll::distinct()->where('employee_payroll.coverage', 'LIKE', '%'.$year.'%')->lists('coverage');

		$emp  = DB::table('employees')
		->join('employee_rate', 'employees.emp_id', '=', 'employee_rate.emp_id')
		->join('employee_payroll', 'employees.emp_id', '=', 'employee_payroll.emp_id')
		->where('employee_payroll.coverage','=',$cov[$coverage])
		->select(DB::raw('*'))
		->orderBy('employees.emp_id')
		->get();

		Session::flash('cover', $cov[$coverage]);
		return View::make('employees.batchprint')->with('employee',$emp)
		->with('coverage',$cov)->with('yrholder',$year);
	}

}