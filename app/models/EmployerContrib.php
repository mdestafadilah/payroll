<?php
/**
 * Created by PhpStorm.
 * User: RSD01
 * Date: 15/5/14
 * Time: 13:39
 */

class EmployerContrib extends Eloquent {
	protected $table = 'employer_contribution';
	protected $primaryKey = 'contrib_id';

	public function employee(){
		return $this->belongsTo('Employee','emp_id');
	}
}