<html>
    
    <head>
        <title>Leaves</title>
        
        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    
    <body>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/picker.js"></script>
        <script type="text/javascript" src="js/picker.date.js"></script>
        
        <nav class="blue-grey darken-4">
            <div class="nav-wrapper">
                <ul id="nav-mobile" class="right hide-on-small-only">
                    <li><a href="dashboard.php">Time Record</a></li>
                    <li class="active"><a href="leaves.php">Leaves</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <div id="main" class="container">
            
            <div class="row">
                <h1 class="col s5 offset-s7 center">Request Leave</h1>
            </div>
            
            <div class="row">
                <div class="input-field col s5 offset-s7">
                    <script type="text/javascript">
                        $(document).ready(function(){
                            window.picker = 
                            $('.datepicker').pickdate({
                                selectMonths: true,
                                selectYears: 15 
                            });
                        });
                    </script>
                    <input id="leave_date" name="leave_date" type="date" class="datepicker">
                </div>
            </div>
            
            <div class="row">
                <div class="input-field col s5 offset-s7">
                    <textarea id="leave_reason_text" class="materialize-textarea"></textarea>
                    <label for="leave_reason_text">Reason for Leave</label>
                </div>
            </div>
            
        </div>
        
    </body>
    
</html>