<?php
 session_start();
 require_once("dbconnect.php"); 
 if (isset($_session['username'])){
	 header('Location: home.php');
 }
 if(isset($_POST['username']) && isset($_POST['password'])){
	 $que="select exists(select * from users where username='".$_POST['username']."');";
	 $res=mysqli_query($conn,$que);
	 if(!$res){ 
	  header('Location:index.php');
	 } 
	 $username = $_POST['username'];
	 $password = $_POST['password'];
	 $sql = "insert into users(username,password) values('".$username."','".$password."');";
	 $a=mysqli_query($conn,$sql);
	 $result=mysqli_fetch_object($a);
	 
     header('Location: index.php');
		 
	 
 }
?>
<html>
<head>
 <title> Twitter clone </title>
 </head>
 <body>
  <form method="post" action ="register.php" >
  <fieldset> 
   <label for="username" > username </label> <input type="text" name="username" /><br>
   <label for="password"> password </label> <input type="password" name="password" /> <br>
   <input type="submit" value="sign up">
  </fieldset>
  </form>
  <a href="index.php">Already have an account? Login here!.</a>
 </body>
 </html>