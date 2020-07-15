<?php
 session_start();
 require_once('dbconnect.php');
 
 if(!isset($_GET['id'])){
	 exit;
 }
 
 $user_id = $_GET['id'];
 $follower_id = $_SESSION['username'];
 
 mysqli_query($conn,"delete from following where user='".$user_id."' and follower='".$follower_id."';") or die(mysqli_error($conn));
 header("location:userlist.php");
