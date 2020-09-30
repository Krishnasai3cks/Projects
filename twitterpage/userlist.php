<?php
 session_start();
 require_once('dbconnect.php');
 
 if(!isset($_SESSION['username'])){
	header('Location: index.php');
 }
 
 $a = mysqli_query($conn,"select * from users where id=".$_SESSION['username'].";");
 $userData = mysqli_fetch_object($a);
 function get_user_list($conn){
	$id = $_SESSION['username'];
       $queryString = "select * from users;";
       $result = mysqli_query($conn,$queryString) or die(mysqli_error($db_connection));
       while($eachcomment = mysqli_fetch_assoc($result)) {
        $array[] = $eachcomment;
       }
	return $array;
 }
?>
<html><head> <title> Twitter Clone </title> 
<style>
 .userlistbig{
	background-color: pink;
	min-height: 100%;

margin: auto;
width: 50%;
border: 3px solid black;
padding: 10px;
	 display: flex;
	 flex-direction: column;
	 justify-content: center;
	 align-items: center;
 }
 .followers{
	padding: 0;
		margin: 5px;
		border: 2px solid black;
		width: 100%;
		text-align: center;
 }
 a{
	text-decoration: none;
    font-size: 20px;
 }
</style>
</head>
<body>
 <div class="userlistbig">
 <?php include('header.php'); ?>
 <div class="followers">
  <p> <b> List of users: </b> </p>
  <?php  
    
	 $user_list = get_user_list($conn);
	 foreach($user_list as $user){
		 
		 $auid = $user['id'];
		 echo '[<a href="profile.php?id=' . $auid . '">'.$user['username'].'</a>]';
		 $res= mysqli_query($conn,"select exists(select * from following where user='".$auid."' and follower='".$_SESSION['username']."') as a") or die(mysqli_error($conn));
		 $b=mysqli_fetch_object($res)->a;
		 if ($auid != $_SESSION['username'])
		 {
			if($b == 0)
		      echo '[<a href="follow.php?id=' .$auid . '">Follow</a>]';
	        if($b != 0) 
		    echo '[<a href="unfollow.php?id=' .$auid . '">Unfollow</a>]';
		 }
		 echo '<hr>';
	 }
	
	
 ?>
 </div>
 </div>
</body>
</html>