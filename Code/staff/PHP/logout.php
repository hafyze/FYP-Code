<?php
    session_start();
    session_destroy();
    
    header("Location: ../html/stafflogin.html");
    exit;
?>
