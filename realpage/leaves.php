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
                    <li><a href="account.php">Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        <!--Navbar-->

        <div id="main" class="center_container">

            <!--Column Guide-->
            <!--
            <div class="row">
                <div class="col s1 teal">1</div>
                <div class="col s1 teal accent-3">2</div>
                <div class="col s1 teal">3</div>
                <div class="col s1 teal accent-3">4</div>
                <div class="col s1 teal">5</div>
                <div class="col s1 teal accent-3">6</div>
                <div class="col s1 teal">7</div>
                <div class="col s1 teal accent-3">8</div>
                <div class="col s1 teal">9</div>
                <div class="col s1 teal accent-3">10</div>
                <div class="col s1 teal">11</div>
                <div class="col s1 teal accent-3">12</div>
            </div>
            -->
            <!--Column Guide-->

            <div class="row">

                <div class="col s4">

                <!--Remaining Leaves Card-->
                <div class="card col s12 hoverable">
                    <div class="card-content center">
                        <span class="card-title" style="font-size:26px">Remaining Leaves</span>

                        <div id="canvas">
                            <div class="circle" id="leaves_circle"></div>
                        </div>

                        <p class="apply_roboto" style="font-size:18px">Total Leaves: 420</p>
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


                            <button class="btn waves-effect waves-light" type="submit" name="submit" value="request_leave">Submit</button>
                        </form>
                    </div>

                    <div class="card-action center">
                        <a class="activator clickable_text teal-text">Request Leave</a>
                    </div>
                </div>
                <!--Remaining Leaves Card-->

                <!--Leave Approval Card-->
                <div class="card right col s12 hoverable">
                    <div class="card-content center">
                        <span class="card-title">Pending Approval</span>
                        <!--Change to PHP code-->
                        <h1 class="">2 Days</h1>
                        <p class="apply_roboto teal-text" style="font-size:18px">April 20, 2017 - April 21, 2017</p>
                    </div>

                    <div class="card-reveal blue-grey darken-4 white-text">
                        <span class="card-title">Approved Leave<i class="material-icons right">close</i></span>
                        <!--Change to PHP code-->
                        <h1 class=" center ">3 Days</h1>
                        <p class="apply_roboto teal-text center" style="font-size:18px">August 19, 2016 - April 22, 2016</p>
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

                    <div class="row center">
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary1"></div>
                            <p class="apply_roboto" style="font-size: 18px">Leaves Taken</p>
                        </div>
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary2"></div>
                            <p class="apply_roboto" style="font-size: 18px">Paid Leave</p>
                        </div>
                        <div class="col s4" id="canvas">
                            <div class="circle" id="leaves_summary3"></div>
                            <p class="apply_roboto" style="font-size: 18px">Sick Leave</p>
                        </div>
                    </div>

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
                                <!--Put PHP loop here-->
                                <tr>
                                    <td>1</td>
                                    <td>April 20, 2016</td>
                                    <td>Sick Leave</td>
                                </tr>
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
        <script type="text/javascript" src="js/picker.js"></script>
        <script type="text/javascript" src="js/picker.date.js"></script>

        <script>
            /**
            $(document).ready(function(){
                $('#date_picker').pickdate({
                    selectMonths: true,
                    selectYears: 15
                });
            });
            */

            $(document).ready(function(){
               $(".button-collapse").sideNav();

               var myCircle = Circles.create({
                    id:                  'leaves_circle',
                    radius:              70,
                    value:               parseInt("<?php echo $remaining_leaves ?>"),
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

               var circles = [];

               //Array of leave values
               var circle_values = [];
               circle_values.push(<?php echo $leaves_taken; ?>);
               circle_values.push(<?php echo $maternity_leaves; ?>);
               circle_values.push(<?php echo $sick_leaves; ?>);

               for (var i = 1; i <= 3; i++){
                   var circle = document.getElementById('leaves_summary' + i);

                   circles.push(Circles.create({
                        id:                  circle.id,
                        radius:              45,
                        value:               circle_values[i-1],
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
                   }));
               }

            });
        </script>

    </body>

</html>
