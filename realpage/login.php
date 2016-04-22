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
        $database = "localhost";
        $database_user = "";
        $database_pass = "";
    } 
}