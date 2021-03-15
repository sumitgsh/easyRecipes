
<?php require_once("./includes/initialize.php"); ?>
<?php require_once("./includes/storage.php"); ?>
<?php require_once("./includes/Pagination.php"); ?>
<?php

 
if(isset($_GET['title']))
{
  echo "<script type='text/javascript'>alert('Recipe added successfully');</script>"; 
}


  // 1. the current page number ($current_page)
  $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

  // 2. records per page ($per_page)
  $per_page = 4;

  // 3. total record count ($total_count)
  $total_count = Photograph::count_all();
  
  //$total_count=5;
  // Find all photos
  // use pagination instead
  //$photos = Photograph::find_all();
  
  $pagination = new Pagination($page, $per_page, $total_count);
  
  // Instead of finding all records, just find the records 
  // for this page
  $sql = "SELECT * FROM photograps ";
  $sql .= "LIMIT {$per_page} ";
  $sql .= "OFFSET {$pagination->offset()}";
  $photos = Photograph::find_by_sql($sql);


  
  // Need to add ?page=$page to all links we want to 
  // maintain the current page (or store $page in $session)
  
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
    crossorigin="anonymous">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/contrimain.css">
  <title>Contributions</title>
</head>

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

  <main id="work">
<div>
     
  <span >
  <button id="contri_button" style="float:right;height:30px;width:13%; font-size: 15px;">Add Your Recipe</button>
  </span>

  
      <?php if(isset($_SESSION['user_id'])){ ?>

      <script type="text/javascript">

      document.getElementById("contri_button").onclick=function(){
        location.href="addrecipe.php";
         };
       </script>

       <?php }else{ ?>
        <script type="text/javascript">

      document.getElementById("contri_button").onclick=function(){
        alert("Please LOGIN IN-ORDER to Contribute");
         };
       </script>

       <?php } ?>
     
	 
    <h1 class="lg-heading">
      Contributions
	  </h1>
    </div> 
    
    <div class="projects">
	<?php 
		 if(sizeof($photos)<=0)
		{
		 echo "<h1>Be the first One to Add Your Recipe</h1>";
		}
		?>	
		
      <?php foreach($photos as $photo): ?>
	  
      <div class="item" style="float: left; margin-left: 20px;">
      <?php 
         # The name for the bucket
           $buckets=new Storage();
 		      	$bucketName = 'easyrecipestorage.appspot.com';
            $objectName=$photo->filename;
            $url=$buckets->getImageUrl($bucketName,$objectName);
       ?>
        <a href="view.php?id=<?php echo $photo->id; ?>">
        
          <img src="<?php echo $url; ?>" alt="Project" style="height:200px;" />
        </a>
        <a href="view.php?id=<?php echo $photo->id; ?>"  class="btn-dark" style="font-size: 20px;text-align: center;">
          <?php $details=Recipe::find_Recipe_by_id($photo->id);  ?>
          <?php echo $details->Title; ?>
        </a>
      </div>
      <?php endforeach; ?>
      </div>
  </main>

  <footer id="main-footer">
    Copyright &copy; 2019
  </footer>

  <script src="js/index.js"></script>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</html>