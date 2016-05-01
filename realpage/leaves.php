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
                    <li><a href="dashboard.php">[Company Logo]</a></li>
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
            <!--Column Guide-->
            
            <div class="row">
                <!--Remaining Leaves Card-->
                <div class="card medium col s4  hoverable">
                    <div class="card-content center">
                        <span class="card-title" style="font-size:26px">Remaining Leaves</span>
                        <p class="apply_roboto"></p>
                        <!--<p class="appl_roboto teal-text text-accent-4" style="font-size:65px">420</p>--> <!--Change this to PHP [Query SQL] -->
                        <div class="circle" id="leaves_circle"></div>
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
                
                <!--Leaves Summary-->
                <div class="card leave_summary_card col s7 offset-s1 hoverable">
                    <div class="card-content center">
                        <span class="card-title">Leaves Summary</span>
                    </div>
                </div>
                
            </div>
            
        </div>
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script src="js/cirlces.js"></script>
        <script src="js/cirlces.min.js"></script>
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
                    radius:              60,
                    value:               43,
                    maxValue:            100,
                    width:               10,
                    text:                function(value){return value;},
                    colors:              ['#D3B6C6', '#4B253A'],
                    duration:            400,
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