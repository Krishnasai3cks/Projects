<?php
 session_start();
 require_once('dbconnect.php');
 
 if(!isset($_SESSION['username'])){
	header('Location: index.php');
 }
 if(!isset($_GET['id'])){
	header('Location: index.php');
 }

 $a = mysqli_query($conn,"select * from users where id=".$_SESSION['username'].";");
 $userData = mysqli_fetch_object($a);
 $profile_id = $_SESSION['username'];
 $j = mysqli_query($conn,"select * from users where id=".$profile_id."");
 $profileData = mysqli_fetch_object($j);
 function get_recent_tweets($conn){
	$id = $_GET['id'];
       $queryString = "select * from tweets where authorId=".$id.";";
       $result = mysqli_query($conn,$queryString) or die(mysqli_error($db_connection));
       while($eachcomment = mysqli_fetch_assoc($result)) {
        $array[] = $eachcomment;
       }
	return $array;
 }
?>
<html><head> <title> Twitter Clone </title> </head>
<body>
 <?php include('header.php'); ?>
 <div>
  <?php  
    $a=mysqli_query($conn,"select exists(select * from tweets where authorname='".$userData->username."') as 'a'") or die(mysqli_error($conn));
	$a=mysqli_fetch_object($a);
    if($a->a == 1){
	 $recent_tweets = get_recent_tweets($conn);
	 foreach($recent_tweets as $tweet){
		 echo '<p><a href="profile.php?id=' . $tweet['authorId'] . '">' .$tweet['authorname'] .'</a></p>';
		 echo '<p>' . $tweet['body'] . '</p>';
		 echo '<p>' . $tweet['created']. '</p>';
		 echo '<hr>';
	 }
	}
	else
	{
		echo "<br> <br> <br> You have no tweets to show here";
	}
	
 ?>
 </div>
</body>
</html>
