<?php

class HRController extends BaseController{

    public function getProfile($user_id){
        $user = User::find($user_id);
        return View::make('hr.profile')->with('user',$user);
    }


    public  function getChangePass(){
        return View::make('hr.change-pass');
    }


    public function postChangePass(){
        $rules=array(
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|'
            );
        $validate=Validator::make(Input::all(),$rules);

        if($validate->fails()){
            return Redirect::to('hr/change-pass')->withErrors($validate);
        }
        else{
            $user = User::find(Auth::user()->user_id);
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            Session::flash('message','Password successfully changed!');
            return Redirect::to('hr/change-pass');
        }
    }


    public  function getValidateUser(){
        return View::make('hr.validate');
    }
    

    public function postValidateUser(){
        $input = Input::all();
        $rules = array(
            'oldPassword' => 'required',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|'
            );
        $credentials = array(
            'username' => Auth::user()->username,
            'password' => $input['oldPassword']);
        $validate = Validator::make($input,$rules);

        if($validate->fails()) {
            //  Session::flash('message', 'Failed to submit request');
            return Redirect::to('hr/validate')->withErrors($validate);
        }else {
            if (Auth::attempt($credentials)) {
                $user = User::find(Auth::user()->user_id);
                $user->password = Hash::make(Input::get('password'));
                $user->save();
                Session::flash('message','Password successfully changed!');
                return Redirect::to('hr/validate');
            } else {
                Session::flash('errormessage', 'Incorrect password!');
                return Redirect::to('hr/validate');
            }
        }
    }
}