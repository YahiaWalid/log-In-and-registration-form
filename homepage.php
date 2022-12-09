<html lang="en">

<head>
<title>Home Page</title>
<link rel="stylesheet" href="style.css">

<script type="text/javascript">

//validating email using regex
function validateEmail(email){


let regex = new RegExp(/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/);
if (regex.test(email))
  return 0; //valida
else
  return 1;//invalid

}

function validateLoginForm(){

var x=document.forms["login"]["emailbox2"].value;
var y=document.forms["login"]["passwordbox2"].value;

if ((x=="") || (y=="")){
alert("Both email and password must be filled !")
return false;
}


}


function validateRegistrationForm(){

//making sure that all fields are not empty and identifying which fields are empty
var flag = 0;
var boxes = [];
var j=0;
for (var i=0; i<4;i++) {
  if (document.forms["register"][i].value ==""){
    flag=1;
    //boxes array contains the name of all the fields that are not filled by user_id
    //it is used to alert all the empty fields in one message
    boxes[j]=document.forms["register"][i].name;
    //console.log("boxes length: " + boxes.length + " iteration number: " + i);
    j=j+1;
  }

}
//console.log("flag: " + flag);
//console.log("boxes length: " + boxes.length);
if(flag==1){
  if(boxes.length == 1)
  alert("Please fill the following field : " + boxes[0]);
  else if (boxes.length == 2)
  alert("Please fill the following fields : " + boxes[0] + " and " + boxes[1]);
  else if (boxes.length == 3)
  alert("Please fill the following fields : " + boxes[0] + " , " + boxes[1] + " and " + boxes[2]);
  else if (boxes.length == 4)
  alert("Please fill the following fields : " + boxes[0] + " , " + boxes[1] + " , " + boxes[2] + " and " + boxes[3]);

  return false;
}


//checking if both passwords were not matching
if(document.forms["register"]["passwordbox"].value != document.forms["register"]["confirmpasswordbox"].value){
  alert("Passwords do not match !")
  return false;

}
if (validateEmail(document.forms["register"]["emailbox"].value)){
  alert("Please enter a valid email");
  return false

}




}
</script>




</head>


<!--___________________________________________PHP MAIN CODE_____________________________________________________________________________>
<?php
session_start();
$_SESSION['username'] = "";

$_loginfailed=null;
$_loginsuccess=null;

$_emailexists=null;


//DataBase info
$_servername= "localhost";
$_dbname = "root";
$_dbpassword ="";
$_db  ="registration";


//making DB connection
$_connection = mysqli_connect($_servername,$_dbname,$_dbpassword,$_db);


//checking if connection was successful
if ($_connection->connect_error) {
  die("Connection to Database failed: " . $connection->connect_error);

}



// if user clicked on login button
if (isset($_POST["loginbutton"])){


$_email=$_POST["emailbox2"];
$_password=$_POST["passwordbox2"];

$_password=md5($_password);
$_result = mysqli_query($_connection,"SELECT * FROM `user` WHERE `email`='$_email' and `password` = '$_password' ");


//if there is an entry
if ( mysqli_num_rows($_result)){


    $_loginsuccess="logged in successfully"."<br>";
    $_loginfailed="";

    $_row = $_result->fetch_row();
    $_username = $_row[2];

    $_SESSION['username'] = $_username;
    header("Location: welcome.php");
    exit();

}
else {
    $_loginsuccess="";
    $_loginfailed="incorrect email or password !"."<br>";
}



}



// else if the user clicked on the register button
else if (isset($_POST["registerbutton"])){

//getting input which user inputted in form
$_name=$_POST["usernamebox"];
$_email=$_POST["emailbox"];
$_password=$_POST["passwordbox"];




$_result = mysqli_query($_connection,"SELECT * FROM `user` WHERE `email`='$_email' ");


//if there is a user having the same email we cannot create another account with the same email
if ( mysqli_num_rows($_result)){///////////////////////////////////////////////////////////////////////////////////////////////////

    $_emailexists= "A user with this email already exists"."<br>"."Please try to register again with another email or log in if you already have an account";

  }
else {



$_password=md5($_password);

//writing mysql command to insert a new record for newly registered user
$_sql = "INSERT INTO user (`email`, `name`, `password`) VALUES ('$_email', '$_name','$_password')";


//checking if our command was successful or not
if ($_connection->query($_sql) === TRUE) {


$_SESSION['username'] = $_name;
header("Location: welcome.php");
exit();




} else {
  echo "Error: " . $_sql . "<br>" . $_connection->error;
}


}
}



$_connection->close();


?>

_________________________________________________END PHP CODE________________________________________________________-->


<body>



<div class="titlecontainer">Random Website</div>

<div class="flexcontainer">




<!--login-->
<div class="flexbox">
  <h2 style="text-align:center;">login</h2>




<form class="form" name="login"  onsubmit="return validateLoginForm()" method="POST">

<p>Email</p>
<input type="text" name="emailbox2"><br>

<p>Password</p>
<input type="password" name="passwordbox2">

<br><br><input name="loginbutton" type="submit"  value="Log in" style="text-align:center;">

<p style="color:limegreen"><?php echo $_loginsuccess ?></p>
<p style="color:red"><?php echo $_loginfailed ?></p>
</form>
</div>






<!--register-->
<div class="flexbox">
  <h2 style="text-align:center;">New here ? Register now</h2>



  <form class="form" name="register"  onsubmit="return validateRegistrationForm()" method="POST">



  <p>Username:</p>
  <input type="text" name="usernamebox">

  <p>Email:</p>
  <input type="text" name="emailbox">

  <p>Password:</p>
  <input type="password" name="passwordbox">

  <p>Confirm password:</p>
  <input type="password" name="confirmpasswordbox">


  <br><br><input name="registerbutton" type="submit"  value="Register" style="text-align:center;">
  <p style="color:red ; font-size:15px;"><?php echo $_emailexists ?></p>
  </form>


</div>




</div>



</body>
</html>
