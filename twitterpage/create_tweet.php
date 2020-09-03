<?php 
 session_start();
 require_once("dbconnect.php");
 if(!isset($_POST['body'])){
	exit();
 }
 $a=$_POST['body'];
 $user_id = $_SESSION['username'];
 $k=mysqli_query($conn,"select username from users where id=".$user_id."") or die(mysql_error());
 $userData=mysqli_fetch_object($k);
 $date =  date('Y-m-d H:i:s');
 $sql='insert into tweets(authorId,authorname,body,created) values('.$user_id.',"'.$userData->username.'","'.$a.'","'.$date.'")';
 mysqli_query($conn,$sql) or die(mysql_error());
 echo 'Tweet sent successfully';
 
?>
<html>
<script>
alert("tweet created");
document.location.href="home.php";
</script>
</html>