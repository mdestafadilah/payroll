<?php

class AdminController extends \BaseController
{

    public function index()
    {
        $user = User::paginate(5);
        return View::make('admin.users')
        ->with('user', $user);
    }


    public function search()
    {
        $searchKeyword = Input::get('id');
        $results = User::where('user_id',  $searchKeyword)
        ->orWhere('fullname', 'LIKE', '%'.  $searchKeyword .'%')
        ->paginate(10);  

        if($results->count() < 1){
            Session::flash('errormessage', 'No such records found!');
            return Redirect::to('admin');
        }

        return View::make('admin.users')->with('user',  $results);

    }


    public function getCreate()
    {
        return View::make('admin.register');
    }


    public function postCreate()
    {   
        $getMaxId = User::select('m_user')->max('user_id') + 1;
        $maxId = str_pad($getMaxId, 6, '0', STR_PAD_LEFT);

        $rules = array(
            'username' => 'required|min:4|unique:users',
            'password' => 'required|min:4',
            'fullname' => 'required',
            'position' => 'required',
            'privilege' => 'required',
            );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('admin/register')->withErrors($validator);
        } else {
            $user = new User;
            $user->user_id = $maxId;
            $user->username = Input::get('username');
            $user->password = Hash::make(Input::get('password'));
            $user->user_fullnm = Input::get('fullname');
            $user->position = Input::get('position');
            $user->usr_role = Input::get('privilege');
            $user->langu='en';
            $user->save();
            Session::flash('message', 'User account created successfully ');
            return Redirect::to('admin');
        }
    }


    public function getUpdate($user_id)
    {
        $user = User::find($user_id);
        $condition = User::where('usr_role', '1')->get()->count();
        return View::make('admin.update')
            ->with('user', $user)
            ->with('condition',$condition);
    }


    public function postUpdate($user_id)
    {
        $rules = array(
            'username' => 'required',
            'fullname' => 'required',
            'position' => 'required',
            'privilege' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            print("1");
            return Redirect::to('/admin/update/'.$user_id)->withErrors($validator);
        } else {
            $user = User::find($user_id);

                $user->username = Input::get('username');
                $user->user_fullnm = Input::get('fullname');
                $user->position = Input::get('position');
                $user->usr_role = Input::get('privilege');
                $user->langu = Input::get('language');
                $user->save();
              App::setLocale(Input::get('language'));


            $logid = Auth::id();
   
            if($logid == $user_id){
                Session::put('my.locale',Input::get('language'));
           }
            
                Session::flash('message','Account updated successfully');
                return Redirect::to('/admin/profile/'.$user_id);

        }
    }


    public function getValidateUser()
    {
        return View::make('admin.validate');
    }


    public function postValidateUser()
    {
        $input = Input::all();
        $rules = array(
            'oldPassword' => 'required',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|'
            );
        $credentials = array(
            'username' => Auth::user()->username,
            'password' => $input['oldPassword']);
        $validate = Validator::make($input, $rules);

        if ($validate->fails()) {
            return Redirect::to('admin/validate')->withErrors($validate);
        } else {
            if (Auth::attempt($credentials)) {
                $user = User::find(Auth::user()->user_id);
                $user->password = Hash::make(Input::get('password'));
                $user->save();
                Session::flash('message', 'Password successfully changed!');
                return Redirect::to('admin/validate');
            } else {
                Session::flash('errormessage', 'Incorrect password!');
                return Redirect::to('admin/validate');
            }
        }
    }


    public function getProfile($user_id)
    {
        $user = User::find($user_id);
        return View::make('admin.profile')->with('user', $user);
    }


    public function doDelete($user)
    {
        $user = User::find($user);
        $condition = User::where('del_flg', '0')->get()->count();
        $condition2 = User::where('usr_role', '1')
        ->where('del_flg', '0')
        ->get()->count();
        if ($condition > 1) {
            if ($user->usr_role != 1) {
                $user->del_flg = '1';
                $user->save();
                 if($user->avatar == null){
                    Session::flash('message', '<img src="/payroll/uploads/avatar.png" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$user->user_fullnm.' '.'</b>'.'Deleted Successfully!'); 
                 }
                 else {
                    Session::flash('message', '<img src="/payroll/uploads/'.$user->avatar.'" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$user->user_fullnm.' '.'</b>'.'Deleted Successfully!');
                 }

                return Redirect::to('/admin');
            } else {
                if ($condition2 > 1) {
                    if ($user->user_id == Auth::user()->user_id) {
                        $user->del_flg = '1';
                        $user->save();
                        if($user->avatar == null){
                            Session::flash('message', '<img src="/payroll/uploads/avatar.png" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$user->user_fullnm.' '.'</b>'.'Deleted Successfully!'); 
                        }
                        else {
                            Session::flash('message', '<img src="/payroll/uploads/'.$user->avatar.'" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$user->user_fullnm.' '.'</b>'.'Deleted Successfully!');
                        }
                        return Redirect::to('/logout');
                    } else {
                        $user->del_flg = '1';
                        $user->save();
                        if($user->avatar == null){
                            Session::flash('message', '<img src="/payroll/uploads/avatar.png" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$user->user_fullnm.' '.'</b>'.'Deleted Successfully!'); 
                        }
                        else {
                            Session::flash('message', '<img src="/payroll/uploads/'.$user->avatar.'" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$user->user_fullnm.' '.'</b>'.'Deleted Successfully!');
                        }
                        return Redirect::back();
                    }
                } else {
                    Session::flash('errormessage', 'Can no longer delete!');
                    return Redirect::back();
                }
            }
        } else {
            Session::flash('errormessage', 'Can no longer delete!');
            return Redirect::to('admin/');
        }
    }


    public function doActivate($user)
    {
        $user = User::find($user);
        $user->del_flg = '0';
        $user->save();

        if($user->avatar == null){
            Session::flash('message', '<img src="/payroll/uploads/avatar.png" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$user->fullname.' '.'</b>'.'Activated Successfully!'); 
        }
        else {
            Session::flash('message', '<img src="/payroll/uploads/'.$user->avatar.'" width="45px" height="45px" class="img-circle" "/>'.'&nbsp;&nbsp;&nbsp;'.'<b>'.$user->fullname.' '.'</b>'.'Activated Successfully!');
        }
        return Redirect::to('/admin');
    }


    public function postUpload($user_id)
    {
        $user       = User::find($user_id);
        $file       = Input::file('admin_avatar');
        $bytes      = File::size($file);

        $rules = array(
            'admin_avatar' => 'required'
            );
        $v = Validator::make(Input::all(),$rules);
        if($v->fails()){
            return Redirect::to('/admin/profile/'.$user_id)->withErrors($v);
        }
        else{
            $file_ex = $file->getClientOriginalExtension();
            if (!in_array($file_ex, array('jpg', 'gif', 'png'))){
                Session::flash('errormessage', 'Only JPEG, PNG, GIF format allowed. Please try again.');
                return Redirect::back();
            }elseif(round($bytes/1024) > 3072){
                Session::flash('errormessage', 'Image size too large than <b>3MB</b>. Please try again.');
                return Redirect::back();
            }else{
                File::delete(base_path().'/uploads/'.$user->avatar);
                $file_name = str_random(10).'.'.$file_ex;
                $file->move(base_path().'/uploads', $file_name);
                $user->avatar = $file_name;
                $user->save();
                Session::flash('message', 'Successfully Updated!');
                return Redirect::back();
            }

        }
        
        
    }


    public function getEMail($req_id)
    {
        $req = EmpRequest::with('employee')->where('req_id',$req_id)->first();
        return View::make('admin.email')->with('req',$req);
    }


    public function postEmail($req_id)
    {
        $data = Input::all();
        $rules = array(
            'email' => 'required|email',
            'subject' => 'required',
            'msg' => 'required',
            'payroll_file' => 'required'
            );

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return Redirect::to('admin/mail/'.$req_id)->withErrors($validate);
        } else {

            if($data['payroll_file']->getClientMimeType() != 'application/pdf'){
                Session::flash('errormessage', 'Only PDF format allowed. Please try again.');
                return Redirect::back();
            }

            if ($data['payroll_file'] != '') {
                $file = $data['payroll_file'];
                $file->move(base_path().'/attachments/', $file->getClientOriginalName());
                $pathToFile = base_path().'/attachments/' . $file->getClientOriginalName();
            }

            Mail::send('emails.sent', $data, function ($message) use ($data, $pathToFile) {
                $message->to($data['email'])->subject($data['subject']);
                $message->from('ricz.ph@gmail.com', Auth::user()->username);
                $message->attach($pathToFile);
            });

            $req = EmpRequest::find($req_id);
            $req->approve = 1;
            $req->save();
            $success = File::cleanDirectory(base_path().'/attachments/');
            Session::flash('message', 'Payroll successfully sent');
            return Redirect::to('employees/request');
        }

    }


    public function getTax(){
        $tax = Tax::all();
        return View::make('admin.tax')->with('taxes', $tax);

    }


    public function getTaxCreate(){
        return View::make('admin.w_tax');

    }


    public function postTaxCreate(){

        $rules=array(
            'status' => 'required',
            'basis'  => 'required',
            'excess' => 'required',
            'excemption' => 'required'
            );

        $v = Validator::make(Input::all(), $rules);

        if($v->fails()){
            return Redirect::to('employees/tax/create')->withErrors($v);
        }else{
            $tax = new Tax;
            $tax->status = Input::get('status');
            $tax->basis = Input::get('basis');
            $tax->excess = Input::get('excess');
            $tax->excemption = Input::get('excemption');
            $tax->save();
            return Redirect::to('employees/tax');
        }
    }


    public function getTaxUpdate($tax_id){
        $tax = Tax::find($tax_id);
        return View::make('admin.taxUpd')->with('tax',$tax);
    }


    public function postTaxUpdate($tax_id){
        $rules = array(
            'status' => 'required',
            'basis' => 'required',
            'excess' => 'required',
            'excemption' => 'required'
            );

        $v = Validator::make(Input::all(),$rules);

        if($v->fails()){
            return Redirect::to('employees/tax/update/' . $tax_id)->withErrors($v);
        }else{
            $tax = Tax::find($tax_id);
            $tax->status = Input::get('status');
            $tax->basis = Input::get('basis');
            $tax->excess = Input::get('excess');
            $tax->excemption = Input::get('excemption');
            $tax->save();

            return Redirect::to('employees/tax')->with('message','Tax Basis was successfully updated');
        }
    }


    public function getERContrib($emp_id){
        $contrib = EmployerContrib::find($emp_id);
        return View::make('admin.erContrib')->with('employee',$contrib);

    }


    public  function postERContrib($emp_id){
        $rule=array(
            'sss' => 'required|numeric',
            'philhealth' => 'required|numeric',
            'pagibig' => 'required|numeric'
            );

        $v = Validator::make(Input::all(),$rule);

        if($v->fails()){
           return Redirect::to('/employees/'. $emp_id.'/erc/')
           ->withErrors($v);
       }
       $contrib = EmployerContrib::find($emp_id);
       $contrib->sssERC = Input::get('sss');
       $contrib->philHealthERC = Input::get('philhealth');
       $contrib->pagibigERC = Input::get('pagibig');
       $contrib->user_id = Auth::user()->user_id;
       $contrib->save();

       return Redirect::back()->with('message','Employer Share successfully updated');
   }


   public function getSampless(){
       $in = '09:00';
       $out = '08:00';
       $timein =floatval( str_replace(':','.', $in));
       $timeout = floatval(str_replace(':','.',$out));
       if($timein > Config::get('constants.STANDARD_TIME_IN') ){
           $Imin =$timein - (int)$timein ;
           if($Imin == .00){
               $morning = Config::get('constants.STANDARD_LUNCH_BREAK') - (int)$timein ;
           }else{
               $Ihr = Config::get('constants.STANDARD_LUNCH_BREAK') - (int)$timein -1;
               $Imin = Config::get('constants.MINUTE_VALUE') - $Imin ;
               $morning = $Ihr + $Imin;
           }
       }elseif($timein<8 || $timein > Config::get('constants.STANDARD_LUNCH_BREAK')){
           $morning=0;
       }else{
           $morning =Config::get('constants.STANDARD_LUNCH_BREAK') - Config::get('constants.STANDARD_TIME_IN');
       } $timeut=0;

       if($morning == 0){
           if($timein < 13){
               $timeut = $timein + Config::get('constants.BALANCE_24HR')-Config::get('constants.24HR_VALUE_OF_1');
           }else{
               $timeut=$timein-Config::get('constants.24HR_VALUE_OF_1');
           }

           $mins = $timeut - (int)$timeut;
           $timeut = (int)$timeut + $mins/Config::get('constants.MINUTE_VALUE');

           if($timeout <Config::get('constants.24HR_VALUE_OF_1')){
               $timeouts = $timeout +Config::get('constants.BALANCE_24HR') -Config::get('constants.24HR_VALUE_OF_1');

           }else{
               $timeouts = $timeout-Config::get('constants.24HR_VALUE_OF_1');
           }
           $afternoon = $timeouts - $timeut;
       }elseif($timeout<Config::get('constants.24HR_VALUE_OF_1')){
           $afternoon = $timeout +Config::get('constants.BALANCE_24HR') -Config::get('constants.24HR_VALUE_OF_1');
       }else {
           $afternoon = $timeout - Config::get('constants.24HR_VALUE_OF_1');
       }

       $total = $morning + $afternoon;
       if($total != (int)$total && $morning != 0){

           $fpart = $total-(int)$total;
           $min =  number_format($fpart/Config::get('constants.MINUTE_VALUE'),2,'.','');
           $total = $min + (int)$total;

       }elseif($morning == 0){
           $total = $afternoon;
       }$late = 0;

       if($timein > 9.15 || $timein < 5){
           if($timein > 12){
               $timein = $timein - Config::get('constants.BALANCE_24HR');
           }  $mlate = (Config::get('constants.STANDARD_LUNCH_BREAK') - Config::get('constants.STANDARD_TIME_IN'))-$morning;
           if($morning !=0){
               $late = $mlate;
           }else{
               $mornMins = $timein - (int)$timein;
               $mornMins = $mornMins/Config::get('constants.MINUTE_VALUE');
               $morning = $mornMins + (int)$timein;
                $late = $timeout - $ot;
           }

       }
       return $total;
    }
    
}