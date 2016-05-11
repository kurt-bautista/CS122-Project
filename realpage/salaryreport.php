<?php
include('salaryreport_functionality.php');
?>

<html>

    <head>
        <title>Salary Report</title>

        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="css/chartist.min"/>

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
                
                <!--Salary Card-->
                <div class="card col s4 center hoverable salary_card">
                    <div class="card-content">
                        <span class="card-title">Expected Salary</span>                       
                        <h1 id="expected-salary" class="teal-text apply_roboto"></h1>
                        
                        <div class="divider"></div>
                        
                        <div class="row apply_roboto" style="font-size: 26px">
                            <p class="salary_padding" style="padding-top: 20px">
                                <span class="tooltipped" data-position="left" data-delay="40" data-tooltip="Base Salary">
                                <i class="material-icons">trending_flat</i><span id="base-salary" class="green-text text-lighten-1"></span>
                                </span>
                            </p>
                            <p class="salary_padding" style="padding-top: 20px">
                                <span class="tooltipped" data-position="left" data-delay="40" data-tooltip="Overtime Pay">
                                <i class="material-icons">trending_up</i><span id="overtime-pay" class="green-text text-lighten-1"></span>
                                </span>
                            </p>
                            <p class="salary_padding" style="padding-top: 20px">
                                <span class="tooltipped" data-position="left" data-delay="40" data-tooltip="Undertime Deductions">
                                <i class="material-icons">trending_down</i><span id="undertime-deductions" class="red-text text-lighten-1"></span>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <!--Salary Card-->
                
                <!--Graph-->
                <div class="card col s7 offset-s1 center hoverable">
                    <div class="card-content">
                        <span class="card-title">Salary Record</span>
                        
                        <table class="highlight centered responsive-table">
                            <thead>
                                <tr>
                                    <th data-field="date">Date</th>
                                    <th data-field="overtime">Overtime Pay</th>
                                    <th data-field="undertime">Undertime Deduction</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php foreach ($all_workdays as $workday_array) {?>
                                    <tr>
                                        <td><?php echo($workday_array[0]);?></td>
                                        <td>
                                            <?php if($workday_array[1] == 'overtime'){
                                                echo($workday_array[2]);
                                            }else{
                                                echo('0');
                                            }?>
                                        </td>
                                        <td>
                                            <?php if($workday_array[1] == 'undertime'){
                                                echo($workday_array[2]);
                                            }else{
                                                echo('0');
                                            }?>
                                        </td>
                                    </tr>
                                <?php }?>                               
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Graph-->             
            </div>

        </div>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>       
        <script type="text/javascript" src="js/countUp.js"></script>
        <script type="text/javascript" src="js/chartist.min.js"></script>
        <script type="text/javascript" src="js/chartist-plugin-threshold.min.js"></script>

        <script>
            $(document).ready(function(){
               $(".button-collapse").sideNav(); 
               
               var salaryAnimation = new CountUp(document.getElementById("expected-salary").id, 0, <?php echo($expected_salary);?>);
               salaryAnimation.start();
               var baseAnimation = new CountUp(document.getElementById("base-salary").id, 0, <?php echo($base_salary);?>);
               baseAnimation.start();
               var overtimeAnimation = new CountUp(document.getElementById("overtime-pay").id, 0, <?php echo($total_overtime_pay);?>);
               overtimeAnimation.start();
               var undertimeAnimation = new CountUp(document.getElementById("undertime-deductions").id, 0, <?php echo($total_undertime_deduction);?>);
               undertimeAnimation.start();
               
               
               var graphLabel = [];
               var graphSeries = [];
               <?php 
               $counter = 0;
               for($i = 1; $i <= 31; $i++){?>                 
                    graphLabel.push(<?php echo($i);?>);                                 
               <?php               
                    if($workdays_count == 0){?>
                        graphSeries.push(<?php echo($hourly_rate * 8);?>);
               <?php }
                    else {
                        if($all_workdays[$counter][0] == $i){?>
                            graphSeries.push(<?php echo($all_workdays[$counter][2]);?>);
                            <?php $counter += 1;
                        }
                        else{?>
                            graphSeries.push(<?php echo($hourly_rate * 8);?>);
                        <?php }
                    }
               }?>                                      
               
               new Chartist.Line('.ct-chart', {
                    labels: graphLabel,
                    series: graphSeries
                    }, {
                    showArea: true,
                    axisY: {
                        onlyInteger: true
                    },
                    plugins: [
                        Chartist.plugins.ctThreshold({
                        threshold: <?php echo($hourly_rate * 8);?>
                        })
                    ]
                });
            });
        </script>

    </body>

</html>
