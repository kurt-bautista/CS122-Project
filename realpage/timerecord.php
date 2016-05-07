<?php
include('timerecord-functionality.php');
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
            
            <!--Time In - Time Out-->
            
                
            <div class="card col s12 hoverable">
                
                <div class="row">
                    <div class="col s2 offset-s1" id="canvas">
                        <form action="" method="POST">
                            <button id="time-in-out-btn" class="btn-large waves-effect waves-light" type="submit" 
                            name="submit" value="<?php echo($_SESSION['time-status']);?>">
                                <?php echo($_SESSION['time-status']);?>
                        </button>
                    </form>
                    </div>
                    <div class="col s9" id="canvas">
                        <div class="row">
                            <?php if($_SESSION['time-status'] == "Time In"){?>
                                <div class="col s12">
                                    <p class="teal-text apply_roboto" style="font-size:28px">Expected Time In: <?php echo $expected_time_in; ?> </p>
                                </div>
                                <div class="col s1">
                                    <i class="material-icons red-text text-lighten-1" style="font-size:34px">info_outline</i>
                                </div>
                                <div class="col s11">
                                    <p class="apply_roboto" style="font-size: 18px"> 
                                        You have not signed in yet. Click the Time In Button to get started.
                                    </p>
                                </div>
                            <?php }
                            else{?>
                                <div class="col s12">
                                    <p class="teal-text apply_roboto" style="font-size:28px">Expected Time Out: <?php
                                    $time_out = date('h:i:s A', time()+28800); 
                                    echo $time_out; ?> </p>
                                </div>
                                <div class="col s1">
                                    <i class="material-icons green-text text-lighten-1" style="font-size:34px">done</i>
                                </div>
                                <div class="col s11">
                                    <p class="apply_roboto" style="font-size: 18px"> 
                                        Click the Time Out Button to sign out.
                                    </p>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>                   
                
            </div>                        
            <!--Time In - Time Out-->
            
            <!--Time Record Summary-->
            <div class="row">
                <div class="card col s12 center hoverable">
                    <div class="card-content">
                        <span class="card-title">Time In - Time Out Record</span>
                        
                        <div class="divider"></div>
                        
                        <table class="highlight centered apply_roboto">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Overtime</th>
                                    <th>Undertime</th>
                                    <th>Total Hours</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <!--Put PHP Loop here-->
                                <!--Change to PHP code-->
                                <tr>
                                    <td>1</td>
                                    <td>4:20 AM</td>
                                    <td>4:20 PM</td>
                                    <td>69</td>
                                    <td>0</td>
                                    <td>420</td>
                                </tr>
                            </tbody>
                        </table>
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