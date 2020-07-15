<?php
 session_start();
 require_once('dbconnect.php');
 if(isset($_session['username'])){
	header("Location:index.php");
 }
 $a = mysqli_query($conn,"select * from users where id=".$_SESSION['username'].";");
 $userData = mysqli_fetch_object($a);
 function get_recent_tweets($conn){
	   $recent_tweets = NULL;
       $queryString1 = "select * from following where follower=".$_SESSION['username'].";";
       $result1 = mysqli_query($conn,$queryString1) or die(mysqli_error($db_connection));
       while($eachcomment = mysqli_fetch_assoc($result1)) {
        $array1[] = $eachcomment;
       }
	   $users_following = array();
	   foreach($array1 as $entry){
			$users_following[] = $entry['user'];
	   }
	$queryString = "select * from tweets where authorId IN (" . implode(',', $users_following) . ");" or die(mysqli_error());
       $result = mysqli_query($conn,$queryString) or die(mysqli_error($conn));
       while($eachcomment = mysqli_fetch_assoc($result)) {
        $recent_tweets[] = $eachcomment;
       }
	if($recent_tweets != NULL)
	return $recent_tweets;
    else return NULL;
 }
?>
<html>
<head>
 <title> Twitter Clone</title>
 </head>
 <body>
 <?php include('header.php'); ?>
 <form id='Tweet' method="post" name='body' action="create_tweet.php">
  <fieldset>
   <label for='Tweet'>What's happening! </label><br>
   <textarea id = "Tweet" placeholder="contents" name='body' rows="4" cols="50" >Enter your tweet here!</textarea><br>
   <input  id="Tweet" type="submit" value="tweet" />
  </fieldset>
 </form>
 
 <div>
  <p><h3> <b> Tweets from users you are following </b></h3> </p>
  <?php  
    $a=mysqli_query($conn,"select exists(select * from following where follower='".$_SESSION['username']."') as 'a'") or die(mysqli_error($conn));
	$a=mysqli_fetch_object($a);

    if($a->a == 1){
	 
	 $recent_tweets = get_recent_tweets($conn);
	 if($recent_tweets != NULL){
	 foreach($recent_tweets as $tweet){
		 echo '<p><a href="profile.php?id=' . $tweet['authorId'] . '">' .$tweet['authorname'] .'</a></p>';
		 echo '<p>' . $tweet['body'] . '</p>';
		 echo '<p>' . $tweet['created']."    " ;
		 $res= mysqli_query($conn,"select exists(select likes from likes where likee='".$tweet['authorId']."' and liker='".$_SESSION['username']."' and tweetid='".$tweet['tweetid']."') as a") or die(mysqli_error($conn));
		 $b=mysqli_fetch_object($res)->a;
		 if($b == 0){
			 $getvar="".$tweet['tweetid']."A".$tweet['authorId']."";
		      echo '<a href="like.php?var=' . $getvar . '">like</a>    ';
		 }
	     else{
			 $getvar="".$tweet['tweetid']."A".$tweet['authorId']." ";
		      echo '<a href="unlike.php?var=' . $getvar .'">unlike</a>   ';
		 
		 }
		 $res5= mysqli_query($conn,"select count(likes) as likecount from likes where tweetid='".$tweet['tweetid']."'") or die(mysqli_error($conn));
		 $b5=mysqli_fetch_object($res5);
		 if($b5->likecount == 0)
		      echo '(0) </p>';
	     else
		      echo "(".$b5->likecount .")</p>";
		 echo '<hr>';
	 }
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
