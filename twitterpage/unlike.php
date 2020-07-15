<?php
 session_start();
 require_once('dbconnect.php');
 
 if(!isset($_GET['var'])){
	 exit;
 }
 $getvar=$_GET['var'];
 $array=explode("A",$getvar);
 $unlikee_id = $array[1];
 $unliker_id = $_SESSION['username'];
 
 $sql = "select likes from likes where likee='".$unlikee_id."' and liker='".$unliker_id."' and tweetid='".$array[0]."';" or die(mysqli_error());
 $a=mysqli_query($conn,$sql);
 $likedec =  mysqli_fetch_object($a)->likes;
 $minus = $likedec -1;
	$sql = mysqli_query($conn,"delete from likes where likee='".$unlikee_id."' and liker='".$unliker_id."' and tweetid='".$array[0]."';") or die(mysqli_error());
 header("location: home.php");

