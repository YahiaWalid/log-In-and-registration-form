<!-- sql syntax-->
<!--INSERT INTO `user`(`email`, `name`, `password`) VALUES ('test@test.com','test','test')-->
<!--INSERT INTO user (email, name ,password) VALUES ('test2@test.com','test','test');-->
<!-- SELECT * FROM `user` WHERE `name`="yahia" -->
<!-- DELETE FROM user WHERE `user`.`user_id` = 11" -->
<html lang="en">

<head>
<title>Profile</title>
<link rel="stylesheet" href="style.css">
</head>



<?php
session_start();


 ?>


<body>
  <div class="titlecontainer">Random Website</div>




<div class="flexcontainer">



<div class="welcome">
<?php echo "Welcome ". $_SESSION['username']; ?>
</div>



<br><br><br>
<form method="POST" action="homepage.php">
<input name="signout" type="submit" value="Sign Out" style="text-align:center;">
</form>


</div>
</body>
</html>
