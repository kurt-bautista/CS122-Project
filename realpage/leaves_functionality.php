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

$fetch_info = <<<SQL
SELECT username, remaining_leaves, employee_type
FROM employees WHERE username='$user_login'
SQL;

$employee_id = $_SESSION['employee_id'];

$fetch_leaves = <<<SQL
SELECT (SELECT COUNT(*) FROM leaves WHERE status = 'APPROVED') "leaves_taken",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=4 AND status = 'APPROVED') "maternity_leaves",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=1 AND status = 'APPROVED') "sick_leaves",
leaves.start_date "start_date", leaves.end_date "end_date", leave_types.name "leave_type",
leaves.num_of_days "duration"
FROM leaves, leave_types
WHERE leaves.employees_id = $employee_id AND leaves.leave_types_id = leave_types.id AND leaves.status = 'APPROVED'
SQL;

$fetch_leave_requests = <<<SQL
SELECT start_date, end_date, num_of_days, (SELECT COUNT(*) FROM leaves) "num_of_requests"
FROM leaves WHERE employees_id = $employee_id AND status = 'PENDING'
SQL;

//fetch user info
if(!$result = $db->query($fetch_info)){
    die('Error retrieving user information ['. $db->error.']');
}

//fetch leaves info
if(!$leaves_result = $db->query($fetch_leaves)){
    die('Error retrieving user information ['. $db->error.']');
}

//fetch leave requests info
if(!$leave_requests_result = $db->query($fetch_leave_requests)){
    die('Error retrieving user information ['. $db->error.']');
}

$row = $result->fetch_assoc();
$login_session = $row['username'];
$remaining_leaves = $row['remaining_leaves'];
$employee_type = $_SESSION['employee_type'];

$all_leaves = array();
$date_today = getdate();

while($row2 = $leaves_result->fetch_assoc()){
  $leaves_taken = $row2['leaves_taken'];
  $maternity_leaves = $row2['maternity_leaves'];
  $sick_leaves = $row2['sick_leaves'];

  $date_of_leave = DateTime::createFromFormat("Y-m-d", $row2['start_date']);
  $date_month = $date_of_leave->format("m");
  $date_day = $date_of_leave->format("d");

  if($date_today['mon'] >= $date_month && $date_today['mday'] >= $date_day){
    array_push($all_leaves, array($row2['start_date'], $row2['end_date'], $row2['leave_type'], $row2['duration']));
  } else{
    $approved_leave_start_date = date('F d, Y', strtotime($row2['start_date']));
    $approved_leave_end_date = date('F d, Y', strtotime($row2['end_date']));
    $approved_leave_duration = $row2['duration'];

  }
}
$leaves_count = count($all_leaves);

$row3 = $leave_requests_result->fetch_assoc();
$num_of_requests = $row3['num_of_requests'];
$start_date = $row3['start_date'];
$end_date = $row3['end_date'];
$number_of_days = $row3['num_of_days'];

if($num_of_requests < 1){
  $has_pending_leave = false;
} else{
  $has_pending_leave = true;
}

if(isset($_POST['submit'])){
    if(empty($_POST['date_picker'])){
        $error = 'Please fill in the request form';
    }
    else{
        if(!$has_pending_leave){
          $date_request = $_POST['date_picker'];
          $leave_reason = $_POST['leave_reason_text'];
          $num_of_days = 1;

          $write_data = <<<SQL
          INSERT INTO leaves(status, employees_id, leave_types_id, start_date, num_of_days)
          VALUES ('PENDING', '$employee_id', 1, '$date_request', '$num_of_days')
SQL;

          if(!$write = $db->query($write_data)){
              die('Error retrieving user information ['. $db->error.']');
          }

          if(isset($login_session)){
              $db->close();
              //header("location: index.php");
          }
        } else{
          //currently has a pending leave
        }
    }
}
?>
