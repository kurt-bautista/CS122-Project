<?php

    $server = 'localhost';
    $server_user = 'root';
    $server_pass = '';
    $database_name = 'company';
    
    $error = '';

    $db = new mysqli($server, $server_user, $server_pass, $database_name);

    if($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    ini_set('session.gc_maxlifetime', 86400);
    session_set_cookie_params(86400);
    session_start();
    if(!$user_login = $_SESSION['login_user']){
    header("location: index.php");
    }

    $get_hourly_rate = <<<SQL
    SELECT hourly_rate, start_date, duration AS 'end_date'
    FROM employee_contracts
SQL;

    if(!$result = $db->query($get_hourly_rate)) {
        die('There was an error running the query [' . $db->error . ']');
    }
    
    $ec_table = $result->fetch_all(MYSQLI_ASSOC);
    $input_start = strtotime('2016-01-01');
    $input_end = strtotime('2016-12-28');
    $output = array();
    $sevendays = 86400 * 7;
    $sixdays = 86400 * 6;
    
    for($s = $input_start; $s <= $input_end; $s += $sevendays)
    {
        $weeksalary = 0;
        foreach($ec_table as $row)
        {
            $daily_rate = $row['hourly_rate'] * 8;
            $contract_start = strtotime($row['start_date']);
            $contract_end = strtotime($row['end_date']);
            
            for($d = $s; $d <= $s + $sixdays && $d <= $contract_end + 86400; $d += 86400)
            {
                if($d >= $contract_start && $d >= $input_start)
                {
                    $weeksalary += $daily_rate;
                }
            }
        }
        $output[date('Y-m-d', $s)] = $weeksalary;
    }
    
    foreach ($output as $week => $salary) {
        echo $week . "--" . $salary . "<br>";
    }
    
?>