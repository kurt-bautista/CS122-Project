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
                        <p class="apply_roboto" style="font-size:16px">Total Team Members: 420</p> 
                                              
                        <!--Team Attendance-->
                        <!--PHP for loop-->
                        <div class="chip tooltipped" data-position="botom" data-delay="40" data-tooltip="Signed in at: 4:20 AM">
                            <img src="img/employee.jpg" alt="Contact Person">
                            Anton Suba <!--Replace with PHP-->
                        </div>
                    </div>
                </div>
                <!--Team Status-->
                
                <!--Leave Approval-->
                <div class="col s7 offset-s1">
                    <ul class="collapsible popout" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header apply_roboto" style="font-size: 30px">
                                Pending Leave Requests
                            </div>
                        </li>
                        <li>
                            <div class="collapsible-header apply_roboto">                               
                                <span>Anton Suba</span>                                                           
                            </div>
                            <div class="collapsible-body apply_roboto">
                                <div class="chip">
                                    <span> 3 Days</span>
                                </div>
                                <div class="chip">
                                    <span> April 20, 2016 - April 22, 2016</span>
                                </div>    
                                <p>Reason: I need to blaze it</p>
                            </div>
                        </li>
                    </ul>
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