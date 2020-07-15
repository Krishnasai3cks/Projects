<?php
 session_start();
 require_once('dbconnect.php');
 
 if(!isset($_GET['var'])){
	 exit;
 }
 $getvar=$_GET['var'];
 $array=explode("A",$getvar);
 $likee_id = $array[1];
 $liker_id = $_SESSION['username'];
 
 $sql = "select likes from likes where likee='".$likee_id."' and liker='".$liker_id."' and tweetid='".$array[0]."';";
 $a=mysqli_query($conn,$sql);
 if(mysqli_fetch_object($a) != NULL){
  $likeinc =  mysqli_fetch_object($a)->likes;
 } 
else{ $likeinc = 0;} 
	$plus = $likeinc + 1;
	$sql = "insert into likes values('".$likee_id."','".$liker_id."','".$array[0]."','".$plus."');";
	 $a=mysqli_query($conn,$sql);
  header("location: home.php");

