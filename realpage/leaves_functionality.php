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
SELECT employees.username "username", employees.remaining_leaves "remaining_leaves",
(SELECT COUNT(*) FROM leaves) "leaves_taken",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=1) "maternity_leaves",
(SELECT COUNT(*) FROM leaves WHERE leave_types_id=2) "sick_leaves"
FROM employees, leaves
WHERE employees.username='$user_login' AND leaves.employees_id = employees.id
SQL;

if(!$result = $db->query($fetch_info)){
    die('Error retrieving user information ['. $db->error.']');
}

$row = $result->fetch_assoc();
$login_session = $row['username'];
$remaining_leaves = $row['remaining_leaves'];
$leaves_taken = $row['leaves_taken'];
$maternity_leaves = $row['maternity_leaves'];
$sick_leaves = $row['sick_leaves'];

if(isset($_POST['submit'])){
    if(empty($_POST['date_picker'])){
        $error = 'Please fill in the request form';
    }
    else{
        $date_request = $_POST['date_picker'];
        $leave_reason = $_POST['leave_reason_text'];
        $employee_id = $_SESSION['employee_id'];

        $write_data = <<<SQL
        INSERT INTO leave_requests(request_date, leave_reason, employees_id)
        VALUES ('$date_request', '$leave_reason', '$employee_id')
SQL;

        if(!$write = $db->query($write_data)){
            die('Error retrieving user information ['. $db->error.']');
        }

        if(isset($login_session)){
            $db->close();
            //header("location: index.php");
        }
    }
}
?>
