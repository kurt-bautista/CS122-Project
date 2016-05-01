<?php
session_start();
$error = '';

if(isset($_POST['submit'])){
    if(empty($_POST['date_picker'])){
        $error = 'Please fill in the request form';
    }
    else{
        $date_request = $_POST['date_picker'];
        $leave_reason = $_POST['leave_reason_text'];
        $employee_id = $_SESSION['employee_id'];

        $server = 'localhost';
        $server_user = 'root';
        $server_pass = '';
        $database_name = 'realpagetest';

        $db = new mysqli($server, $server_user, $server_pass, $database_name);

        if($db->connect_errno > 0){
            die('Unable to connect to database ['. $db->connect_error.']');
        }

        if(!$user_login = $_SESSION['login_user']){
            header("location: index.php");
        }

        $write_data = <<<SQL
          INSERT INTO leave_requests(request_date, leave_reason, employees_id) VALUES
          ($date_request, $leave_reason, $employee_id)
        SQL;

        $fetch_info = <<<SQL
            SELECT username, remaining_leaves
            FROM employees
            WHERE employees.username='$user_login'
        SQL;

        if(!$result = $db->query($fetch_info) || !$write = $db->query($write_data)){
            die('Error retrieving user information ['. $db->error.']');
        }

        $row = $result->fetch_assoc();
        if(isset($login_session)){
            $db->close();
            //header("location: index.php");
        }
    }
}
?>
