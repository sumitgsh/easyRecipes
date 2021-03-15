<?php require_once("./includes/initialize.php"); ?>


<?php
  if(empty($_GET['id'])) {
    $session->message("No photograph ID was provided.");
    redirect_to('index.php');
  }
  
  $photo = Photograph::find_by_id($_GET['id']);
   if(!$photo) {
    $session->message("The photo could not be located.");
    redirect_to('index.php');
  }
   $details=Recipe::find_Recipe_by_id($photo->id);
  // $sql="SELECT * from contribution WHERE Id=2";
  // global $database;Fa
  // $result_set$database->query($sql);
  //  while ($row = $database->fetch_array($result_set)) {
  //     print_r($row);
  //   }
  
  if(!$photo) {
    $session->message("The photo could not be located.");
    redirect_to('index.php');
  }

  

?>
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/contrimain.css">
     <!-- Bootstrap core CSS -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
   

 
    <title>easyRecipes</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" >
	   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
		<span class="navbar-toggler-icon"></span>
	  </button>
	 <div class="nav_container" style="margin-left:auto;"> 
      <div class="collapse navbar-collapse" id="navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <ul class="nav navbar-nav ">
            <li class="nav-item ">
				<a class="nav-link hvr-glow" href="index.php"><i class="fas fa-home"></i>HOME</a>
           </li>
            <li class="nav-item">
				<a class="nav-link hvr-glow" href="about.html">ABOUT</a>
           </li>
           <li class="nav-item">
				<a class="nav-link hvr-glow" href="contrilist.php">CONTRIBUTIONS <span class="sr-only">(current)</span></a>
           </li>
          <li class="nav-item">
             <?php if(isset($_SESSION['user_id'])){ ?>

            <a class="nav-link hvr-glow" href="logout.php"><i class="fas fa-sign-out-alt"></i>LOGOUT</a>
            <?php }else{ ?>

            <!-- log in  -->
            <a class="nav-link hvr-glow" href="login.php"><i class="fas fa-sign-in-alt"></i></i>LOGIN</a>

            <?php } ?>
 
          </li>
          <li class="nav-item">
            <a class="nav-link hvr-glow" href="register.php">REGISTER</a>
          </li>
        </ul>
       
        </div>
	  </div>
    </nav>

 <div class="container1">

<div style="margin-left: 20px;">
  
  <img src="<?php echo $photo->image_path(); ?>" style="border-radius: 20px 10px;" />
  
</div>
<div id=contribution">
  
  
    <div class="comment" style="margin-bottom":2em;">
      <div class="author">
        <h1><b>Author:</b><?php echo $details->uName; ?><h1>
      </div>
        <div class="desc">
        <h1><b>Description:</b><?php echo $details->Description; ?><h1>
      </div>
        <div class="ser">
       <h1><b> Servings:</b><?php echo $details->Servings; ?><h1>
      </div>
        <div class="cooktime">
        <h1><b>Cooking Time:</b><?php echo $details->CookingTime; ?><h1>
      </div>
        <div class="Ingre">
       <h1><b>Ingredients:</b><?php echo $details->Ingredients; ?><h1>
      </div>
        <div class="Directionsr">
        <h1><b>Directions:</b><?php echo $details->Direction; ?><h1>
      </div>
        
  
        </div>



</div> 
</div>
     <script  src="./js/index.js" type="text/javascript">

        </script> 
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
      <script src="https://kit.fontawesome.com/344716cae9.js" crossorigin="anonymous"></script>
     </body>

</html>
