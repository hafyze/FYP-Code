<?php
    session_start();
    session_destroy();
    header("../html/login.html");
    exit;
?>