<?php
$error = '';

$server = 'localhost';
$server_user = 'root';
$server_pass = '';
$database_name = 'realpagetest';

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

$fetch_workdays = <<<SQL
SELECT time_in, time_out, overtime_hours
FROM workdays WHERE employees_id = $employee_id
SQL;

//fetch user info
if(!$result = $db->query($fetch_info)){
    die('Error retrieving user information ['. $db->error.']');
}

//fetch workdays info
if(!$workdays_result = $db->query($fetch_workdays)){
    die('Error retrieving user information ['. $db->error.']');
}

$row = $result->fetch_assoc();
$login_session = $row['username'];
$employee_type = $_SESSION['employee_type'];
$employee_rate = $row['hourly_rate'];

$all_workdays = array();
$employee_id = $_SESSION['employee_id'];
$employee_rate = $row['hourly_rate'];

$all_workdays = array();

//while($row2 = $workdays_result->fetch_assoc()){
  $row2 = $workdays_result->fetch_assoc();
  /* sample way to get datetime difference
  $datetime1 = new DateTime('2009-05-18 15:45:57');
  $datetime2 = new DateTime('2009-05-18 13:40:50');

  $interval = $datetime2->diff($datetime1);
  echo $interval->format('%h hours %i minutes %S seconds');
  */
  $date = date('F d, Y', strtotime($row2['time_in']));
  $time_in = date('h:i A', strtotime($row2['time_in']));
  $time_out = date('h:i A', strtotime($row2['time_out']));
  $overtime_hours = $row2['overtime_hours'];
  if($overtime_hours > 0){
    $comment = "Overtime by ".$overtime_hours." hours.";
  } else{
    $comment = "";
  }
  echo $comment;

  array_push($all_workdays, array($date, $time_in, $time_out));
//}

$workdays_count = count($all_workdays);
if(isset($login_session)){
    $db->close();
    //header("location: index.php");
}
?>
