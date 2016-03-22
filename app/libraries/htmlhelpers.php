<?php

Class HTMLHelper{

    public static function calculate($timeIn, $timeOut,$dayType,$day,$aLate){

        if($dayType !=2){
            if(str_replace(':','.', $timeIn) == 0 && str_replace(':','.', $timeOut) == 0){
                return   $data = array('total' => Config::get('constants.HOURS_PER_DAYS'), 'ot' => 0, 'late'=>0);
            }
        }
        if($aLate==1){
            $timeIn='09:00';
        }

        $timein =floatval( str_replace(':','.', $timeIn));
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

        $timeout = floatval(str_replace(':','.',$timeOut));

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
        }
        if($timeout >Config::get('constants.STANDARD_TIME_OUT')){
            if($timeout>Config::get('constants.24HR_VALUE_OF_1')){
                $timeout = $timeout -Config::get('constants.BALANCE_24HR');
            }
            $int = $timeout -(int)$timeout;
            if($int == $timeout){
                $ot = $timeout - Config::get('constants.STANDARD_TIME_OUT');
            }else{
                $mint = number_format($int/Config::get('constants.MINUTE_VALUE'),2,'.','');
                $ot = (int)$timeout-Config::get('constants.STANDARD_TIME_OUT') + $mint;
            }
        }else{
            $ot=0;
        }

        if($timein > 9 || $timein < 5){
            if($timein > 12){
                $timein = $timein - Config::get('constants.BALANCE_24HR');
            }
            $mornMins = $morning - (int)$morning;
            $mornMins = $mornMins/Config::get('constants.MINUTE_VALUE');
            $morning = $mornMins + (int)$morning;
            $mlate = (Config::get('constants.STANDARD_LUNCH_BREAK') - Config::get('constants.STANDARD_TIME_IN'))-$morning;
            if($morning !=0){
                $late = $mlate;
            }else{
                $timeMins = $timein - (int)$timein;
                $timeMins = $timeMins/Config::get('constants.MINUTE_VALUE');
                $timein = $timeMins + (int)$timein;
                $p = (Config::get('constants.STANDARD_TIME_OUT') - $timein);
                $late = Config::get('constants.STANDARD_TIME_OUT')-1 - $p + 3;
            }

        }else{
            $late = 0;
        }


        $flg=self::isWeekend($day);
        if($dayType!=0 || $flg){
            $ot = $total;
            $total =$total;
        }

        $data = array('total' => $total, 'ot' => $ot, 'late'=>$late);
        return $data;

    }

    public static function doMessage() {
        $message = 'Hello';
        return $message;
    }

    /**
     * @param $date
     * @return bool
     */
    public static function isWeekend($date) {
        $weekDay = date('w', strtotime($date));
        if ($weekDay == 0 || $weekDay == 6){

            return true;
        }else{return false;}
    }
    public static  function salary($emp_id,$from,$to){
        $tpay = $tTime= $ot = 0;

        $rate=Rate::find($emp_id);

        $rates = (number_format($rate->salary,2,'.','') + number_format($rate->allowance,2,'.',''))*12 /261;
        $rate= number_format($rates,2,'.','')/Config::get('constants.HOURS_PER_DAY');
        $total=DB::table('employee_attendance')->whereBetween('attendance_date',array($from,$to))
            ->where('emp_id','=',$emp_id)->get();

        if($total==null ){
            return false;
        }
        $salary =0;

        foreach ($total as $totals) {
            if($totals->day_type == Config::get('constants.REGULAR_HOLIDAY') && $totals->time_ot !=0){
                $tpay = $rate * $totals->time_ot;
                $tpay = $tpay * Config::get('constants.REGULAR_HOLIDAY_MULTIPLIER');

            }elseif($totals->day_type == Config::get('constants.SPECIAL_NON-WORKING_HOLIDAY') && $totals->time_ot !=0 ){
                $tpay = $rate * $totals->time_ot;
                $tpay = $tpay * Config::get('constants.SPECIAL_NON-WORKING_HOLIDAY_MULTIPLIER');

            }else{
                $tpay = $rate * $totals->time_total;
            }
            $salary = $salary + $tpay;
        }
        return $salary ;
    }

    public static function  overTime($emp_id,$from,$to){
        $ot=   DB::table('employee_attendance')->whereBetween('attendance_date',array($from,$to))
            ->where('emp_id','=',$emp_id)
            ->get() ;
        $rate=Rate::find($emp_id);
        $rates = (number_format($rate->salary,2,'.','') + number_format($rate->allowance,2,'.',''))*12 /261;
        $ratez= number_format($rates,2,'.','')/Config::get('constants.HOURS_PER_DAY');

        $Otsalary =$tpay = 0;
        foreach ($ot as $totals) {
            if($totals->day_type == Config::get('constants.REGULAR_HOLIDAY')){
                $tpay = $rates * $totals->time_ot;
                $tpay = $tpay * Config::get('constants.REGULAR_HOLIDAY_MULTIPLIER');
            }elseif($totals->day_type == Config::get('constants.SPECIAL_NON-WORKING_HOLIDAY') ){
                $tpay = $rates * $totals->time_ot;
                $tpay = $tpay * Config::get('constants.SPECIAL_NON-WORKING_HOLIDAY');
            }else{
                $tpay = $rates * $totals->time_ot;
            }

            $Otsalary = $Otsalary +$tpay;

        }
        return $Otsalary;
    }

    public static  function late($emp_id,$from,$to){
        $time=   DB::table('employee_attendance')->whereBetween('attendance_date',array($from,$to))
            ->where('emp_id','=',$emp_id)
            ->get() ;
        $rate=Rate::find($emp_id);
        $rates = (number_format($rate->salary,2,'.','') + number_format($rate->allowance,2,'.',''))*12 /261;
        $rate= number_format($rates,2,'.','')/Config::get('constants.HOURS_PER_DAY');

        $lateDed = 0;
        foreach($time as $att){
            if($att->day_type == 0){
                $lateDed = $lateDed + ($rate * $att->time_late);
            }
        }
        return $lateDed;
    }
    public static  function deductions($emp_id){
        $table = Rate::find($emp_id);
        if($table->salary == 0){
            $deduction =0;
        }
        $deduction = $table->sss_tax + $table->pagibig_tax + $table->philhealth_tax;

        return $deduction;
    }

    public static function checkAttendance($emp_id){
        $total=Time::find('emp_id','=',$emp_id)->get();

        if($total->count() < 1){
            return false;
        }else{
            return true ;
        }
    }

    public static function checkDate($from, $to){
        if(Carbon\Carbon::now()< $from || Carbon\Carbon::now() < $to  ) {
            return true;
        }else{
            return false;
        }
    }

    public static function duplicate($emp_id,$coverage){
        $dup = Payroll::where('emp_id','=',$emp_id)
            ->where('coverage','=',$coverage)->first();
        if($dup != null){
            return true;
        }else{
            return false;
        }

    }

    public static function days($emp_id,$from,$to){
        $total=DB::table('employee_attendance')->whereBetween('attendance_date',array($from,$to))
            ->where('emp_id','=',$emp_id)->lists('time_total');
        $days =0;
        foreach ($total as $totals) {
            $days = $days + $totals;
        }
        return $days/Config::get('constants.HOURS_PER_DAY');
    }

    public static function TaxCompute($emp_id,$ot,$deductions){

        $pay = Payroll::where('emp_id',$emp_id)->orderBy('emp_id','desc')->first();
        if( is_null($pay)){
            $overt = 0;
        }else{
            $overt = $pay->ot;

        }
        $e = DB::table('employees')
            ->join('employee_rate','employees.emp_id','=','employee_rate.emp_id')
            ->where('employees.emp_id',$emp_id)
            ->select('*')
            ->first();
        $salary = $e->salary;
        $over = $ot + $overt;
        $basis = DB::table('w_tax')->orderBy
        ('basis','desc')->get();
        $base = $exc = $cemption =0 ;
        $subTotal = number_format($salary,2,'.','') + number_format($over,2,'.','');
        $try = number_format($subTotal,2,'.','') - number_format($deductions,2,'.','');

        foreach($basis as $b){
            if($try >= $b->basis){
                $base =$b->basis;
                $exc = $b->excess;
                $cemption =$b->excemption;
                break;
            }
        }
        $ex = $try - $base;
        $rrr = $ex * $exc;
        $ggg = $rrr + $cemption;
        return $ggg;
    }

    public static function duplicateDate($emp_id,$date){
        $dup = Time::where('emp_id','=',$emp_id)
            ->where('attendance_date','=',$date)->first();
        if($dup != null){
            return true;
        }else{
            return false;
        }

    }


}