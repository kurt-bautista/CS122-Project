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
                    <li><a href="dashboard.php">[Company Logo]</a></li>
                    <li class="active"><a href="timerecord.php">Time Record</a></li>
                    <li><a href="leaves.php">Leaves</a></li>
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