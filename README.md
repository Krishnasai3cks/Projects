# Projects
My code for various projects I have done.
This is a twitter clone.
CSS, PHP, HTML with MySQL as a database are used in this project.

There is no separate CSS file as I have added CSS inside the head section itself.

****************

dbconnect.php file:
This is used to connect to the mysql database.

****************

index.html file:
This is shown when the page first loads.
You have to enter a username and password to login. 
Then click the login button to sign into the page.
If you haven't registered then you can register with a new account.

****************

login.php and logout.php file:
Login.php file is created to start a session. 
This session goes on until the browser is closed.
Another way to end a session is by clicking the logout button which will end the session.
Once the session ends the user is sent back to the index.php file.

****************

home.php file:
This is the first page shown once a user is logged in the account.
We can see the tweets make by the people you have followed here. 
This is also your newsfeed.

****************

profile.php file:
This stores the tweets made by you.

****************

userlist.php file:
This file contains the list of all accounts of the users who have registered their accounts in our twitter page.
You can follow or unfollow people by clicking follow button in this file.

****************

follow.php and unfollow.php:
As the name suggests these files are used to follow or unfollow people.

****************

like.php and unlike.php:
Used to like or dislike tweets of other users.

****************

header.php file:
This section is present at the top of every page mentioned above except the index.php page.
This section contains link to four pages - home, profile, userlist, logout.
