<?php
session_start();
unset($_SESSION['user_gdp']);
header("location: http://www.gdp.com.ve");

?>