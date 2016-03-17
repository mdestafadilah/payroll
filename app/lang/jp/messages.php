<?php
/**
 * Created by PhpStorm.
 * User: Hydra
 * Date: 2016/01/06
 * Time: 15:18
 */
return array(
    'payroll'=>array(
       'error'=>array(
           'csv_format_only'            =>  'Only CSV format only. Please try again.',
           'request_dates_no_date'      =>  'No attendance for the requested dates',
           'existing_attendance_csv'    =>  'Attendance date :dates already exist',
           'unset_rate'                 =>  'Kindly set employee\'s rate first',
           'existing_attendance'        =>  'Attendance date already exist',
           'no_payroll_avaiilable'      =>  'No Payroll log available',
           'payslip_unavailable'        =>  'Payslip not available',
           'invalid_input_date'         =>  'Invalid input date',
           'no_reports'                 =>  'Empty Reports',
       ),
        'success'=>array(
            'delect_successful'         =>  'Attendance successfully deleted.',
            'csv_successfuly_imported'  =>  'Successfully imported',
            'save_successful'           =>  'Successfully save',
        )

    ),
    'employee'=>array(
        'error'=>array(
            'wrong_img_format'          =>  'Only JPEG, PNG, GIF format allowed. Please try again.',
            'large_img_size'            =>  "Image size too large than 3MB.Please try again",
            'no_stats_found'            =>  'No such records found!. Please create one',
            'inactive_emp_not_found'    =>  'No such Inactive Employee Found',
            'active_emp_not_found'      =>  'No such Active Employee Found',
            'no_approve_req'            =>  'No Approved Requests',
            'no_pending_request'        =>  'No Pending Requests',

        ),
        'success'=> array(
            'successful_registration'   =>  'Employee successfully registered',
            'successful_approve'        =>  'Successfully Approved Request',
            'successful_update_profile' =>  'Profile Successfully Updated',
            'successful_update'         =>  'Successfully updated',
        )
    ),
    'admin'=> array(
        'error'=>array(
            'wrong_img_format'          =>  'Only JPEG, PNG,GIF format allowed. Please try again.',
            'large_img_size'            =>  'Image size too large than 3mb. Please try again.',
            'only_pdf_file'             =>  'Only PDF format allowed. Please try again.',
            'cannot_delete'             =>  'Can no longer delete',
            'incorrect_password'        =>  'Incorrect Password',
        ),
        'success'=>array(
            'successful_upd_empr_share' =>  'Employer Share succssfully updated',
            'successful_registration'   =>  'User account created successfully',
            'successful_pwd_update'     =>  'Password successfully changee',
            'successful_acct_update'    =>  'Account updated successfully',
            'successful_payroll_sent'   =>  'Payroll successfully sent',
            'successful_deletion'       =>  'Deleted successfully',
            'successful_update'         =>  'Successfully Update',
        )
    ),
    'home'=> array(
        'error'=> array(
            'incorrect_uname_pwd'       =>  'Username or Password is incorrect!',
            'duplicate_requisition'     =>  'You already requested this payroll',
            'no_payroll_found'          =>  'No such Payroll Record Found!',
        ),
        'success'=>array(
            'successful_requisition'    =>  'Request successfully submitted'
        )
    ),
);