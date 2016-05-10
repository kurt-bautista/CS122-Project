<?php
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
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
        $database_name = 'company';
        
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
            WHERE username='$username'
SQL;

        //If connection failed
        if(!$result = $db->query($verify_login)){
            die('Error retrieving information from database ['. $db->error.']');
        }
        
        //Uncomment this for password verification
        
        $usersAssoc = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($usersAssoc as $userRow) {
            if(password_verify($password, $userRow['password'])){
                $_SESSION['login_user'] = $username;
                
                //Checks for employee type               
                $employee_type = $userRow['employee_type'];
                $_SESSION['employee_type'] = $employee_type;
                
                header("location: dashboard.php");
            }
            else{
                $error = "Username or Password is invalid";
            }
        }
        
        //Uncomment this for old password verification
        /*
        if($result->num_rows == 1){
            $_SESSION['login_user'] = $username;
            
            //Checks for employee type
            $row = $result->fetch_assoc();
            $employee_type = $row['employee_type'];
            $_SESSION['employee_type'] = $employee_type;
            
            header("location: dashboard.php");
        }
        else{
            $error = "Username or Password is invalid";
        }*/
        
        $result->free();
        $db->close();
    }
}
?>
