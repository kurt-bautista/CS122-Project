<?php
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
                        <p class="apply_roboto" style="font-size:18px">Total Members: 420</p> 
                        
                        <div class="divider" style="margin-top:20px; margin-bottom:20px;"></div>
                                              
                        <!--Team Attendance-->
                        <!--PHP for loop-->
                        <div class="chip tooltipped" data-position="botom" data-delay="40" data-tooltip="Signed in at: 4:20 AM">
                            <img src="img/employee.jpg" alt="Contact Person">
                            Anton Suba <!--Replace with PHP-->
                        </div>
                    </div>
                    
                    <div class="card-action">
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
                        
                        <div class="input-field col s12 center">
                            <span style="margin-right:10px">
                                <input name="employee-type" id="regular" class="with-gap" type="radio"/>
                                <label for="regular">Regular</label>
                            </span>
                            <span style="margin-left:10px">
                                <input name="employee-type" id="manager" class="with-gap" type="radio"/>
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
                        
                        <!--PHP Loop here-->
                        <li>
                            <div class="collapsible-header apply_roboto">                               
                                <span>Anton Suba</span>
                                <!--<input class="right" type="checkbox" id="1" style="margin-top:10px"/>
                                <label class="right" for="1" style="margin-top:10px">Approve</label>    -->
                                
                                <!--
                                <i class="material-icons red-text text-lighten-1 right tooltipped"
                                data-position="bottom" data-delay="40" data-tooltip="Reject">not_interested</i>
                                <i class="material-icons green-text text-lighten-2 right tooltipped" type="submit"
                                data-position="bottom" data-delay="40" data-tooltip="Approve">done</i>-->                                                                                     
                            </div>
                            <div class="collapsible-body apply_roboto">                               
                                <div class="chip" style="margin-top:15px; margin-left:25px;">
                                    <span> April 20, 2016 - April 22, 2016</span> <!--Replace with PHP query-->
                                </div>    
                                <p style="font-size:18px">Reason: I need to blaze it</p> <!--Replace with PHP query-->
                                <p>
                                    <button class="btn waves-effect waves-light" type="submit" name="approve_leave" value="approve_leave">
                                        <i class="material-icons left">done</i>Approve
                                    </button>
                                    <button class="btn waves-effect waves-light" type="submit" name="reject_leave" value="reject_leave">
                                        <i class="material-icons left">not_interested</i>Reject
                                    </button>
                                </p>
                            </div>
                        </li>
                        <!--PHP Loop here-->                        
                    </ul>
                    <!--
                    <p class="center">
                        <button class="btn waves-effect waves-light" type="submit" name="approve_leaves" value="approve_leaves">
                            Approve Leaves
                        </button>
                    </p>-->
                    </form>
                </div>
                <!--Leave Approval-->
                
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
               
               $('.datepicker').pickadate({
                    selectMonths: true,
                    selectYears: 15
                });
               
               var myCircle = Circles.create({
                    id:                  'team_circle',
                    radius:              70,
                    value:               24,
                    maxValue:            100, //Replace with php query
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