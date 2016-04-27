<?php

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
    SELECT username, first_name, last_name, remaining_leaves FROM login
    WHERE username='$user_login'
SQL;

if(!$result = $db->query($fetch_info)){
    die('Error retrieving user information ['. $db->error.']');
}

$row = $result->fetch_assoc();
$login_session = $row['username'];
if(isset($login_session)){
    $db->close();
    //header("location: index.php");
}
?>
