<?php

class EmployeeController extends \BaseController {

    public function postdisplaySummaryReport()
    {
        $employee = Employee::paginate(10);


        return View::make('employees.allstats')
        ->with('employeequerytoallstat', $employee);

    }


    public function download()
    {
        $searchKeyword = Input::get('SearchPeriod');

        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=Payroll_Exported_Report('.$searchKeyword.').csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

            $searchFrom = substr($searchKeyword, 0, 10);
            $searchTo = substr($searchKeyword, -10);            
        
            DB::setFetchMode(PDO::FETCH_ASSOC);

            $list = DB::table('employees')
            ->select(DB::raw('employees.firstname as First_Name'), DB::raw('employees.lastname as Last_Name'), DB::raw('SUM(employee_attendance.time_ot) as Total_Overtime'), DB::raw('SUM(employee_attendance.time_late) as Total_Late'), DB::raw('SUM(employee_attendance.time_total) as Total_Time')) 
            ->leftJoin('employee_attendance', 'employees.emp_id', '=', 'employee_attendance.emp_id')
            //>where('employee_attendance.attendance_date','LIKE', '%'.$searchKeyword.'%')
            ->where('employee_attendance.attendance_date', '>=', ''.$searchFrom.'')
            ->where('employee_attendance.attendance_date', '<=', ''.$searchTo.'')            
            ->groupBy('employees.emp_id')
            ->get();

            DB::setFetchMode(PDO::FETCH_CLASS);
            

            //$list = (array) $employee;

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

       $callback = function() use ($list) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) { 
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }


    public function showdisplaySummaryReport()
    {
        $rules = array(
            'dateRange'        => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('employees/sumarryReports')
            ->withErrors($validator);
        } else {

/*            $searchFrom = Input::get('fromDate');
            $searchTo = Input::get('toDate');*/
            $searchRange = Input::get('dateRange');
            $searchFrom = substr($searchRange, 0, 10);
            $searchTo = substr($searchRange, -10);

/*            $searchKeyword = $searchFrom .' - '. $searchTo;
            $searchKeywordFrom = $searchFrom;
            $searchKeywordTo = $searchTo;*/

            $employee = DB::table('employees')
            ->select('employees.avatar', 'employees.firstname', 'employees.lastname', DB::raw('SUM(employee_attendance.time_ot) as time_ot'), DB::raw('SUM(employee_attendance.time_late) as time_late'), DB::raw('SUM(employee_attendance.time_total) as time_total')) 
            ->leftJoin('employee_attendance', 'employees.emp_id', '=', 'employee_attendance.emp_id')
            //->where('employee_attendance.attendance_date', '>=', $searchKeywordFrom, 'and', 'employee_attendance.attendance_date', '<=', $searchKeywordTo)
            ->where('employee_attendance.attendance_date', '>=', ''.$searchFrom.'')
            ->where('employee_attendance.attendance_date', '<=', ''.$searchTo.'')
            //Search by "2015-06"
            /*->where('employee_attendance.attendance_date','LIKE', '%'.$searchKeyword.'%')*/
            ->groupBy('employees.emp_id')
            ->get();

           if(count($employee) > 0){
                return View::make('employees.allstats',compact('info'))
                ->with('employeequerytoallstat', $employee)
                ->with('Periodmessage', 'From "'.$searchFrom.'" To "'.$searchTo.'"')
                ->with('Period', $searchRange);
            }
            else{
                Session::flash('errormessage', 'No records found for "'.$searchFrom.'" To "'.$searchTo.'"');
                return Redirect::to('employees/sumarryReports');
            }
        }
    }


    public function showRoot(){
        return View::make('index');
    }


    public function index()
    {
        $employee = Employee::paginate(10);
        return View::make('employees.index')
        ->with('employee', $employee);
    }


    public function showCount()
    {
        $employee = new Employee;
        return View::make('count')
        ->with('employee', $employee);
    }


    public function showRequest(){
        $employee = EmpRequest::where('approve','=', 0)->paginate(10);
        return View::make('employees.request')
        ->with('employee', $employee);
    }


    public function showActive(){
        $employee = Employee::where('del_flag', '0')->paginate(10);
        if ($employee->count() > 0){
            return View::make('employees.index')
            ->with('employee', $employee);
        }
        else{
            Session::flash('errormessage', 'No such Active Employee Found');
            return Redirect::to('employees');
        }
        
    }


    public function showInactive(){
        $employee = Employee::where('del_flag', '1')->paginate(10);
        if ($employee->count() > 0){
            return View::make('employees.index')
            ->with('employee', $employee);
        }
        else{
            Session::flash('errormessage', 'No such Inactive Employee Found');
            return Redirect::to('employees');
        }
    }


    public function showStats($emp_id){
        $employee = Time::where('emp_id','=', $emp_id)->orderBy('attendance_date','desc')->paginate(30);
        //$employee_info = Employee::where('emp_id','=', $emp_id)->get();
        $employee_info = Employee::find($emp_id);
        //print_r(json_encode( $employee_info));
        if($employee->count() > 0){

        Session::put('sess_selected_empid',$emp_id);
        
         return View::make('employees.stats')
         ->with('employee', $employee_info)
         ->with('employees', $employee);
         
        }
        else{
                Session::flash('errormessage', 'No such records found!. Please create one.');
                Session::flash('flg',1);
                return Redirect::to('employees/'.$emp_id.'/stats/create');
        }
    }


    public function showStatsFilter($emp_id){
        $searchTimeKeyword = Input::get('searchKeywordDate');
        $employee = Time::where('attendance_date','LIKE', '%'.$searchTimeKeyword.'%')->where('emp_id',$emp_id)->orderBy('attendance_date','desc')->paginate(10);
        
        if($employee->count() > 0){
            return View::make('employees.stats')
            ->with('employees', $employee);
        }else{
            Session::flash('errormessage', 'No records found!');
            return Redirect::to('employees/'.$emp_id.'/stats');
        }
    }


    public function showDelete($emp_id){
        $employee = Employee::find($emp_id);
        return View::make('employees.delete')
        ->return('employee',$employee);
    }


    public function search()
    {

        $searchKeyword = Input::get('id');
        $results = Employee::where('emp_id',  $searchKeyword)
        ->orWhere('firstname', 'LIKE', '%'.  $searchKeyword .'%')
        ->orWhere('lastname', 'LIKE', '%'.  $searchKeyword .'%')
        ->paginate(10); 

        if($results->count() < 1){
            Session::flash('errormessage', 'No such records found!');
            return Redirect::to('employees');
        }

        return View::make('employees.index')->with('employee',  $results);

    }


    public function create()
    {
        return View::make('employees.create');
    }


    public function store()
    {
        $rules = array(
            'firstname'       => 'required',
            'lastname'        => 'required',
            'gender'          => 'required',
            'birthdate'       => 'required',
            'homeaddress'     => 'required',
            'contactno'       => 'required|numeric',
            'email'           => 'required|email',
            'position'        => 'required',
            'hired_date'      => 'required',
            'sss_no'          => 'required',
            'ph_no'           => 'required',
            'pi_no'           => 'required'
            );
        $validator = Validator::make(Input::all(), $rules);

            // process the login
        if ($validator->fails()) {
            return Redirect::to('/employees/create')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
        } else {
                // store
            $employee = new Employee;
            $rate = new Rate;
            $erC = new EmployerContrib;
            $employee->firstname    = Input::get('firstname');
            $employee->lastname     = Input::get('lastname');
            $employee->gender       = Input::get('gender');
            $employee->birthdate    = Input::get('birthdate');
            $employee->homeaddress  = Input::get('homeaddress');
            $employee->contactno    = Input::get('contactno');
            $employee->email        = Input::get('email');
            $employee->position     = Input::get('position');
            $employee->hired_date   = Input::get('hired_date');
            $employee->sss_no       = Input::get('sss_no');
            $employee->ph_no        = Input::get('ph_no');
            $employee->pi_no        = Input::get('pi_no');
            $employee->user_id      = Auth::user()->user_id;
            $employee->save();
                //insert values to rate
            $rate->emp_id           =   DB::table('employees')->max('emp_id');
            $rate->user_id          =   Auth::user()->user_id;
            $rate->save();
            $erC->emp_id            =   DB::table('employees')->max('emp_id');
            $erC->user_id           =   Auth::user()->user_id;
            $erC->save();
                // redirect
            Session::flash('message', 'Employee successfully registered!');
            return Redirect::to('employees');
        }
    }


    public function show($emp_id)
    {
        $employee = Employee::find($emp_id);

        return View::make('employees.show')
        ->with('employee', $employee);
    }


    public function edit($emp_id)
    {
        $employee = Employee::find($emp_id);

        return View::make('employees.edit')
        ->with('employee', $employee);
    }


    public function update($emp_id)
    {
        $rules = array(
            'firstname'       => 'required',
            'lastname'        => 'required',
            'gender'          => 'required',
            'birthdate'       => 'required|date',
            'homeaddress'     => 'required',
            'contactno'       => 'required|numeric',
            'email'           => 'required|email',
            'position'        => 'required',
            'hired_date'      => 'required|date',
            'sss_no'          => 'required',
            'ph_no'           => 'required',
            'pi_no'           => 'required',
            );
        $validator = Validator::make(Input::all(), $rules);

            // process the login
        if ($validator->fails()) {
            return Redirect::to('employees/'. $emp_id . '/edit')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
        } else {
                // store
           
            $employee = Employee::find($emp_id);
            $employee->firstname    = Input::get('firstname');
            $employee->lastname     = Input::get('lastname');
            $employee->gender       = Input::get('gender');
            $employee->birthdate    = Input::get('birthdate');
            $employee->homeaddress  = Input::get('homeaddress');
            $employee->contactno    = Input::get('contactno');
            $employee->email        = Input::get('email');
            $employee->position     = Input::get('position');
            $employee->hired_date   = Input::get('hired_date');
            $employee->sss_no       = Input::get('sss_no');
            $employee->ph_no        = Input::get('ph_no');
            $employee->pi_no        = Input::get('pi_no');
            $employee->user_id      = Auth::user()->user_id;

            $employee->save();
                // redirect
            Session::flash('message', 'Profile Successfully Updated!');
            return Redirect::to('employees/'. $emp_id);
        }
    }


    public function doDelete($emp_id){
        $employee = Employee::find($emp_id);
        $employee->del_flag = '1';
        $employee->save();
        if($employee->avatar == null){
           Session::flash('message', '<img src="/payroll/uploads/avatar.png" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$employee->firstname.' '.$employee->lastname.' '.'</b>'.'Deleted Successfully!'); 
        }else{
            Session::flash('message', '<img src="/payroll/uploads/'.$employee->avatar.'" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$employee->firstname.' '.$employee->lastname.' '.'</b>'.'Deleted Successfully!');
        }
        return Redirect::to('employees');

    }


    public function doActivate($emp_id){
        $employee = Employee::find($emp_id);
        $employee->del_flag = '0';
        $employee->save();
        if($employee->avatar == null){
            Session::flash('message', '<img src="/payroll/uploads/avatar.png" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$employee->firstname.' '.$employee->lastname.' '.'</b>'.'Activated Successfully!');        
        }else{
            Session::flash('message', '<img src="/payroll/uploads/'.$employee->avatar.'" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$employee->firstname.' '.$employee->lastname.' '.'</b>'.'Activated Successfully!'); 
        }
        return Redirect::to('employees');
    }


    public function doApprove($req_id){
       $request = EmpRequest::find($req_id);
       $request->approve = '1';
       $request->user_id = Auth::user()->user_id;
       $request->save();
       Session::flash('message', 'Successfully Approved Request!');
       return Redirect::to('admin/mail/' . $request->emp_id);

    }


    public function showPending(){
        $request = EmpRequest::where('approve', '0')->paginate(5);
        if($request->count() < 1){
            Session::flash('errormessage', 'No Pending Requests');
            return Redirect::to('employees/request');
        }
        return View::make('employees.request')
        ->with('employee', $request);
    }


    public function showApproved(){
        $request = EmpRequest::where('approve', '1')->take(50)->orderBy('created_at','desc')->get();
        if($request->count() < 1){
            Session::flash('errormessage','No Approved Requests');
            return Redirect::to('employees/request');
        }else{
            return View::make('employees.request')
            ->with('employee', $request);
        }

    }


    public function getRate($emp_id){
        $employee = Rate::find($emp_id);
        return View::make('employees.contribution')
        ->with('employee',$employee);
    }


    public function postRate($emp_id){
        $rules = array(
            'sss'           => 'required',
            'philhealth'    => 'required',
            'pagibig'       => 'required',
            'salary'        => 'required',
            );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/employees/'. $emp_id.'/contribution/')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
        } else {
            $employee                    = Rate::find($emp_id);

            $salary = Input::get('salary');
            $allowance = Input::get('allowance');

            $total_salary = $salary + $allowance;

            $employee->sss_tax           = Input::get('sss');
            $employee->philhealth_tax    = Input::get('philhealth');
            $employee->pagibig_tax       = Input::get('pagibig');
            $employee->salary            = $salary;
            $employee->allowance         = $allowance;
            $employee->rate              = $total_salary * 12 / 261;
            $employee->user_id           = Auth::user()->user_id;

            $employee->save();

            return Redirect::back()->with('message','Successfully Updated!');
        }
    }


    public function postUpload($emp_id){
        $employee                   = Employee::find($emp_id);
        $file                       = Input::file('employee_avatar');
        $bytes                      = File::size($file);
        $rules = array(
            'employee_avatar' => 'required'
            );
        $v = Validator::make(Input::all(),$rules);
        if($v->fails()){
            return Redirect::to('employees/'.$emp_id)->withErrors($v);
        }else{
            $file_ex = $file->getClientOriginalExtension();
            if (!in_array($file_ex, array('jpg', 'gif', 'png'))){
                Session::flash('errormessage', 'Only JPEG, PNG, GIF format allowed. Please try again.');
                return Redirect::back();
            }elseif(round($bytes/1024) > 3072){
                Session::flash('errormessage', 'Image size too large than <b>3MB</b>. Please try again.');
                return Redirect::back();
            }else{

                File::delete(base_path().'/uploads/'.$employee->avatar);
                $file_name = str_random(10).'.'.$file->getClientOriginalExtension();
                $file->move(base_path().'/uploads', $file_name);
                $employee->avatar           = $file_name;
                $employee->user_id          = Auth::user()->user_id;

                $employee->save();
                Session::flash('message', 'Successfully Updated!');
                return Redirect::back();
            }
            
        }
    }



}