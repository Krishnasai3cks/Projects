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
 <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<meta content="width=device-width, initial-scale=1" name="viewport" />

 <style>
	.tweet-div{
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.usertweet-div{
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
	}
	#alltweets{
		padding: 0;
		margin: 5px;
		border: 2px solid black;
		width: 100%;
		text-align: center;

	}
	#button{
	 width: 100px;
	 background-color: #C3423F;
	 color: white;
	}
	#button >a{
		text-decoration: none;
		color: white;
		font-size: 20px;
	}
	.like{
		background-color: blue !important;
	}
	body{
		display: flex;
		justify-content: center;
		align-items: center;
	}
	div.big{
		background-color: pink;
		margin: auto;
		min-height: 100%;
         width: 50%;
          border: 3px solid black;
         padding: 10px;

	}
	textarea{
		resize: none;
	}
	@media screen and (max-width: 768px) {
		body{
			margin: 0;
			padding: 0;
		}
		div.big{
			width: 100%;
		}
	}
 </style>

</head>
 <body>
 <div class="big">
 <?php include('header.php'); ?>
 <div class="tweet-div">
 <form id='Tweet' method="post" name='body' action="create_tweet.php">
  <fieldset>
   <label for='Tweet' style="margin-bottom: -10; margin-top: 10px">What's happening! </label><br>
   <textarea id = "Tweet" placeholder="contents" name='body' rows="3" cols="70" >Enter your tweet here!</textarea><br>
   <input  id="Tweet" type="submit" value="tweet" />
  </fieldset>
 </form>
</div>
 <div class="usertweet-div">
  <h3> <b> Tweets from users you are following </b></h3>
  <?php  
    $a=mysqli_query($conn,"select exists(select * from following where follower='".$_SESSION['username']."') as 'a'") or die(mysqli_error($conn));
	$a=mysqli_fetch_object($a);

    if($a->a == 1){
	 $recent_tweets = get_recent_tweets($conn);
	 if($recent_tweets != NULL){
	 foreach($recent_tweets as $tweet){
		 echo "<div id='alltweets'>";
		 echo '<div id="button"><a href="profile.php?id=' . $tweet['authorId'] . '">' .$tweet['authorname'] .'</a></div>';
		 echo '<p style="margin-top: 20px; font-size: 20px">' . $tweet['body'] . '</p>';
		 echo '<hr>' . $tweet['created']."    " ;
		 
		 $res= mysqli_query($conn,"select exists(select likes from likes where likee='".$tweet['authorId']."' and liker='".$_SESSION['username']."' and tweetid='".$tweet['tweetid']."') as a") or die(mysqli_error($conn));
		 $b=mysqli_fetch_object($res)->a;
		 if($b == 0){
			 $getvar="".$tweet['tweetid']."A".$tweet['authorId']."";
		      echo '<div id="button" class="like"><a href="like.php?var=' . $getvar . '"><i class="fas fa-thumbs-up"></i>like</a>    ';
		 }
	     else{
			 $getvar="".$tweet['tweetid']."A".$tweet['authorId']." ";
		      echo '<div id="button"><a href="unlike.php?var=' . $getvar .'"><i class="fas fa-thumbs-down"></i>unlike</a>   ';
		 }
		 $res5= mysqli_query($conn,"select count(likes) as likecount from likes where tweetid='".$tweet['tweetid']."'") or die(mysqli_error($conn));
		 $b5=mysqli_fetch_object($res5);

		  if($b5->likecount == 0)  echo '(0)</div>';
	      else echo "(".$b5->likecount .")</div>";
		
		  
		  echo "</div>";
	    }
	 }
	}
	else echo "<br> <br> <br> You have no tweets to show here";	
  ?>
 </div>
 </div>
 </body>
</html>
