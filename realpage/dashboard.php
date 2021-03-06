<?php
//Made by: Anton Suba

include('session.php');
?>

<html>
    
    <head>
        <title>Dashboard</title>
        
        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    
    <body class="blue-grey lighten-1">
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
                    <li><a href="manager.php">Manager</a></li>
                    <?php } ?>
                    
                    <li><a href="account.php">Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>       
            </div>
        </nav>
        <!--Navbar-->
        
        <div id="main" class="container">
            
            <h1 class="center white-text"> Welcome <?php echo($first_name); ?> </h1>
               
            <div class="row">
                <p class="apply_roboto center white-text" style="font-size:35px">Here are a few things to get you started</p>
            </div>
            
            <div class="row">
                <ul id="quick-cards">
                    
                    <li style="opacity:0">
                    <div class="card col s6 offset-s3 center hoverable">
                        <div class="card-content ">
                            <p class="apply_roboto" style="font-size:24px">Expected Time In: 
                                <span class="teal-text"><?php echo($expected_time_in);?></span>
                            </p>                       
                        </div>
                    </div>
                    </li>
                    
                    <li style="opacity:0">
                    <div class="card col s6 offset-s3 center hoverable">
                        <div class="card-content ">
                            <p class="apply_roboto" style="font-size:24px">Remaining Leaves: 
                                <span class="teal-text"><?php echo($remaining_leaves);?></span>
                            </p>                       
                        </div>
                    </div>
                    </li>
                    
                    <li style="opacity:0">
                    <div class="card col s6 offset-s3 center hoverable">
                        <div class="card-content ">
                            <p class="apply_roboto" style="font-size:24px">Expected Salary: 
                                <span class="teal-text"><?php echo($expected_salary);?></span>
                            </p>                       
                        </div>
                    </div>
                    </li>
                    
                </ul>
            </div>
              
        </div>
            
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        
        <script>            
            $(document).ready(function(){
               $(".button-collapse").sideNav();
               
               Materialize.showStaggeredList("#quick-cards"); 
            });
        </script>
    </body>
    
</html>