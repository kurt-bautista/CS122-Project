<?php
include('timerecord_functionality.php');
?>

<html>
    
    <head>
        <title>Time Record</title>
        
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
                    <li class="active"><a href="timerecord.php">Time Record</a></li>
                    <li><a href="leaves.php">Leaves</a></li>
                    <li><a href="salaryreport.php">Salary Report</a></li>
                    
                    <?php if($_SESSION['employee_type'] == 'Manager'){?>
                    <li><a href="manager.php">Manager</a></li>
                    <?php } ?>
                    
                    <li><a href="account.php">Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>       
            </div>
        </nav>
        <!--Navbar-->
        
        <div id="main" class="center_container">
            
            <!--Time In - Time Out-->
            <div class="row">
                <div class="card col s12 time_in_out_card hoverable">
                    <div class="card-content">
                        
                    </div>
                </div>
                
                <!--
                <div class="card small col s7 offset-s1 hoverable">
                    <div class="card-content">
                        
                    </div>
                </div>-->
            </div>
            <!--Time In - Time Out-->
            
            <!--Time Record Summary-->
            <div class="row">
                <div class="card col s12 center hoverable">
                    <div class="card-content">
                        <span class="card-title">Time In - Time Out Record</span>
                    </div>
                </div>
            </div>
            <!--Time Record Summary-->
            
        </div>
       
       <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        
        <script>            
            $(document).ready(function(){
               $(".button-collapse").sideNav(); 
            });
        </script>
        
    </body>
    
</html>