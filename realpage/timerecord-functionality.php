<?php
	$server = 'localhost';
	$server_user = 'root';
	$server_pass = '';
	$database_name = 'realpagetest';

	$db = new mysqli($server, $server_user, $server_pass, $database_name);

	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}

	session_start();
	if(!$user_login = $_SESSION['login_user']){
		header("location: index.php");
	}

	if(isset($_POST['submit'])){
		$time = new DateTime();
		$time->format('Y-m-d H:i:s');
		$timeNow = $time->getTimestamp();
		if($_POST['submit'] == 'Time In'){
			$rate = $db->prepare("SELECT hourly_rate AS Hourly Rate FROM employee_contracts WHERE employees_id = ?");
			$rate->bind_param('i', $_SESSION['employee_id']);
			$rate->execute();
			$rate->bind_result($hourly_rate);
			$row = $rate->get_result();
			$hourly_rate = $row->fetch_array(MYSQLI_ASSOC);
			$workday = $db->prepare("INSERT INTO workdays(time_in, employees_id, employees_hourly_rate) VALUES (?, ?, ?)");
			$workday->bind_param('sid', $timeNow, $_SESSION['employee_id'], $hourly_rate['Hourly Rate']);
			$workday->execute();
			$_SESSION['workday_id'] = $workday->insert_id;
			$rate->close();
			$workday->close();
		}
		else{
			$timeOut = $db->prepare("UPDATE workdays SET time_out = ? WHERE employees_id = ? AND id = ?");
			$timeOut->bind_param('sii', $timeNow, $_SESSION['employee_id'], $_SESSION['workday_id']);
			$timeOut->execute();
			$timeOut->close();
		}
	}
?>