<?php

$host= "localhost";
$user= "root";
$password = "";
$dbname = "restaurant";

$connection = new mysqli($host, $user, $password, $dbname);

if (!$connection) {

    die("ERROR: Could not connect. " . $mysqli->connect_error);

}