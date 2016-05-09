<?php
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
session_start();
if(session_destroy()){
    header("location: index.php");
}
?>