<?php
/**
 * Created by PhpStorm.
 * User: Hydra
 * Date: 2015/05/25
 * Time: 11:38
 */


class EmpRequest extends Eloquent {
	protected $table = 'payroll_request';
	protected $primaryKey = 'req_id';

	public function employee(){
		return $this->belongsTo('Employee','emp_id');
	}

}