<?php
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
    
    <body>
        <nav class="blue-grey darken-4">
            <div class="nav-wrapper">
                <ul id="nav-mobile" class="right hide-on-small-only">
                    <li class="active"><a href="dashboard.php">Dashboard</a></li>
                    <!--<li><a href="leaves.php">Leaves</a></li>-->
                    <li><a href="account.php">Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <div id="main" class="container">
            <h1 class="center"> Welcome <?php echo $first_name; ?> </h1>
            
        </div>
        
        <div class="row">
            
            <!--Salary Report Card-->
            <div class="card medium col s3 hoverable">
                <div class="card-content center">
                    <span class="card-title">Salary Report</span>
                </div>
            </div>
            
            <!--Time In Time Out Card-->
            <div class="card medium col s3 offset-s1 hoverable">
                <div class="card-content center">
                    <span class="card-title">Time Record</span>
                </div>
            </div>
            
            <!--Leaves Card-->
            <div class="card medium col s3 offset-s1 hoverable">
                <div class="card-content center">
                    <span class="card-title" style="font-size:26px">Remaining Leaves</span>
                    <p class="apply_roboto"></p>
                    <p class="appl_roboto teal-text text-accent-4" style="font-size:65px">420</p> <!--Change this to PHP [Query SQL] -->
                </div>
                
                <div class="card-reveal blue-grey darken-4 white-text">
                    <span class="card-title">Request Leave<i class="material-icons right">close</i></span>
                    <form action="" method="POST">
                        <div class="input-field">
                            <input name="date_picker" id="date_picker" type="date" class="datepicker">
                        </div>      
                        
                        <div class="input-field">
                            <textarea id="leave_reason_text" name="leave_reason_text" class="materialize-textarea white-text"></textarea>
                            <label for="leave_reason_text">Reason for Leave</label>
                        </div>                      
                    </form>
                </div>
                
                <div class="card-action center">
                    <button class="activator btn waves-effect waves-light">Request Leave</button>
                </div>
            </div>
            
        </div>
            
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/picker.js"></script>
        <script type="text/javascript" src="js/picker.date.js"></script>
        
        <script>
            $(document).ready(function(){
                $('#date_picker').pickdate({
                    selectMonths: true,
                    selectYears: 15
                });
            });
        </script>
    </body>
    
</html>