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
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
session_start();
if(!$user_login = $_SESSION['login_user']){
    header("location: index.php");
}

$fetch_info = <<<SQL
SELECT employees.username "username", employees.remaining_leaves "remaining_leaves",
employees.employee_type "employee_type", employee_contracts.allotted_leaves "allotted_leaves"
FROM employees, employee_contracts WHERE username='$user_login' AND employee_contracts.employees_id=employees.id
SQL;

$employee_id = $_SESSION['employee_id'];

$fetch_leaves = <<<SQL
SELECT (SELECT COUNT(*) FROM leaves WHERE status = 'APPROVED') "leaves_taken",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=1 AND status = 'APPROVED') "sick_leaves",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=2 AND status = 'APPROVED') "vacation_leaves",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=3 AND status = 'APPROVED') "special_privilege_leaves",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=4 AND status = 'APPROVED') "maternity_leaves",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=5 AND status = 'APPROVED') "paternity_leaves",
leaves.start_date "start_date", leaves.end_date "end_date", leave_types.name "leave_type",
leaves.duration "duration", DAYOFYEAR(leaves.start_date) "start_day", DAYOFYEAR(leaves.end_date) "end_day"
FROM leaves, leave_types
WHERE leaves.employees_id = '$employee_id' AND leaves.leave_types_id = leave_types.id AND leaves.status = 'APPROVED'
SQL;

$fetch_leave_requests = <<<SQL
SELECT start_date, end_date, duration, (SELECT COUNT(*) FROM leaves) "num_of_requests"
FROM leaves WHERE employees_id = '$employee_id' AND status = 'PENDING'
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
$allotted_leaves = $row['allotted_leaves'];
$employee_type = $_SESSION['employee_type'];

$all_leaves = array();
$date_today = getdate();

$leaves_taken = 0;
$sick_leaves = 0;
$vacation_leaves = 0;
$special_privilege_leaves = 0;
$maternity_leaves = 0;
$paternity_leaves = 0;

while($row2 = $leaves_result->fetch_assoc()){
  $leaves_taken = $row2['leaves_taken'];
  $sick_leaves = $row2['sick_leaves'];
  $vacation_leaves = $row2['vacation_leaves'];
  $special_privilege_leaves = $row2['special_privilege_leaves'];
  $maternity_leaves = $row2['maternity_leaves'];
  $paternity_leaves = $row2['paternity_leaves'];

  $date_of_leave = DateTime::createFromFormat("Y-m-d", $row2['start_date']);
  $date_month = $date_of_leave->format("m");
  $date_day = $date_of_leave->format("d");

  //how to get duration
  //$duration = $row2['end_day'] - $row2['start_day'];
  if($date_today['mon'] > $date_month){
    $schedule = date('F d, Y', strtotime($row2['start_date']))." - ".date('F d, Y', strtotime($row2['end_date']));
    array_push($all_leaves, array($row2['duration'], $schedule, $row2['leave_type']));
  } else{
    if($date_today['mday'] >= $date_day){
      $schedule = date('F d, Y', strtotime($row2['start_date']))." - ".date('F d, Y', strtotime($row2['end_date']));
      array_push($all_leaves, array($row2['duration'], $schedule, $row2['leave_type']));
    } else{
      $approved_leave_start_date = date('F d, Y', strtotime($row2['start_date']));
      $approved_leave_end_date = date('F d, Y', strtotime($row2['end_date']));
      $approved_leave_duration = $row2['duration'];
    }
  }
}
$leaves_count = count($all_leaves);

$row3 = $leave_requests_result->fetch_assoc();
$num_of_requests = $row3['num_of_requests'];
$start_date = $row3['start_date'];
$end_date = $row3['end_date'];
$number_of_days = $row3['duration'];

if($num_of_requests < 1){
  $has_pending_leave = false;
} else{
  $has_pending_leave = true;
}

if(isset($_POST['submit'])){
  if($allotted_leaves > 0){
    if(empty($_POST['start_date']) || empty($_POST['end_date']) || empty($_POST['leave_reason_text'])){
        $error = 'Please fill in the request form';
        //echo("<script>console.log('PHP: "."$close_modal"."');</script>");
    }
    else{
        if(!$has_pending_leave){
          $close_modal = true;
          $start_date_request = date("Y-m-d", strtotime($_POST['start_date']));
          $end_date_request = date("Y-m-d", strtotime($_POST['end_date']));

          if($start_date_request < $end_date_request){
            $error = '';
            $leave_reason = $_POST['leave_reason_text'];
            $start_day = date('z', strtotime($start_date_request)) + 1;
            $end_day = date('z', strtotime($end_date_request)) + 1;
            $duration = $end_day - $start_day + 1;
            switch ($_POST['leave-type']) {
              case 'sick':
                $leave_type_id = 1;
                break;
              case 'vacation':
                $leave_type_id = 2;
                break;
              case 'special-privilege':
                $leave_type_id = 3;
                break;
              case 'maternity':
                $leave_type_id = 4;
                break;
              case 'paternity':
                $leave_type_id = 5;
                break;
              default:
                //nothing
                break;
            }

            $write_data = <<<SQL
            INSERT INTO leaves (status, employees_id, leave_types_id, start_date, end_date, duration, leave_reason) VALUES
            ('PENDING', '$employee_id', '$leave_type_id', '$start_date_request', '$end_date_request', '$duration', '$leave_reason')
SQL;

            if(!$write = $db->query($write_data)){
                die('Error retrieving user information ['. $db->error.']');
            }
          } else{
            $error = "Ending date cannot come before starting date of the leave";
          }

          if(isset($login_session)){
              $db->close();
              //header("location: index.php");
          }
        } else{
          $error = "There is currently a pending leave";
        }
    }
  } else{
    $error = "You have exceeded the limit of allotted leaves";
  }
}
?>
