<?php

Route::group(array('before' => 'auth'), function(){

	Route::get('employees/sumarryReports','EmployeeController@postdisplaySummaryReport');
	Route::post('employees/sumarryReports/filter','EmployeeController@showdisplaySummaryReport');

	Route::post('employees/sumarryReports/filter/export-report-csv','EmployeeController@download');

	Route::get('count','EmployeeController@showCount');
	Route::get('employees/active','EmployeeController@showActive');
	Route::get('employees/inactive','EmployeeController@showInactive');

	Route::get('employees/{id}/stats/','EmployeeController@showStats');

	Route::get('employees/request','EmployeeController@showRequest');
	Route::get('employees/request/pending','EmployeeController@showPending');
	Route::get('employees/request/approved','EmployeeController@showApproved');
	Route::post('employees/request/{id}/approve','EmployeeController@doApprove');

	Route::post('employees/search','EmployeeController@search');

	Route::post('employees/{id}/delete','EmployeeController@doDelete');
	Route::post('employees/{id}/activate','EmployeeController@doActivate');

	Route::get('employees/{id}/contribution','EmployeeController@getRate');
	Route::post('employees/{id}/contribution','EmployeeController@postRate');

	Route::get('employees/{id}/stats/create','PayrollController@getAttend');
	Route::post('employees/{id}/stats/create','PayrollController@postAttend');

	Route::get('employees/{id}/stats/creates','PayrollController@getAttendC');
	Route::post('employees/{id}/stats/creates','PayrollController@postAttendC');

	Route::get('employees/{id}/stats/edit','PayrollController@getEditAttend');
	Route::post('employees/{id}/stats/edit','PayrollController@postEditAttend');

	Route::get('employees/{id}/stats/delete','PayrollController@doDeleteAttend');

	Route::post('/upload-employee/{id}','EmployeeController@postUpload');
	Route::post('/upload-admin/{id}','AdminController@postUpload');
	Route::get('employees/{id}/payroll/','PayrollController@getPayroll');

	Route::get('employees/{id}/payslip','PayrollController@getPayslip');
	Route::post('employees/{id}/payslip','PayrollController@postPayslip');

	Route::get('employees/{id}/payslip/edit','PayrollController@getRPayslip');
	Route::post('employees/{id}/payslip/edit','PayrollController@postRPayslip');

	Route::get('employees/payslip/{id}','PayrollController@showPayslip');

	Route::get('employees/payslip/{id}/save','PayrollController@getSave');

	Route::get('employees/reports/filter','PayrollController@getFilter');
	Route::post('employees/reports/filter', 'PayrollController@payrollhandler');

	Route::get('employees/reports','PayrollController@getReport');

	Route::post('employees/reports','PayrollController@postReport');

	Route::get('employees/{id}/erc/','AdminController@getERContrib');
	Route::post('employees/{id}/erc/','AdminController@postERContrib');

	Route::get('employees/tax','AdminController@getTax');

	Route::get('employees/tax/create','AdminController@getTaxCreate');
	Route::post('employees/tax/create' ,'AdminController@postTaxCreate');

	Route::get('employees/tax/update/{id}','AdminController@getTaxUpdate');
	Route::post('employees/tax/update/{id}' ,'AdminController@postTaxUpdate');
	Route::get('admin/mail/{id}','AdminController@getEMail');
	Route::post('admin/mail/{id}' ,'AdminController@postEmail');
	Route::get('employees/{id}/bonus','PayrollController@Bonus');
	Route::get('employees/{id}/bonus/edit','PayrollController@rBonus');

	Route::get('employees/reports/batch_print','PayrollController@getBatchPrint');
	Route::post('employees/reports/batch_print','PayrollController@postBatchPrint');

	Route::post('employees/{id}/stats/filter','EmployeeController@showStatsFilter');
	Route::resource('employees', 'EmployeeController');	


	/*		*/
});

Route::group(array('before' => 'guest'), function(){

	Route::get('/','HomeController@doLogin');
	Route::get('login','HomeController@showLogin');
	Route::post('login', 'HomeController@doLogin');

	Route::get('request','HomeController@getEmpRequest');
	Route::post('payroll-records','HomeController@postPayrollRecord');
	Route::post('payroll-records/request','HomeController@postPayrollRecordRequest');
});



Route::group(array('before' => 'auth|admin'	), function() {

	Route::get('/admin','AdminController@index');

	Route::get('admin/register','AdminController@getCreate');
	Route::post('admin/register','AdminController@postCreate');

	Route::get('admin/validate','AdminController@getValidateUser');
	Route::post('admin/validate','AdminController@postValidateUser');

	Route::get('admin/profile/{id}','AdminController@getProfile');

	Route::get('admin/update/{id}','AdminController@getUpdate');
	Route::post('admin/update/{id}','AdminController@postUpdate');

	Route::post('admin/{id}/delete','AdminController@doDelete');
	Route::post('admin/{id}/activate','AdminController@doActivate');

	Route::post('admin/search','AdminController@search');

	Route::get('admin/payslip', 'AdminController@getPayslip');
	Route::post('payslip', 'AdminController@postPayslip');


});
Route::get('specialsss', 'AdminController@getSampless');
Route::get('mail','AdminController@getEMail');
Route::post('mail' ,'AdminController@postEmail');
Route::group(array('before' => 'hr'	), function() {
	Route::get('hr/profile/{id}','HRController@getProfile');

	Route::get('hr/validate','HRController@getValidateUser');
	Route::post('hr/validate','HRController@postValidateUser');

	Route::get('hr/change-pass','HRController@getChangePass');
	Route::post('hr/change-pass','HRController@postChangePass');
});

Route::group(array('before' => 'adminpass'),function(){
	Route::get('admin/change-pass','AdminController@getChangePass');
	Route::post('admin/change-pass','AdminController@postChangePass');

});

Route::group(array('before' => 'hrpass'),function(){
	Route::get('hr/change-pass','HRController@getChangePass');
	Route::post('hr/change-pass','HRController@postChangePass');

});

// Route::get('/logout' ,'HomeController@doLogout');

Route::get('/logout', function()
{
	Auth::logout();
	Session::flush();
	Cookie::queue(Cookie::forget('PHPSESSID'));
	Cookie::queue(Cookie::forget('userid'));
	Cookie::queue(Cookie::forget('laravel_session'));
	Cookie::queue(Cookie::forget('ci_session'));
	Cookie::queue(Cookie::forget('csrf_cookie'));
	return Redirect::to("http://". $_SERVER['HTTP_HOST']);
});

/*
App::error(function($exception, $code)
{	$pathInfo = Request::getPathInfo();
$message = $exception->getMessage() ?: 'Exception';
Log::error("$code - $message @ $pathInfo\r\n$exception");
switch ($code)
{
case 403:
return Response::view('errors.403', array(), 403);

case 404:
return Response::view('error/404', array(), 404);

case 500:
return Response::view('error/500', array(), 500);

default:
return Response::view('errors.default', array(), $code);
}
});*/

