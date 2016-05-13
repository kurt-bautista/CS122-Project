<?php
include('leaves_functionality.php');
?>

<html>

    <head>
        <title>Leaves</title>

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
                    <li class="active"><a href="leaves.php">Leaves</a></li>
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
            <div class="row">

                <div class="col s4">

                <!--Remaining Leaves Card-->
                <div class="card col s12 hoverable">
                    <div class="card-content center">
                        <span class="card-title" style="font-size:26px">Remaining Leaves</span>

                        <div id="canvas">
                            <div class="circle" id="leaves_circle"></div>
                        </div>

                        <p class="apply_roboto" style="font-size:18px">Total Leaves: <?php echo $allotted_leaves; ?></p>
                    </div>

                    <!--Leave Request Modal-->
                    <div id="leave-request-modal" class="modal modal-fixed-footer">
                        <div class="modal-content">

                        <span class="apply_roboto" style="font-size:24px">Request Leave
                            <i class="material-icons right modal-action modal-close waves-effect waves-green">close</i>
                        </span>
                        <form action="" method="POST">
                            <div class="input-field col s6">
                                <input name="start_date" id="start_date" type="date" class="datepicker">
                                <label for="start_date">Start Date</label>
                            </div>

                            <div class="input-field col s6">
                                <input name="end_date" id="end_date" type="date" class="datepicker">
                                <label for="end_date">End Date</label>
                            </div>

                            <div class="input-field col s12">
                                <textarea id="leave_reason_text" name="leave_reason_text" class="materialize-textarea"></textarea>
                                <label for="leave_reason_text">Reason for Leave</label>
                            </div>

                            <div class="row">
                            <p class="col s2">
                                <input class="with-gap" name="leave-type" type="radio" id="sick" checked value="sick">
                                <label for="sick">Sick</label>
                            </p>
                            <p class="col s2" >
                                <input class="with-gap" name="leave-type" type="radio" id="vacation" value="vacation">
                                <label for="vacation">Vacation</label>
                            </p>
                            <p class="col s3" >
                                <input class="with-gap" name="leave-type" type="radio" id="special-privilege" value="special-privilege">
                                <label for="special-privilege">Special Privilege</label>
                            </p>
                            <p class="col s2" >
                                <input class="with-gap" name="leave-type" type="radio" id="maternity" value="maternity">
                                <label for="maternity">Maternity</label>
                            </p>
                            <p class="col s2" >
                                <input class="with-gap" name="leave-type" type="radio" id="paternity" value="paternity">
                                <label for="paternity">Paternity</label>
                            </p>
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn waves-effect waves-light" type="submit" name="submit" value="request_leave">Submit</button>
                        </form>
                        </div>
                    </div>
                    <!--Leaves Request Modal-->

                    <div class="card-action center">
                      <?php if ($error != ""): ?>
                        <p class="apply_roboto red-text"><?php echo($error);?></p>
                      <?php endif; ?>
                        <a class="modal-trigger clickable_text teal-text" href="#leave-request-modal">Request Leave</a>
                    </div>
                </div>
                <!--Remaining Leaves Card-->

                <!--Leave Approval Card-->
                <div class="card right col s12 hoverable">
                    <div class="card-content center">
                        <span class="card-title">Pending Approval</span>

                        <?php if ($number_of_days < 1): ?>
                          <h1 class="">No current pending leaves</h1>
                        <?php else: ?>
                          <h1 class=""><?php echo $number_of_days ?> Day(s)</h1>
                        <?php endif; ?>

                        <?php if ($start_date): ?>
                            <p class="apply_roboto teal-text" style="font-size:18px"><?php echo date('F d, Y', strtotime($start_date))." - ".date('F d, Y', strtotime($end_date)); ?></p>
                        <?php endif; ?>

                    </div>

                    <div class="card-reveal blue-grey darken-4 white-text">
                        <span class="card-title">Approved Leave<i class="material-icons right">close</i></span>

                        <?php if(isset($approved_leave_start_date)): ?>
                            <h1 class=" center "><?php echo $approved_leave_duration ?> Day(s)</h1>
                            <p class="apply_roboto teal-text center" style="font-size:18px"><?php echo $approved_leave_start_date." - ".$approved_leave_end_date; ?></p>
                        <?php else: ?>
                            <h1 class=" center ">No upcoming leaves</h1>
                            <p class="apply_roboto teal-text center" style="font-size:18px"></p>
                        <?php endif; ?>
                    </div>

                    <div class="card-action center">
                        <a class="activator clickable_text teal-text">Approved Leaves</a>
                    </div>
                </div>
                <!--Leave Approval Card-->

                </div>

                <!--Leaves Summary-->
                <div class="card leave_summary_card col s7 offset-s1 hoverable">

                    <div class="card-content center">
                        <span class="card-title">Leaves Summary</span>
                    </div>

                    <div class="row center" id="leave-circle1">
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary1"></div>
                            <p class="apply_roboto" style="font-size: 18px">Leaves Taken</p>
                        </div>
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary2"></div>
                            <p class="apply_roboto" style="font-size: 18px">Sick Leave</p>
                        </div>
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary3"></div>
                            <p class="apply_roboto" style="font-size: 18px">Vacation Leave</p>
                        </div>
                    </div>

                    <div class="row center" id="leave-circle2">
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary4"></div>
                            <p class="apply_roboto" style="font-size: 18px">Special Privileges</p>
                        </div>
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary5"></div>
                            <p class="apply_roboto" style="font-size: 18px">Maternity Leave</p>
                        </div>
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary6"></div>
                            <p class="apply_roboto" style="font-size: 18px">Paternity Leave</p>
                        </div>
                    </div>

                    <ul class="tabs">
                        <li class="tab col s6"><a class="active teal-text" href="#leave-circle1"><i class="material-icons flip">play_arrow</i></a></li>
                        <li class="tab col s6"><a class="teal-text" href="#leave-circle2"><i class="material-icons">play_arrow</i></a></li>
                        <div class="indicator teal" style="z-index:1"></div>
                    </ul>

                    <div class="divider"></div>
                    <div class="row center">

                        <table class="highlight centered apply_roboto">
                            <thead>
                                <tr>
                                    <th>Duration</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if($leaves_count > 0): ?>
                                    <?php for($i = 0; $i < $leaves_count; $i++){ ?>
                                    <tr>
                                        <td><?php echo $all_leaves[$i][0]; ?> Day(s)</td>
                                        <td><?php echo $all_leaves[$i][1]; ?></td>
                                        <td><?php echo $all_leaves[$i][2]; ?></td>
                                    </tr>
                                    <?php }; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                </div>
                <!--Leave Summary-->

            </div>

        </div>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/circles.min.js"></script>


        <script>
            /**
            $(document).ready(function(){
                $('#date_picker').picakdate({
                    selectMonths: true,
                    selectYears: 15
                });
            });
            */

            $(document).ready(function(){
                $('.datepicker').pickadate({
                    selectMonths: true,
                    selectYears: 15,
                    format: 'yyyy/mm/dd'
                });

               $(".button-collapse").sideNav();

               $('select').material_select();

               $('.modal-trigger').leanModal();

               var myCircle = Circles.create({
                    id:                  'leaves_circle',
                    radius:              70,
                    value:               parseInt("<?php echo $remaining_leaves ?>"),
                    maxValue:            parseInt("<?php echo $allotted_leaves ?>"),
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

               var circles = [];

               //Array of leave values
               var circle_values = [];
               circle_values.push(<?php echo $leaves_taken; ?>);
               circle_values.push(<?php echo $sick_leaves; ?>);
               circle_values.push(<?php echo $vacation_leaves; ?>);
               circle_values.push(<?php echo $special_privilege_leaves; ?>);
               circle_values.push(<?php echo $maternity_leaves; ?>);
               circle_values.push(<?php echo $paternity_leaves; ?>);

               for (var i = 1; i <= 6; i++){
                   var circle = document.getElementById('leaves_summary' + i);

                   circles.push(Circles.create({
                        id:                  circle.id,
                        radius:              45,
                        value:               circle_values[i-1],
                        maxValue:            parseInt("<?php echo $allotted_leaves ?>"),
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
                   }));
               }
            });

        </script>

    </body>

</html>
