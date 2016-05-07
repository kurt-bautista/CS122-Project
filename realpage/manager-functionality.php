<?php
	$server = 'localhost';
	$server_user = 'root';
	$server_pass = '';
	$database_name = 'company';

	$db = new mysqli($server, $server_user, $server_pass, $database_name);

	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}
	ini_set('session.gc_maxlifetime', 86400);
	session_set_cookie_params(86400);
	session_start();
	if(!$user_login = $_SESSION['login_user']){
		header("location: index.php");
	}

	if(isset($_POST['submit']))
	{
		$employee_type = 'regular'; //pls fix
		$holiday_type = 'regular'; //
		$s_date = '2000-4-20'; //
		$e_date = '2010-4-20'; //
		$newEmp = $db->prepare("INSERT INTO employees(username, password, first_name, last_name, remaining_leaves, employee_type, manager_id, holiday_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$newEmp->bind_param('ssssisis', $_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['allotted_leaves'], $employee_type, $_SESSION['employee_id'], $holiday_type);
		$newEmp->execute();
		$empId = $newEmp->insert_id;
		$newEmp->close();
		$newContract = $db->prepare("INSERT INTO employee_contracts(start_date, end_date, hourly_rate, employees_id) VALUES (?, ?, ?, ?)");
		$newContract->bind_param('ssdi', $s_date, $e_date, $h_rate, $empId);
		$newContract->execute();
	}
?>