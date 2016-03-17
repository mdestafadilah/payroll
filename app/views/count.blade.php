<?php
$reqcount = EmpRequest::where('approve', '=', '0')->count();
if ($reqcount > 0){
	echo $reqcount;
}
?>

