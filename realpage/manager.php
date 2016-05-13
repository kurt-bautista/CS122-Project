<?php
//Made by: Anton Suba and Kurt Bautista

include('manager-functionality.php');
?>

<html>

    <head>
        <title>Manager</title>

        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body class="grey lighten-5">

         <!--Navbar [Copy this to all pages]-->
        <nav class="blue-grey darken-4">
            <div class="nav-wrapper">
                <a href="#" data-activates="slide-out" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
                <ul id="slide-out" class="side-nav fixed">
                    <li><a href="dashboard.php"><img class="responsive-img" src="img/company-logo-blue.png"></a></li>
                    <li><a href="timerecord.php">Time Record</a></li>
                    <li><a href="leaves.php">Leaves</a></li>
                    <li><a href="salaryreport.php">Salary Report</a></li>

                    <?php if($_SESSION['employee_type'] == 'manager'){?>
                    <li class="active"><a href="manager.php">Manager</a></li>
                    <?php } ?>

                    <li><a href="account.php">Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        <!--Navbar-->

        <div id="main" class="center_container">

            <div class="row">

                <!--Team Status-->
                <div class="card col s4 team_status_card center hoverable">
                    <div class="card-content">

                        <span class="card-title col s12">Team Status</span>

                        <div id="canvas">
                            <div class="circle" id="team_circle"></div>
                        </div>
                        <p class="apply_roboto" style="font-size:18px">Total Members: <?php echo($allMembers);?></p>

                        <div class="divider" style="margin-top:20px; margin-bottom:20px;"></div>

                        <!--Team Attendance-->
                        <?php
                        $signInCounter = 0;
                        foreach ($teamMembers as $memberRow) {
                            $signInTime = '';
                            if($memberRow['Time In'] == NULL){
                                $signInTime = 'Not yet signed in';
                            }
                            else if($memberRow['Leave ID'] == NULL) {
                                $signInTime = 'Signed in at: '.$memberRow['Time In'];
                                $signInCounter++;
                            }
                            else {
                                $signInTime = 'On leave';
                            }
                            ?>
                            <div class="chip tooltipped chip_style" data-position="botom" data-delay="40" data-tooltip="<?php echo($signInTime);?>">
                                <img src="img/employee.jpg" alt="Contact Person">
                                <?php echo($memberRow['Team Member']);?>
                            </div>
                        <?php }
                        ?>


                    </div>

                    <div class="card-action">
                        <span class="red-text text-darken-1 col s12"><?php echo $error; ?></span>
                        <a class="modal-trigger clickable_text teal-text" href="#add-emp-modal">
                            <i class="material-icons" style="margin-right:5px">supervisor_account</i>Add Employee
                        </a>
                    </div>
                </div>
                <!--Team Status-->

                <!--Add Employee Modal-->
                <div class="modal modal-fixed-footer" id="add-emp-modal">
                    <form action="" method="POST">
                    <div class="modal-content">
                        <div class="apply_roboto col s12" style="font-size:24px">Add Employee</div>
                        <div class="input-field col s6">
                            <input id="first-name" name="first-name" type="text" class="validate">
                            <label for="first-name">First Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="last-name" name="last-name" type="text" class="validate">
                            <label for="last-name">Last Name</label>
                        </div>

                        <div class="input-field col s12">
                            <input id="username" name="username" type="text" class="validate">
                            <label for="username">Username</label>
                        </div>

                        <div class="input-field col s12">
                            <input id="password" name="password" type="password" class="validate">
                            <label for="password">Password</label>
                        </div>

                        <div class="input-field col s3">
                            <input id="allotted-leaves" name="allotted-leaves" type="number" class="validate">
                            <label for="allotted-leaves">Allotted Leaves</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="hourly-rate" name="hourly-rate" type="number" class="validate">
                            <label for="hourly-rate">Hourly Rate</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="start-date" name="start-date" type="date" class="datepicker">
                            <label for="start-date">Start Date</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="end-date" name="end-date" type="date" class="datepicker">
                            <label for="end-date">End Date</label>
                        </div>

                        <div class="input-field col s6">
                            <input id="expected-time" name="expected-time" type="text" class="validate">
                            <label for="expected-time">Expected Time In [24 hour format - Hour:Minute]</label>
                        </div>
                        <div class="input-field col s6 center">
                            <span style="margin-right:10px">
                                <input name="employee-type" id="regular" class="with-gap" type="radio" value="regular"/>
                                <label for="regular">Regular</label>
                            </span>
                            <span style="margin-left:10px">
                                <input name="employee-type" id="manager" class="with-gap" type="radio" value="manager"/>
                                <label for="manager">Manager</label>
                            </span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn waves-effect waves-light" type="submit" name="add_employee" value="add_employee">
                            Submit
                        </button>
                    </div>

                    </form>
                </div>
                <!--Add Employee Modal-->

                <!--Leave Approval-->
                <div class="col s7 offset-s1">
                    <form action="" method="POST">
                    <ul class="collapsible popout" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header apply_roboto" style="font-size: 30px">
                                Pending Leave Requests
                            </div>
                        </li>

                        <?php foreach ($pendingLeaves as $leaveRow) {
                        ?>
                        <li>
                            <div class="collapsible-header apply_roboto">
                                <span><?php echo($leaveRow['employee']);?></span>
                            </div>
                            <div class="collapsible-body apply_roboto">
                                <div class="chip" style="margin-top:15px; margin-left:25px;">
                                    <span> <?php echo(date('F j, Y',strtotime($leaveRow['start_date'])).' - '.date('F j, Y',strtotime($leaveRow['end_date'])));?></span>
                                </div>
                                <div class="chip" style="margin-top:15px; margin-left:25px;">
                                    <span> <?php echo $leaveRow['name'];?></span>
                                </div>
                                <p style="font-size:18px"><?php echo($leaveRow['leave_reason']);?>
                                <p>
                                    <button class="btn waves-effect waves-light" type="submit" name="approve_leave" value="<?php echo($leaveRow['id']);?>">
                                        <i class="material-icons left">done</i>Approve
                                    </button>
                                    <button class="btn waves-effect waves-light" type="submit" name="reject_leave" value="<?php echo($leaveRow['id']);?>">
                                        <i class="material-icons left">not_interested</i>Reject
                                    </button>
                                </p>
                            </div>
                        </li>
                        <?php }?>

                    </ul>
                    </form>
                </div>
                <!--Leave Approval-->
                
                <div class="card col s12 center hoverable">
                    <p class="card-title">Team Time Record</p>
                    
                    <ul class="tabs">
                        <li class="tab"><a class="teal-text" href="#sort-by-emp">Sort by Employee</a></li>
                        <li class="tab"><a class="teal-text" href="#sort-by-date">Sort by Date</a></li>
                        <div class="indicator teal" style="z-index:1"></div>  
                    </ul>
                    <div class="divider"></div>
                    
                    <div id="sort-by-date">
                    <!--Sort by Date - Display Employees per Date-->
                    <ul class="tabs">
                        <?php
                        foreach ($distinctDates as $distinctDateRow) {
                            $distinctDate = $distinctDateRow['Date'];?>
                            <li class="tab"><a class="teal-text" href="<?php echo("#".$distinctDate);?>"><?php echo($distinctDate);?></a></li>
                        <?php }?>
                        <div class="indicator teal" style="z-index:1"></div>  
                    </ul>
                    
                    <?php
                    foreach ($distinctDates as $distinctDateRow) {
                        $distinctDate = $distinctDateRow['Date'];
                        $getEmpPerDate = <<<SQL
                        SELECT e.first_name FROM employees e, workdays w WHERE e.id = w.employees_id AND DATE(w.time_in) = '$distinctDate'
SQL;
                        
                        if(!$result = $db->query($getEmpPerDate))
                        {
                            die('There was an error running the query [' . $db->error . ']');
                        }
                        $empPerDate = $result->fetch_all(MYSQLI_ASSOC);
                        ?>
                        
                        <div class="col s12" id="<?php echo($distinctDate)?>">
                            <table class="centered highlight responsive-table">
                                    <tbody>
                                        <?php
                                        foreach ($empPerDate as $empPerDateRow) {
                                            $empDate = $empPerDateRow['first_name'];
                                            ?>
                                            <tr>
                                                <td><?php echo($empDate);?></td>
                                            </tr>
                                            <?php
                                        }?>
                                    </tbody>
                                </table>
                        </div>
                        
                    <?php
                    }
                    ?>
                    <!--Sort by Date - Display Employees per Date-->
                    </div>
                    
                    <div id="sort-by-emp">
                    <!--Sort by Employee - Display Dates per Employee-->
                    <ul class="tabs">                 
                        <?php
                        foreach ($empNum as $empNumRow) {                           
                            $empRecordName = $empNumRow['first_name'];
                            ?>
                           <li class="tab"><a class="teal-text" href="<?php echo("#".$empRecordName)?>"><?php echo $empRecordName;?></a></li>
                        <?php }?>
                        <div class="indicator teal" style="z-index:1"></div>  
                    </ul>
                    <div class="divider"></div>
                        <?php         
                         foreach ($empNum as $empNumRow) {
                            $empRecordId = $empNumRow['id'];
                            $empRecordName = $empNumRow['first_name'];
                            
                            $getAllTimeRecords = <<<SQL
                            SELECT w.time_in AS "Time In"
                            FROM employees e LEFT JOIN workdays w
                            ON w.employees_id = '$empRecordId'
SQL;
                            
                            if(!$result = $db->query($getAllTimeRecords)){
                                die('There was an error running the query [' . $db->error . ']');
                            }
                            $allTimeRecords = $result->fetch_all(MYSQLI_ASSOC);
                            
                            ?>
                            <div class="col s12" id="<?php echo($empRecordName);?>">
                                <table class="centered highlight responsive-table">
                                    <tbody>
                                        
                                        <?php
                                        foreach ($allTimeRecords as $timeRecordRow) {
                                            $timeRecord = $timeRecordRow['Time In'];
                                            ?>
                                            <tr>                               
                                                <td><?php echo "<br>".$timeRecord;?></td>
                                            </tr>
                                            <?php
                                        }?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }
                        ?>
                        <!--Sort by Employee - Display Dates per Employee-->
                        </div>                       
                </div>
                
                <div class="class col s12 hoverable center">
                    
                </div>

            </div>

        </div>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/circles.min.js"></script>

        <script>
            $(document).ready(function(){
               $(".button-collapse").sideNav();

               $('.modal-trigger').leanModal();
               
               $('ul.tabs').tabs();

               $('.datepicker').pickadate({
                    selectMonths: true,
                    selectYears: 15,
                    format: 'yyyy/mm/dd'
                });

               var myCircle = Circles.create({
                    id:                  'team_circle',
                    radius:              70,
                    value:               parseInt("<?php echo $signInCounter ?>"),
                    maxValue:            parseInt("<?php echo $allMembers ?>"),
                    width:               10,
                    text:                function(value){return value;},
                    colors:              ['#b2dfdb', '#009688'],
                    duration:            900,
                    wrpClass:            'circles-wrp',
                    textClass:           'circles-text',
                    valueStrokeClass:    'circles-valueStroke',
                    maxValueStrokeClass: 'circles-maxValueStroke',
                    styleWrapper:        true,
                    styleText:           true
               });
            });
        </script>

    </body>

</html>
