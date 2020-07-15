<?php
 session_start();
 require_once("dbconnect.php"); 
 if (isset($_SESSION['username'])){
	 header('Location: home.php');
 }
 if(isset($_POST['username']) && isset($_POST['password'])){
	 $username = $_POST['username'];
	 $password = $_POST['password'];
	 $sql = "select exists(select id from users where username='".$username."') as a;";
	 $a=mysqli_query($conn,$sql);
	 if(mysqli_fetch_object($a)->a == 0 and isset($_POST['username'])){ 
	    echo "username/password is wrong or user does not exists ";
		echo "<br> <br> <br> register your account first!";
	 } 
	 else{
		 
		 $sql = "select id from users where username='".$username."' and password='".$password."';";
		 $stmt = mysqli_query($conn,$sql);
		 $g= mysqli_fetch_object($stmt);
		 $_SESSION['username']=$g->id;
		 header('Location: home.php');
		 
	 }
		
	 
 }
?>
<html>
<head>
 <title> Twitter clone </title>
</head>
 <body>
  <form method="post" action ="index.php" >
  <fieldset> 
   <label for="username" > username: 
   </label> <input type="text" name="username" /><br>
   <label for="password"> password :
   </label> <input type="password" name="password" /> <br>
   <input type="submit" value="login" />
  </fieldset>
  </form>
  <a href="register.php">No account? register here!
  </a>
 </body>
</html>