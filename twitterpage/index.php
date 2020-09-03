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
 <style>
 a{
	 text-decoration: none;
	 width: 100px;
	 text-align: center;
	 font-size: 20px;
	 background-color: #C3423F;
	 color: white;
	 margin-top:  10px;
 }
  .form-div{
	  display: flex;
	  flex-direction: column;
	  height: 100vh;
	  justify-content: center;
	  align-items: center;
	  background-color: #404E4D;
  }
  form{
	  background-color: #07004D;
	  color: #F1FEC6;
	  border: 4px solid blue;
	  font: arial;
  }
  .login{
	  margin-top: 10px;
	  width: 100%;
	  height: 30px;
	  color: white;
	  font-size: 20px;
	  background-color: red; 
  }
  fieldset{
	  border: none;
  }
  b{
	  margin-bottom: 10px;
  }
  #label{
	  margin-top: 10px;
  }
 </style>
</head>
 <body>
  <div class="form-div">
  
  <form method="post" action ="index.php" >
    <fieldset> 
     <label for="username" > <b> USERNAME </b>: 
     </label> <input type="text" name="username" />
      <br>
     <div id="label">
      <label for="password"><b> PASSWORD <b> :
      </label> <input type="password" name="password" /> 
     <div>
     <br>
     <input class="login" type="submit" value="LOGIN" />
    </fieldset>
  </form>
  <b>No account?</b><a href="register.php">REGISTER HERE!</a>
  </div>
 </body>
</html>