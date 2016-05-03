<?php
session_start();
$error = '';

if(isset($_POST['submit'])){
    if(empty($_POST['username']) || empty($_POST['password'])){
        $error = 'Username or Password invalid';
    }
    else{
        $username = $_POST['username'];
        $password = $_POST['password'];

        //Variables for MySQL
        $server = 'localhost';
        $server_user = 'root';
        $server_pass = '';
        $database_name = 'realpagetest';

        $db = new mysqli($server, $server_user, $server_pass, $database_name);

        if($db->connect_errno > 0){
            die('Unable to connect to database ['. $db->connect_error.']');
        }

        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysqli_real_escape_string($db,$username);
        $password = mysqli_real_escape_string($db,$password);

        //MySQLi Query [Checks if username and passowrd matched]
        $verify_login = <<<SQL
            SELECT * FROM employees
            WHERE username='$username' AND password='$password'
SQL;

        //If connection failed
        if(!$result = $db->query($verify_login)){
            die('Error retrieving information from database ['. $db->error.']');
        }

        //There must be exactly one row
        if($result->num_rows == 1){
            $_SESSION['login_user'] = $username;
            //Checks for emplyee type
            $row = $result->fetch_assoc();
            $employee_type = $row['employee_type'];
            $_SESSION['employee_type'] = $employee_type;
            
            header("location: dashboard.php");
        }
        else{
            $error = "Username or Password is invalid";
        }
        $result->free();
        $db->close();
    }
}
?>
