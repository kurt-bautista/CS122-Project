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
	$myId = $_SESSION['employee_id'];
	$getTeamMembers = <<<SQL
	SELECT CONCAT(COALESCE(e.first_name, ''), ' ', COALESCE(e.last_name, '')) AS "Team Member", w.time_in AS "Time In"
	FROM employees e LEFT JOIN workdays w
	ON w.employees_id = e.id AND DATE(w.time_in) = CURDATE()
	WHERE e.manager_id = '$myId'
SQL;

	if(!$result = $db->query($getTeamMembers))
	{
		die('There was an error running the query [' . $db->error . ']');
	}

	$teamMembers = $result->fetch_all(MYSQLI_ASSOC);
	$timedIn = $result->num_rows;

	$fetch_leave_requests = <<<SQL
	SELECT l.id, l.start_date, l.end_date, l.duration, CONCAT(COALESCE(e.first_name, ''), ' ', COALESCE(e.last_name, '')) AS 'employee'
	FROM leaves l, employees e WHERE l.status = 'PENDING' AND l.employees_id = e.id
SQL;

	if(!$result = $db->query($fetch_leave_requests))
	{
		die('There was an error running the query [' . $db->error . ']');
	}

	$pendingLeaves = $result->fetch_all(MYSQLI_ASSOC);
	
	if(isset($_POST['approve']))
	{
		$leaveId = $_POST['approve'];
		$acceptLeave = <<<SQL
		UPDATE leaves
		SET status = 'ACCEPTED'
		WHERE id = $leaveId;
SQL;
		
		$getEmpId = <<<SQL
		SELECT employees_id
		FROM leaves
		WHERE id = '$leaveId'
SQL;
		
		$getContract = <<<SQL
		SELECT *
		FROM employee_contracts
		WHERE employees_id = '$empId'
SQL;

		if(!$result = $db->query($getEmpId))
		{
			die('There was an error running the query [' . $db->error . ']');
		}
		
		$leave = $result->fetch_assoc();
		$empId = $leave['employees_id'];

		if(!$result = $db->query($getContract))
		{
			die('There was an error running the query [' . $db->error . ']');
		}

		$contract = $result->fetch_assoc();
		$expected_time_in = $contract['expected_time_in'];
		$hourly_rate = $contract['hourly_rate'];
		
		$time_out = date('Y-m-d H:i:s', strtotime($expected_time_in)+28800);
		$db->query($acceptLeave);
		$newWorkday = $db->prepare("INSERT INTO workdays(time_in, time_out, overtime_hours, employees_id, leaves_id, employees_hourly_rate)
		VALUES (?, ?, 0, ?, ?, ?)");
		for($i = 0; $i < $duration; $i++)
		{
			$ti = date('Y-m-d H:i:s', strtotime($expected_time_in)+strtotime($start_date)+($i*86400));
			$to = date('Y-m-d H:i:s', (strtotime($expected_time_in)+strtotime($start_date)+($i*86400))+28800);
			$newWorkday->bind_param('ssiid', $ti, $to, $empId, $leaveId, $hourly_rate);
			$newWorkday->execute();
		}

	}
	if(isset($_POST['reject']))
	{
		$leaveId = $_POST['reject'];
		$rejectLeave = <<<SQL
		UPDATE leaves
		SET status = 'REJECTED'
		WHERE id = $leaveId
SQL;

		$db->query($rejectLeave);
	}

	if(isset($_POST['add_employee']))
	{
		$holiday_type = 'regular'; //
		$newEmp = $db->prepare("INSERT INTO employees(username, password, first_name, last_name, remaining_leaves, employee_type, manager_id, holiday_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$newEmp->bind_param('ssssisis', $_POST['username'], $_POST['password'], $_POST['first-name'], $_POST['last-name'], $_POST['allotted-leaves'], $_POST['employee-type'], $myId, $holiday_type);
		$newEmp->execute();
		$empId = $newEmp->insert_id;
		$newEmp->close();
		$sd = date('Y-m-d', strtotime($_POST['start-date']));
		$ed = date('Y-m-d', strtotime($_POST['end-date']));
		$newContract = $db->prepare("INSERT INTO employee_contracts(start_date, duration, hourly_rate, employees_id, allotted_leaves) VALUES (?, ?, ?, ?, ?)");
		$newContract->bind_param('ssdii', $sd, $ed, $_POST['hourly-rate'], $empId, $_POST['allotted-leaves']);
		$newContract->execute();
		$contractId = $newContract->insert_id;
		$updateEmp = <<<SQL
		UPDATE employees SET employee_contracts_id = '$contractId' WHERE id = $empId
SQL;
		$db->query($updateEmp);
	}
?>
