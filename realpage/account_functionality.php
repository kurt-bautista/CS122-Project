<?php

$error = '';
$server = 'localhost';
$server_user = 'root';
$server_pass = '';
$database_name = 'company';

$db = new mysqli($server,$server_user,$server_pass, $database_name);

if($db->connect_errno > 0){
    die('Unable to connect to database ['. $db->connect_error.']');
}

session_start();
if(!$user_login = $_SESSION['login_user']){
    header("location: index.php");
}

$fetch_info = <<<SQL
SELECT first_name, last_name , username, employee_type FROM employees WHERE username = '$user_login'
SQL;

if(!$result = $db->query($fetch_info)){
    die('Error retrieving user information ['. $db->error.']');
}

$row = $result ->fetch_assoc();
$Fname = $row['first_name'];
$Lname = $row['last_name'];
$login = $row['username'];
$type = $row['employee_type'];

if(isset($_POST['Change Password'])){
$row = $result -> fetch_assoc();
$password = $row['password'];
$id = $row ['id'];

	if(empty($_POST['current password']) || empty($_POST['new_password']) || empty($_POST['repeat_new_password'])){ 
		$error =  'Please fill in blank spaces';
	}
	else if ($_POST['current password'] != $password){
		$error = 'Wrong Password'; 
	}
	
	else if   ($_POST['new_password'] != $_POST['repeat_new_password']) { 
		$error = 'New passwords do not match';
	}
	else{ 
		$new_password = $_POST[new_password];
	}

	$write_data = <<<SQL
	UPDATE employees SET password = $new_password WHERE  id = $id;
SQL;

        if(!$write = $db->query($write_data)){
            die('Error retrieving user information ['. $db->error.']');
        }
	$db->close();
        
}	
	
?>