<?php
//session_start();
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
SELECT employees.first_name "first_name", employees.remaining_leaves "remaining_leaves",
employee_contracts.allotted_leaves "allotted_leaves",
employee_contracts.expected_time_in "expected_time_in",
employee_contracts.hourly_rate "hourly_rate"
FROM employees, employee_contracts
WHERE employees.username='$user_login' AND employee_contracts.employees_id= '$employee_id'
SQL;

$fetch_salary_info = <<<SQL
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

//fetch salary info
if(!$salary_result = $db->query($fetch_salary_info)){
    die('Error retrieving user information ['. $db->error.']');
}

$row = $result->fetch_assoc();
$first_name = $row['first_name'];
$remaining_leaves = $row['remaining_leaves'];
$allotted_leaves = $row['allotted_leaves'];
$expected_time_in = $row['expected_time_in'];
$hourly_rate = $row['hourly_rate'];

$overtime_hours = 0;
$undertime_hours = 0;
$expected_salary = 0;
$total_overtime_pay = 0;
$total_undertime_deduction = 0;

while($row2 = $salary_result->fetch_assoc()){
  $overtime_hours = $row2['overtime_hours'];
  $undertime_hours = $row2['undertime_hours'];
  $work_hours = $row2['num_of_hours'];
  $overtime_pay = ($hourly_rate*0.25) * $overtime_hours;
  $undertime_deduction = ($hourly_rate*0.80) * $undertime_hours;
  if($overtime_hours > 0){
    $day_pay = (8*$hourly_rate) + $overtime_pay;
    $expected_salary = $expected_salary + $day_pay;
    $total_overtime_pay = $total_overtime_pay + $overtime_pay;
  } elseif ($undertime_hours > 0) {
    $day_pay = (8*$hourly_rate) - $undertime_deduction;
    $expected_salary = $expected_salary + $day_pay;
    $total_undertime_deduction = $total_undertime_deduction + $undertime_deduction;
  } else{
    $day_pay = $work_hours*$hourly_rate;
    $expected_salary = $expected_salary + $day_pay;
  }
}

if(isset($login_session)){
    $db->close();
}
?>
