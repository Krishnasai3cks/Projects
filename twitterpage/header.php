
<span class="spana" style="color: blue" > Welcome, <?php echo $userData->username.'<br/><br/><br/>'; ?> </span>
<div class="nav-bar">
  <div class="b1"><a href="home.php"> HOME </a></div>
  <div class="b2"><a href="profile.php?id=<?php echo $_SESSION['username']; ?>">PROFILE</a></div>
  <div class="b3"><a href="userlist.php">FOLLOWING</a></div>
  <div class="b4"><a href='logout.php'>LOGOUT</a></div>
</div>
<style>
body{
  background: url("https://images.pexels.com/photos/1903702/pexels-photo-1903702.jpeg?cs=srgb&dl=pexels-roberto-shumski-1903702.jpg&fm=jpg");
}
 .spana{
   text-align: center;
   width: 100%;
   font-size: 40px;
   margin-top: 10px;
   margin-left: 10px;
 }
 .b1,.b2,.b3,.b4{
   margin-top: 10px;
   width: fit-content;
   overflow: hidden;
   align: center;
   display: flex;
   border: 2px solid darkblue;
   background-color: cyan;
 }
 .b1,.b2,.b3{
   margin-right: 10px;
 }
 div > a{
   color: blue;
   text-decoration: none;
 }
 .nav-bar{
   width: 100%;
   display: flex;
   justify-content: center;
 }
</style>
