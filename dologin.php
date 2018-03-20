<?php
session_start();
$user=$_GET['user'];
$user=base64_decode($user);
$user=json_decode($user);
$_SESSION['user_gdp']=get_object_vars($user);
header("location: index.php");
?>