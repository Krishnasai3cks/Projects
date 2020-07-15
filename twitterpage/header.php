<div>
 <span> Welcome, <?php echo $userData->username.'<BR>'; ?> </span><br>
  [<a href="home.php"> Home </a>]
  [<a href="profile.php?id=<?php echo $_SESSION['username']; ?>">View profile</a>]
  [<a href="userlist.php">View Users List</a>]
  [<a href='logout.php'>Log out</a>]
</div>
