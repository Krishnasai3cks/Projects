<?php
 session_start();
 require_once('dbconnect.php');
 
 if(!isset($_GET['id'])){
	 exit;
 }
 
 $user_id = $_GET['id'];
 $follower_id = $_SESSION['username'];
 
 $sql = "insert into following(user,follower) values('".$user_id."','".$follower_id."');";
	 $a=mysqli_query($conn,$sql);
	 $result=mysqli_fetch_object($a);
 header("location:userlist.php");
