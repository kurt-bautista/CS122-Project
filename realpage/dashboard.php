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
        <div id="main" class="container">
            <h1> Welcome : <?php echo $login_session; ?> </h1>
            <form action="logout.php">
                <button id="logout_button" class="btn waves-effect waves-light" href="logout.php">Logout</button>
            </form>
        </div>
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
    
</html>