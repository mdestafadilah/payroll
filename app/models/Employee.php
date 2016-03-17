<?php
/**
 * Created by PhpStorm.
 * User: RSD01
 * Date: 15/5/14
 * Time: 13:39
 */

class Employee extends Eloquent {
    protected $table = 'employees';
    protected $primaryKey = 'emp_id';


    public  function owned(){
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo('User');
    }

    public function empRequest(){
        return $this->hasMany('EmpRequest', 'emp_id','emp_id');
    }

    public function rate(){
        return $this->hasMany('Rate', 'emp_id','emp_id');
    }

    public function time(){
        return $this->hasMany('Time' , 'emp_id', 'emp_id');
    }

    public function payroll(){
        return $this->hasMany('Payroll' , 'emp_id', 'emp_id');
    }
    public function empContrib(){
        return $this->hasMany('EmployerContrib' , 'emp_id', 'emp_id');
    }


}


