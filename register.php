<?php

require_once("includes/initialize.php");
require_once './send_Email.php';
if(isset($_GET['error']))
{	 
	echo "<script type='text/javascript'>alert('{$_GET['error']} please try a different one!!');</script>";
}


//form submitted then true
if(isset($_POST['signup-submit'])){ 

$username=$_POST['uname'];
$email=$_POST['email'];
$password=$_POST['psw'];
$passwordRepeat=$_POST['psw-repeat'];

if(empty($username) || empty($username) || empty($password) || empty($passwordRepeat)){

 //mark the user with an error function
 
 header("Location:register.php?error=emptyfields&uid=".$username."&mail=".$email);
echo $error;
exit();
}

else if(!filter_var($email,FILTER_VALIDATE_EMAIL)&&preg_match("/^[a-zA-Z0-9]*$/",$username)){
header("Location:register.php?error=invalidEmail or Uid");
exit();
}

else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
{
header("Location:register.php?error=invalidEmail=".$username);
exit();
}

else if(!preg_match("/^[a-zA-Z0-9]*$/",$username))
{
header("Location:register.php?error=invaliuid=".$email);
exit();
}

else if($password!==$passwordRepeat){

//password preg match is also required

header("Location:register.php?error=Passwordcheck");
exit();
}

else{
	//check the user name already exist
	$email_exist=User::find_by_email($email);
	
	 if($email_exist)
	 {
		header("Location:./register.php?error=Email already exist");
		exit();
	 }
	 //check the username already exist
	 $user_exist=User::find_by_username($username);
	 if($user_exist)
	 { 
	   header("Location:./register.php?error=Username already exist");
	   exit();
	 }else{
	
		 // generate unique token
		$token = bin2hex(random_bytes(50)); 
	
		//? is called placeholder
		$sql="INSERT INTO users(uName,uEmail,uPass,token) values(?,?,?,?)";
		$stmt=mysqli_stmt_init($database->open_connection());
		 if(!mysqli_stmt_prepare($stmt,$sql)){
		header("Location:../register.php?error=sqlerror");
		exit();
		 }
		 else
		 {
		  $hashedPwd=password_hash($password,PASSWORD_DEFAULT);

		  mysqli_stmt_bind_param($stmt,"ssss",$username,$email,$hashedPwd,$token);
		if(mysqli_stmt_execute($stmt))
		{
			
		//send verification email	
		 sendVerificationEmail($email,$token);

		//On successful regsitrtation
			
		 header("Location:login.php?register=success");
		 exit();
		}
		 redirect_to("login.php");
		mysqli_stmt_close($stmt);
		$database->close_connection();
	  }
	 }
 }
}

?>
 <!DOCTYPE html>
<html>

<head>
<title>Register</title>
<link rel="stylesheet" type="text/css"  href="./css/lstyle.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 </head>  
  
<body>






<div id="modal-wrapper" class="modal">



  <form class="modal-content animate" action="register.php" method="post">
        
    <div class="imgcontainer">

      <span class="closef" title="Close PopUp">&times;</span>

      <img src="./img/3.png" alt="Avatar" class="avatar">
      <h1 style="text-align:center">Register</h1>


    </div>

    <div class="container">
      <input type="text" placeholder="Enter Username" name="uname"  value="<?php if(isset($_POST["uname"])) echo $_POST["uname"]; ?>">
      <input type="Email" placeholder="Enter email" name="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>">
      <input type="password" placeholder="Enter Password" name="psw">    
      <input type="password" placeholder="Confirm Password" name="psw-repeat">     
      <button type="submit" id="submitButton" class="btn btn-success " name="signup-submit">Sign Up</button>
      <div>
	  <span style="margin-left:5%">Already have an account?</span>      
      <span>
	  <a href="login.php" style="text-decoration:none; float:right;margin-right:20px;">Sign in</a>
	  </span>
    </div>
    </div>
  </form>
  
</div>
 
<script>

document.getElementById('modal-wrapper').style.display='block';
document.querySelector(".closef").onclick =()=> {

	document.getElementById('modal-wrapper').style.display='none';

    location.href = "index.php";
    };

</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<?php if(isset($database)){
  $database->close_connection(); 
}?>
