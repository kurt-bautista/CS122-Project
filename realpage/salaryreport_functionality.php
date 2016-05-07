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

$fetch_info = <<<SQL
SELECT employees.username "username", employees.employee_type "employee_type",
employee_contracts.hourly_rate "hourly_rate"
FROM employees, employee_contracts WHERE employees.username='$user_login'
AND employee_contracts.employees_id=$_SESSION['employee_id']
SQL;

$fetch_workdays = <<<SQL
SELECT time_in, time_out, overtime_hours
FROM  workdays WHERE employees_id=$_SESSION['employee_id']
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
$employee_id = $_SESSION['employee_id'];
$employee_rate = $row['hourly_rate'];

$all_workdays = array();
$workdays_count = count($all_workdays);

while($row2 = $workdays_result->fetch_assoc()){
  /* sample way to get datetime difference
  $datetime1 = new DateTime('2009-05-18 15:45:57');
  $datetime2 = new DateTime('2009-05-18 13:40:50');

  $interval = $datetime2->diff($datetime1);
  echo $interval->format('%h hours %i minutes %S seconds');
  */
  $date = date('F d, Y', strtotime($row2['time_in']));
  echo $date;

  //array_push($all_workdays, array($row2['start_date'], $row2['end_date'], $row2['leave_type'], $row2['duration']));
}

if(isset($login_session)){
    $db->close();
    //header("location: index.php");
}
?>
