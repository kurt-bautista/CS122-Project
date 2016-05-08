<?php
include('salaryreport_functionality.php');
?>

<html>

    <head>
        <title>Salary Report</title>

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
                    <li class="active"><a href="salaryreport.php">Salary Report</a></li>

                    <?php if($_SESSION['employee_type'] == 'manager'){?>
                    <li><a href="manager.php">Manager</a></li>
                    <?php } ?>

                    <li><a href="account.php">Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        <!--Navbar-->

        <div id="main" class="center_container">
            
            <div class="row">
                <div class="card col s4 center hoverable">
                    <div class="card-content">
                        <span class="card-title">Expected Salary</span>                       
                        <h1 id="expected-salary" class="teal-text apply_roboto"></h1>
                        
                        <div class="divider"></div>
                        
                        <div class="apply_roboto" style="font-size: 20px">
                            <p class="">Base Salary: <span id="base-salary"></span></p>
                            <p class="apply_roboto">Overtime Pay: <span id="overtime-pay"></span></p>
                            <p class="apply_roboto">Undertime Deductions: <span id="undertime-deductions"></span></p>
                        </div>
                    </div>
                </div>
                
                <div class="card col 7 offset-s1 center hoverable">
                    <div class="card-content">
                        
                    </div>
                </div>
            </div>

        </div>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>       
        <script type="text/javascript" src="js/countUp.js"></script>

        <script>
            $(document).ready(function(){
               $(".button-collapse").sideNav(); 
               
               var salaryAnimation = new CountUp(document.getElementById("expected-salary").id, 0, 69000);
               salaryAnimation.start();
               var baseAnimation = new CountUp(document.getElementById("base-salary").id, 0, 42000);
               baseAnimation.start();
               var overtimeAnimation = new CountUp(document.getElementById("overtime-pay").id, 0, 42000);
               overtimeAnimation.start();
               var undertimeAnimation = new CountUp(document.getElementById("undertime-deductions").id, 0, 69000);
               undertimeAnimation.start();

            });
        </script>

    </body>

</html>
