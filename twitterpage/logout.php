<?php 
 session_start();
 if(isset($_SESSION['user'])){
	header("Location: index.php");
 }
 
 unset($_SESSION['username']);
 session_unset();
 session_destroy();
 header("Location: index.php"); 
 exit();
 