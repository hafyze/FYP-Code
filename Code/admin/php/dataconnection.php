<?php

$host= "localhost";
$user= "root";
$password = "";
$dbname = "restaurant";

$connection = new mysqli($host, $user, $password, $dbname);

if (!$connection) {

    echo "Connection failed!";

}