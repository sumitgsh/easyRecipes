<?php

require_once("./includes/initialize.php");

 if($session->is_logged_in()){  
 	redirect_to("index.php");
 }
 
if(isset($_GET['error']))
{
  echo "<script type='text/javascript'>alert('Check All the fields properly');</script>";
}
   if(isset($_POST['login-submit'])){

     $username=trim($_POST['username']);
     $password=trim($_POST['password']);
      
      if(empty($username)||empty($password)){
        header("Location:./login.php?error=emptyfields");
         exit();

      }
      else
      {
	  
        //Authentication whether username and password exist and verified is set
        $found_user=User::authenticate($username,$password);
        if(trim($found_user)=="Email not Verified!!!")
		{
			echo "<script type='text/javascript'>alert('Email not verified!!! Please verify your email..');</script>";
		}
         else if($found_user){
			 echo var_dump($found_user);
        $session->login($found_user);
		// Get Current date, time
			$current_time = time();
			$current_date = date("Y-m-d H:i:s", $current_time);
			$cookie_expiration_time=$current_time+(30 * 24 * 60 * 60);
			// log_action('Login',"{$found_user->username} logged in.");
			
		  //Set the session cookie 
		  if (! empty($_POST["remember"])) {
			setcookie("username",$_POST['username'],$cookie_expiration_time);
			setcookie("password",$_POST['password'],$cookie_expiration_time);
		  }
		  
			header("Location:index.php?login=success");
          }else
          {
            echo "<script type='text/javascript'>alert('Username or Password does not match');</script>";
           // header("Location:./login.php?error=doesnotmatch");
          }
      }
   }
 
?>
<!DOCTYPE html>
<html>

<head>
<title>Login</title>
<link rel="stylesheet" type="text/css"  href="./css/lstyle.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 
  </head>  
<body>

<h1 style="text-align:center; font-size:50px; color:#fff">Modal Popup Box Login Form</h1>
<div id="modal-wrapper" class="modal">
  
  <form class="modal-content animate" action="login.php" method="post">
  
		<!--Successfull registration-->
		<?php if(isset($_GET[''])) {?>
		<div class="container" >  
			<div class="row">
			 <div class="col-md-12">
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<strong>Registration Successfull!!!</strong> 
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
				</div>
			   </div>
			</div>
		</div>
		<?php } ?>
  
  
		<!--Successfull registration-->
		<?php if(isset($_GET['register'])) {?>
		<div class="container" >  
			<div class="row">
			 <div class="col-md-12">
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<strong>Registration Successfull!!!</strong> 
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
				</div>
			   </div>
			</div>
		</div>
		<?php } ?>
		
	   
    <div class="imgcontainer">

      <span class="closef" title="Close PopUp">&times;</span>

      <img src="./img/3.png" alt="Avatar" class="avatar">
      <h1 style="text-align:center">Login</h1>
    </div>

    <div class="container">
      <input type="text" placeholder="Enter Username" name="username" 
	  value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>">
      <input type="password" placeholder="Enter Password" name="password"
	  value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">        
     
      <input type="checkbox" name="remember" id="remember" style="margin:26px 30px;" 
		<?php if(isset($_COOKIE["username"])) {echo "checked";} ?>> Remember me      
       <button type="submit" id="submitButton" name="login-submit">Login</button>
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
