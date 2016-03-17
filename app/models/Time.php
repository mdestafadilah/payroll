<?php
/**
 * Created by PhpStorm.
 * User: RSD01
 * Date: 15/5/14
 * Time: 13:39
 */

class Time extends Eloquent {
	protected $table = 'employee_attendance';
	protected $primaryKey = 'time_id';

	public function employee(){
		return $this->belongsTo('Employee', 'emp_id');
	}
}


