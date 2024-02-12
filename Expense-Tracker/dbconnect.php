<?php
$server="localhost";
$user="root";
$pwd="";
$dbname="testname";
$conn= new mysqli($server,$user,$pwd,$dbname);
if($conn->connect_error)
 die("connection error ".$conn->connect_error);
?>