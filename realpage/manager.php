<?php
include('dummy_manager.php');
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
                        <a class="clickable_text teal-text"><i class="material-icons" style="margin-right:5px">supervisor_account</i>
                        Add Employee</a>
                    </div>
                </div>
                <!--Team Status-->
                
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
                                <input class="right" type="checkbox" id="1" style="margin-top:10px"/> <!--Replace ID with leave request id -->
                                <label class="right" for="1" style="margin-top:10px">Approve</label>                                                           
                            </div>
                            <div class="collapsible-body apply_roboto">                               
                                <div class="chip" style="margin-top:15px; margin-left:25px;">
                                    <span> April 20, 2016 - April 22, 2016</span> <!--Replace with PHP query-->
                                </div>    
                                <p style="font-size:18px">Reason: I need to blaze it</p> <!--Replace with PHP query-->
                            </div>
                        </li>
                        <!--PHP Loop here-->                        
                    </ul>
                    <p class="center">
                    <button class="btn waves-effect waves-light" type="submit" name="submit" value="approve_leaves">
                        Approve Leaves
                    </button>
                    </p>
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