<?php 
session_start();
$_SESSION['user_login']=FALSE;
header('location:login.php');


?>