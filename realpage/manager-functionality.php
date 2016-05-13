<?php
	$server = 'localhost';
	$server_user = 'root';
	$server_pass = '';
	$database_name = 'company';

	$error = '';

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
	SELECT CONCAT(COALESCE(e.first_name, ''), ' ', COALESCE(e.last_name, '')) AS "Team Member", w.time_in AS "Time In", w.leaves_id AS "Leave ID"
	FROM employees e LEFT JOIN workdays w
	ON w.employees_id = e.id AND DATE(w.time_in) = CURDATE()
	WHERE e.manager_id = '$myId'
SQL;

	if(!$result = $db->query($getTeamMembers))
	{
		die('There was an error running the query [' . $db->error . ']');
	}

	$teamMembers = $result->fetch_all(MYSQLI_ASSOC);
	$allMembers = $result->num_rows;
	
	//All Employee Time Record
	$getEmpNum = <<<SQL
	SELECT e.id, e.first_name FROM employees e
SQL;

	if(!$result = $db->query($getEmpNum))
	{
		die('There was an error running the query [' . $db->error . ']');
	}
	$empNum = $result->fetch_all(MYSQLI_ASSOC);
	$empNumCount = $result->num_rows;
	
	//All employees given a specific date
	$getDistinctDates = <<<SQL
	SELECT DISTINCT DATE(time_in) As "Date" FROM workdays
SQL;
	
	if(!$result = $db->query($getDistinctDates))
	{
		die('There was an error running the query [' . $db->error . ']');
	}
	$distinctDates = $result->fetch_all(MYSQLI_ASSOC);
	
	foreach ($distinctDates as $distinctDateRow) {
		$distinctDate = $distinctDateRow['Date'];
		$getEmpPerDate = <<<SQL
		SELECT e.first_name FROM employees e, workdays w WHERE e.id = w.employees_id AND DATE(w.time_in) = '$distinctDate'
SQL;

		echo $distinctDate."<br>";
		
		if(!$result = $db->query($getEmpPerDate))
		{
			die('There was an error running the query [' . $db->error . ']');
		}
		$empPerDate = $result->fetch_all(MYSQLI_ASSOC);
		
		foreach ($empPerDate as $empPerDateRow) {
			$empDate = $empPerDateRow['first_name'];
			echo $empDate."<br>";
		}	
	}
	//All employees given a specific date
	
	$fetch_leave_requests = <<<SQL
	SELECT l.id, lt. name, l.start_date, l.end_date, l.duration, CONCAT(COALESCE(e.first_name, ''), ' ', COALESCE(e.last_name, '')) AS 'employee', l.leave_reason
	FROM leaves l, employees e, leave_types lt WHERE l.status = 'PENDING' AND l.employees_id = e.id AND e.manager_id = '$myId' AND l.leave_types_id = lt.id
SQL;

	if(!$result = $db->query($fetch_leave_requests))
	{
		die('There was an error running the query [' . $db->error . ']');
	}

	$numPendingLeaves = $result->num_rows;
	$pendingLeaves = $result->fetch_all(MYSQLI_ASSOC);

	if(isset($_POST['approve_leave']))
	{
		$leaveId = $_POST['approve_leave'];
		$acceptLeave = <<<SQL
		UPDATE leaves
		SET status = 'ACCEPTED'
		WHERE id = $leaveId;
SQL;

		$getEmpId = <<<SQL
		SELECT employees_id, start_date, end_date, duration
		FROM leaves
		WHERE id = '$leaveId'
SQL;

		if(!$result = $db->query($getEmpId))
		{
			die('There was an error running the query [' . $db->error . ']');
		}

		$leave = $result->fetch_assoc();
		$empId = $leave['employees_id'];
		$start_date = $leave['start_date'];
		$end_date = $leave['end_date'];
		$duration = $leave['duration'];

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
		$hourly_rate = $contract['hourly_rate'];

		$db->query($acceptLeave);
		$newWorkday = $db->prepare("INSERT INTO workdays(time_in, time_out, employees_id, leaves_id, employees_hourly_rate)
		VALUES (?, ?, ?, ?, ?)");
		for($i = strtotime($start_date); $i <= strtotime($end_date); $i+=86400)
		{
			$ti = date('Y-m-d', $i) . ' ' . $expected_time_in;
			$to = date('Y-m-d H:i:s', strtotime('+8 hours', strtotime($ti)));
			$newWorkday->bind_param('ssiid', $ti, $to, $empId, $leaveId, $hourly_rate);
			$newWorkday->execute();
		}

		$deductLeaves = <<<SQL
		UPDATE employees
		SET remaining_leaves  = remaining_leaves - '$duration'
		WHERE id = '$empId'
SQL;
		$db->query($deductLeaves);

	}
	if(isset($_POST['reject_leave']))
	{
		$leaveId = $_POST['reject_leave'];
		$rejectLeave = <<<SQL
		UPDATE leaves
		SET status = 'REJECTED'
		WHERE id = $leaveId
SQL;

		$db->query($rejectLeave);
	}

	if(isset($_POST['add_employee']))
	{
		$getUsernames = $db->prepare("SELECT username FROM employees WHERE username = ?");
		$getUsernames->bind_param('s', $_POST['username']);
		$getUsernames->execute();
		$getUsernames->store_result();
		$numrows = $getUsernames->num_rows;
		if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['first-name']) || empty($_POST['last-name']) || empty($_POST['allotted-leaves']) ||
			empty($_POST['employee-type']) || empty($_POST['hourly-rate']) || empty($_POST['start-date']) || empty($_POST['end-date']) || empty($_POST['expected-time'])){
			$error = 'Make sure all fields are filled up';
		}
		else if($numrows > 0)
		{
			$error = 'Username already exists';
		}
		else
		{
			$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$holiday_type = 'regular';
			$newEmp = $db->prepare("INSERT INTO employees(username, password, first_name, last_name, remaining_leaves, employee_type, manager_id, holiday_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			$newEmp->bind_param('ssssisis', $_POST['username'], $hashedPassword, $_POST['first-name'], $_POST['last-name'], $_POST['allotted-leaves'], $_POST['employee-type'], $myId, $holiday_type);
			//$newEmp->bind_param('ssssisis', $_POST['username'], $_POST['password'], $_POST['first-name'], $_POST['last-name'], $_POST['allotted-leaves'], $_POST['employee-type'], $myId, $holiday_type);
			$newEmp->execute();
			$empId = $newEmp->insert_id;
			$newEmp->close();
			$sd = date('Y-m-d', strtotime($_POST['start-date']));
			$ed = date('Y-m-d', strtotime($_POST['end-date']));
			$newContract = $db->prepare("INSERT INTO employee_contracts(start_date, duration, hourly_rate, employees_id, allotted_leaves, expected_time_in) VALUES (?, ?, ?, ?, ?, ?)");
			$newContract->bind_param('ssdiis', $sd, $ed, $_POST['hourly-rate'], $empId, $_POST['allotted-leaves'], $_POST['expected-time']);
			$newContract->execute();
			$contractId = $newContract->insert_id;
			$updateEmp = <<<SQL
			UPDATE employees SET employee_contracts_id = '$contractId' WHERE id = $empId
SQL;
			$db->query($updateEmp);
		}
	}
?>
