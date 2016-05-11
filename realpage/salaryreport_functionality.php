<?php
$error = '';

$server = 'localhost';
$server_user = 'root';
$server_pass = '';
$database_name = 'company';

$db = new mysqli($server, $server_user, $server_pass, $database_name);

if($db->connect_errno > 0){
    die('Unable to connect to database ['. $db->connect_error.']');
}

session_start();
if(!$user_login = $_SESSION['login_user']){
    header("location: index.php");
}

$employee_id = $_SESSION['employee_id'];

$fetch_info = <<<SQL
SELECT employees.username "username", employees.employee_type "employee_type",
employee_contracts.hourly_rate "hourly_rate"
FROM employees, employee_contracts WHERE employees.username = '$user_login'
AND employee_contracts.employees_id = $employee_id
SQL;

$fetch_workdays_info = <<<SQL
SELECT time_in, time_out,
CASE WHEN HOUR(TIMEDIFF(time_out, time_in)) - 8 > 0 THEN HOUR(TIMEDIFF(time_out, time_in)) - 8
ELSE 0 END "overtime_hours",
CASE WHEN HOUR(TIMEDIFF(time_out, time_in)) > 8 THEN 0
ELSE 8 - HOUR(TIMEDIFF(time_out, time_in)) END "undertime_hours",
HOUR(TIMEDIFF(time_out, time_in)) "num_of_hours"
FROM workdays WHERE YEAR(CURDATE()) = YEAR(time_in) AND MONTH(time_in) = MONTH(NOW()) AND employees_id = $employee_id
SQL;

//fetch user info
if(!$result = $db->query($fetch_info)){
    die('Error retrieving user information ['. $db->error.']');
}

//fetch user info
if(!$workdays_result = $db->query($fetch_workdays_info)){
    die('Error retrieving user information ['. $db->error.']');
}

$row = $result->fetch_assoc();
$login_session = $row['username'];
$employee_type = $_SESSION['employee_type'];
$hourly_rate = $row['hourly_rate'];

$all_workdays = array();
$overtime_hours = 0;
$undertime_hours = 0;
$expected_salary = ($hourly_rate*8)*30;
$total_overtime_pay = 0;
$total_undertime_deduction = 0;

while($row2 = $workdays_result->fetch_assoc()){
  $date = date('F d, Y', strtotime($row2['time_in']));
  /*
  $time_in = date('h:i A', strtotime($row2['time_in']));
  $time_out = date('h:i A', strtotime($row2['time_out']));
  */
  $overtime_hours = $row2['overtime_hours'];
  $undertime_hours = $row2['undertime_hours'];
  $work_hours = $row2['num_of_hours'];
  $comment = "";
  $overtime_pay = ($hourly_rate*0.25) * $overtime_hours;
  $undertime_deduction = ($hourly_rate*0.80) * $undertime_hours;

  if($overtime_hours > 0){
    $comment = "overtime";
    $day_pay = (8*$hourly_rate) + $overtime_pay;
    $expected_salary = $expected_salary + $overtime_pay;
    $total_overtime_pay = $total_overtime_pay + $overtime_pay;

    array_push($all_workdays, array($date, $comment, $overtime_pay));
  } elseif ($undertime_hours > 0) {
    $comment = "undertime";
    $day_pay = (8*$hourly_rate) - $undertime_deduction;
    $expected_salary = $expected_salary - $undertime_deduction;
    $total_undertime_deduction = $total_undertime_deduction + $undertime_deduction;

    array_push($all_workdays, array($date, $comment, $undertime_deduction));
  } else{
    $day_pay = $work_hours*$hourly_rate;
    $expected_salary = $expected_salary + $day_pay;
  }
}

$workdays_count = COUNT($all_workdays);

if(isset($login_session)){
    $db->close();
    //header("location: index.php");
}
?>
