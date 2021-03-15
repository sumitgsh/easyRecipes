<?php

require_once("includes/initialize.php");
 
if(isset($_POST['form-submit'])){

$userId=$_SESSION['user_id'];
$userName=$_COOKIE['username'];
$Title=$_POST['Title'];
$description=$_POST['description'];
$servings=$_POST['servings'];
$cooktime=$_POST['cook-time'];
$ingredients=$_POST['Ingredients'];
$directions=$_POST['directions'];

 $recipeData=array($userId,$userName,$Title,$description,$servings,$cooktime,$ingredients,$directions);

  if(!file_exists($_FILES['file_upload']['tmp_name']) || !is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
    echo "<script type='text/javascript'>alert('Please upload the image');</script>";
    }
    else if(empty($Title)|| empty($description) || empty($servings) ||  empty($cooktime) ||
    empty($ingredients) || empty($directions) ){
     
   echo "<script type='text/javascript'>alert('Some fields are empty');</script>";
   }
    else{
  $photo =new Photograph();
  $photo->attach_file($_FILES['file_upload']);
  
	
		 if($photo->save()){
			 //Save the ingredients details to the database
       //create a new Recipe Object
       $recipe=new Recipe();
       $status=$recipe->addRecipe($recipeData);

		 if(!status){
			header("Location:addRecipe.php?error=sqlerror");
		    exit();
			}else{
		 
			$session->message("Photograph uploaded successfully.");
			header("Location:contrilist.php?title=$Title");
		  }
		 }
       else
	 {
  
     echo var_dump($photo->errors);
		echo "<script type='text/javascript'>alert('Error occured while saving');</script>"; 
	 }		 
	 
}

}


?>


<!DOCTYPE html>
<html>

<head>
<title>Add rcipe</title>
<link rel="stylesheet" type="text/css"  href="./css/lstyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>  
<body>


<div id="modal-wrapper" class="modal" style="overflow:inherit;">
  
  <form class="recmodal-content animate" action="addrecipe.php" method="post" enctype="multipart/form-data">
        
    <div class="imgcontainer">
 <!-- <img src="./img/3.png" alt="Avatar" class="avatar"> -->

      <h1 style="text-align:center; color: #398e71;">Add Your Recipe</h1>

    </div>
    <div class="rcontainer">

      
        <div class="isection">
                  <span class="close closer" title="Close PopUp">&times;</span>
                  <span class="imove"><img id="sel" src="./img/1.png" " alt="./img/1.png" /></span>

			<span class="imove">
			<input type="file" id="imgInp" name="file_upload" style="padding: 10px;position: relative;left:-20px;" />
			</span>
                      
                        <script type>

                        // for image load
                        
                            function readURL(input) {
                               
                              if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                 
                                reader.onload = function(e) {
                                  $('#sel').attr('src', e.target.result);
                                }
                                
                                reader.readAsDataURL(input.files[0]);
                              }
                            }

                            $("#imgInp").change(function() {
                            
                              readURL(this);
                              
                            });
                          </script>
          
                     <div class="tadsection" > 

 <label>Title</label><input type="text" name="Title" style="width: 50%;" value="<?php echo isset($_POST['form-submit']) ? $_POST['Title'] : '' ?>" required><br>
                
         <label>Description</label> <input type="text" name="description" style="width: 50%;" value="<?php echo isset($_POST['form-submit']) ? $_POST['description'] : '' ?>"required><br>

       <label>Servings</label> <input type="text" name="servings" style="width: 50%;" value="<?php echo isset($_POST['form-submit']) ? $_POST['servings'] : '' ?>" required><br>
                     
                      </div> 
       <label>Cooking Time</label> <input type="text" name="cook-time" value="<?php echo isset($_POST['form-submit']) ? $_POST['cook-time'] : '' ?>" required><br>
        <label>Ingredients</label> <input type="text" name="Ingredients"  value="<?php echo isset($_POST['form-submit']) ? $_POST['Ingredients'] : '' ?>"required><br>
         <label>Direction</label> <input type="text" name="directions" value="<?php echo isset($_POST['form-submit']) ? $_POST['directions'] : '' ?>" required>      
             <button type="submit" name="form-submit" style="width:30%;margin:8px 26px 6px 35%;" required>Submit</button>
        
           </div> 
        

    </div>
    
  </form>
  
</div>

<script>



document.getElementById('modal-wrapper').style.display='block';

document.querySelector(".close").onclick =()=>{

    document.getElementById('modal-wrapper').style.display='none';

    location.href = "index.php";
    };

</script>

</body>
</html>