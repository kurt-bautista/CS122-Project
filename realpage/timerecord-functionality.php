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

	$empId = $_SESSION['employee_id'];
	$getContract = <<<SQL
	SELECT *
	FROM employee_contracts
	WHERE employees_id = '$empId'
SQL;

	if(!$result = $db->query($getContract))
	{
		die('There was an error running the query [' . $db->error . ']');
	}
	
	$contract = $result->fetch_assoc();
	$expected_time_in = $contract['expected_time_in'];
	
	if(isset($_POST['btnsubmit']))
	{
		date_default_timezone_set('Asia/Manila');
		$timeNow = date('Y-m-d H:i:s');		
		if($_POST['btnsubmit'] == 'Time In')
		{
			$hourly_rate = $contract['hourly_rate'];
			$workday = $db->prepare("INSERT INTO workdays(time_in, time_out, employees_id, employees_hourly_rate) VALUES (?, ?, ?, ?)");
			$workday->bind_param('ssid', $timeNow, $timeNow, $empId, $hourly_rate);
			$workday->execute();
			$_SESSION['workday_id'] = $workday->insert_id;
			$workday->close();
			
			$_SESSION['time-status'] = "Time Out";
		}
		else
		{
			$hours = 0;
			$timeOut = $db->prepare("UPDATE workdays SET time_out = ?, overtime_hours = ? WHERE id = ?");
			$timeOut->bind_param('sii', $timeNow, $hours, $_SESSION['workday_id']);
			$timeOut->execute();
			$timeOut->close();
			
			$_SESSION['time-status'] = "Time In";
		}
	}
	$months = array("Jan"=>1, "Feb"=>2, "Mar"=>3, "Apr"=>4, "May"=>5, "June"=>6, "July"=>7, "Aug"=>8, "Sept"=>9, "Oct"=>10, "Nov"=>11, "Dec"=>12);
	$curMonth = date('m');
	$getWorkdays = $db->prepare("SELECT DATE(time_in) AS 'Date', TIME(time_in) AS 'Time In', TIME(time_out) AS 'Time Out', 
	CASE WHEN HOUR(TIMEDIFF(time_out, time_in)) - 8 > 0 THEN HOUR(TIMEDIFF(time_out, time_in)) - 8 
	ELSE 0 END AS 'Overtime', 
	CASE WHEN HOUR(TIMEDIFF(time_out, time_in)) > 8 THEN 0 
	ELSE 8 - HOUR(TIMEDIFF(time_out, time_in)) END AS 'Undertime', 
	HOUR(TIMEDIFF(time_out, time_in)) AS 'Total Hours'
	FROM workdays WHERE YEAR(CURDATE()) = YEAR(time_in) AND MONTH(time_in) = ? AND employees_id = ? AND time_in != time_out ORDER BY time_in DESC");
	$getWorkdays->bind_param('ii', $curMonth, $empId);
	$getWorkdays->execute();
	$result = $getWorkdays->get_result();
	$workdaysMonth = $result->fetch_all(MYSQLI_BOTH);
?>