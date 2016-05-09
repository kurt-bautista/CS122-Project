<?php
include('timerecord-functionality.php');
?>

<html>
    
    <head>
        <title>Time Record</title>
        
        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/jquery.mCustomScrollbar.css"/>
        
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
                    <div class="col s3" id="canvas">                       
                        <form action="" method="POST" id="time-in-form" name="time-form">
                            <input type="hidden" name="btnsubmit" value="<?php echo($_SESSION['time-status']);?>">
                        </form>
                        <button id="time-in-out-btn" class="btn-large waves-effect waves-light time_btn" onclick="timeSafety()" 
                            name="btnsubmit" value="<?php echo($_SESSION['time-status']);?>">
                            <i class="material-icons right">query_builder</i>
                                <?php echo($_SESSION['time-status']);?>
                        </button>
                    </div>
                    <div class="col s8" id="canvas">
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
                                    $time_out = date('H:i:s', time()+28800); 
                                    echo $time_out; ?> </p>
                                </div>
                                <div class="col s1">
                                    <i class="material-icons green-text text-lighten-1" style="font-size:34px">done</i>
                                </div>
                                <div class="col s11">
                                    <p class="apply_roboto" style="font-size: 18px"> 
                                        You are now signed in. Click the Time Out Button to sign out.
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
                        
                        <div class="col s12">
                            
                            <ul class="tabs row">                               
                                <?php
                                foreach ($months as $key => $value) {
                                    echo("<div class='col s1' style=''>");
                                    printf("<li class='tab'><a href='#%s'>%s</a></li>", $key, $key);
                                    echo("</div>");
                                }
                                ?>                               
                            </ul>
                        
                        <div class="divider"></div>
                        
                        <?php foreach ($months as $key => $value) {?>
                            <div class="col s12" id="<?php echo($key);?>">
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
                                    <?php
                                    $getWorkdays->bind_param('ii', $months[$key], $empId);
                                    $getWorkdays->execute();
                                    $result = $getWorkdays->get_result();
                                    $workdaysTable = $result->fetch_all(MYSQLI_ASSOC);
                                    
                                    foreach($workdaysTable as $row)
                                    {
                                    echo "<tr>";
                                        echo "<td>".$row['Date']."</td>";
                                        echo "<td>".$row['Time In']."</td>";
                                        echo "<td>".$row['Time Out']."</td>";
                                        echo "<td>".$row['Overtime']."</td>";
                                        echo "<td>".$row['Undertime']."</td>";
                                        echo "<td>".$row['Total Hours']."</td>";
                                    echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        <?php }?>
                        
                    </div>
                </div>
            </div>
            <!--Time Record Summary-->
            
            <!--Warning Modal-->
            <div class="modal" id="warning-modal">
                <div class="modal-content center">
                    <p class="apply_roboto teal-text" style="font-size:36px">Are you sure you want to time out?</p>
                    <p class="apply_roboto" style="font-size:24px">This may cause undertime deductions towards your salary
                    </p>
                    <p class="apply_roboto" style="font-size:24px">Warning: You will not be able to time in again within the day
                    </p>
                    <div class="divider"></div>
                    <p>
                    <button class="btn-large waves-effect waves-light" onclick="modalTimeOut()">Time Out</button>
                    </p>
                </div>               
            </div>
            <!--Warning Modal-->
            
            <!--Time In Modal-->
            <div class="modal" id="time-in-modal">
                <div class="modal-content center">
                    <p class="apply_roboto teal-text" style="font-size:36px">You have already timed in today.</p>
                    <p class="apply_roboto" style="font-size:24px">Please wait until the next day to time in again
                    </p>
                </div>               
            </div>
            <!--Time In Modal-->
            
        </div>
       
       <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
        
        <script>       
                    
            $(document).ready(function(){
               $(".button-collapse").sideNav();
               
               $('ul.tabs').tabs();
               
               $("#tab-bar").mCustomScrollbar({
                   axis: "x",
                   theme: "minmal-dark"
               });                                                     
            });
            
            function appendTime(x){
                   return (x < 10) ? "0" + x : x;
               }
               
            function getCurrentTime(){
                var currentTime = new Date();
                
                var year = currentTime.getFullYear();
                var month = appendTime(currentTime.getMonth() + 1);
                var day = appendTime(currentTime.getDate());
                
                var hours = appendTime(currentTime.getHours());
                var minutes = appendTime(currentTime.getMinutes());
                var seconds = appendTime(currentTime.getSeconds());
                
                var timeNow = year + "/" + month + "/" + day + " " + hours + ":" + minutes + ":" + seconds;               
                return timeNow;  
            } 
            
            function timeSafety(){
                var timeStatus = "<?php echo($_SESSION['time-status']);?>";
                var expectedTimeOut = "<?php $time_out = date('Y/m/d H:i:s', time()+28800); 
                                            echo $time_out; ?>";
                             
                var a = "<?php echo date('Y-m-d'); ?>" == "<?php if(!$workdaysTable){ echo '0000-00-00'; } else{ echo $workdaysTable[0][0]; }?>";
                
                if(timeStatus == "Time In"){
                    if(a)
                    {
                        $('#time-in-modal').openModal();
                    }
                    else
                    {                  
                        document.forms['time-in-form'].submit();
                    }
                }
                else{
                    if(getCurrentTime() < expectedTimeOut){                       
                        $('#warning-modal').openModal();
                    }
                    else{                       
                        document.forms['time-in-form'].submit();
                    }
                }
            }
            
            function modalTimeOut(){
                 document.forms['time-in-form'].submit();
            }
        </script>
        
    </body>
    
</html>