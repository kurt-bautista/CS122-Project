<?php
include('account_functionality.php');
?>

<html>

    <head>
        <title>Account</title>

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
                    <li><a href="leaves.php">Leaves</a></li>
                    <li><a href="salaryreport.php">Salary Report</a></li>

                    <?php if($_SESSION['employee_type'] == 'manager'){?>
                    <li><a href="manager.php">Manager</a></li>
                    <?php } ?>

                    <li class="active"><a href="account.php">Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        <!--Navbar-->

        <div id="main" class="center_container">

            <div class="row">
                <!--Account Card-->
                <div class="card col s4 center hoverable">
                    <div class="card-content">
                        <p><img src="img/employee.jpg" class="circle profile_pic"></p>
                        <span class="card-title"><?php echo($Fname); echo($Lname);?></span>

                        <div class="divider" style="margin-top:25px; margin-bottom:25px;"></div>

                        <span style="font-size:20px">
                        <p class="apply_roboto">Username: <span class="teal-text"><?php echo($user_login);?></span></p>
                        <p class="apply_roboto">Account Type: <span class="teal-text"><?php echo($type);?></span></p>
                        </span>
                    </div>
                </div>
                <!--Account Card-->

                <!--Change Account Settings Card-->
                <div class="card col s7 offset-s1 hoverable">
                    <div class="card-content">
                        <form action="" method="POST">

                            <div class="input-field col s12">
                                <i class="material-icons prefix">vpn_key</i>
                                <input id="current_pass" name="current_pass" type="password" class="validate">
                                <label for="current_pass">Current Password</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">vpn_key</i>
                                <input id="new_pass" name="new_pass" type="password" class="validate">
                                <label for="new_pass">New Password</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">vpn_key</i>
                                <input id="confirm_new_pass" name="confirm_new_pass" type="password" class="validate">
                                <label for="confirm_new_pass">Confirm New Password</label>

                                <span id="login_error" class="red-text text-darken-1"><?php echo $error; ?></span>
                                
                                <div class="divider" style="margin-top:20px; margin-bottom:20px;"></div>
                            </div>
                            <div class="center">                               
                                <button class="btn waves-effect waves-light" type="submit" name="submit" value="account_change">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--Change Account Settings Card-->

            </div>

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
