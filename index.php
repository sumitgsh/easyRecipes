<?php
require_once("./includes/initialize.php");


if(($_GET['login'])=='success')
{
echo "<script type='text/javascript'>alert('Successfull Logged In');</script>";
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

    
     <!-- Bootstrap core CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <title>easyRecipes</title>
   <link rel="icon" type="image/ico" href="./favicon.ico" >
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
				<a class="nav-link hvr-glow" href=""><i class="fas fa-home"></i>HOME</a>
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
     <header class="header">
        

        <img src="img/logo2.png" alt="Logo" class="header__logo">  

            <form class="search1">
                <input type="text" class="search__field" placeholder="Search over 1,000,000 recipes...">
                <button class="btn1 search__btn">
                    <svg class="search__icon">
                        <use href="img/icons.svg#icon-magnifying-glass"></use>
                    </svg>
                    <span>Search</span>
                </button>
            </form>
            <div class="likes">
                <div class="likes__field">
                    <svg class="likes__icon">
                        <use href="img/icons.svg#icon-heart"></use>
                        
                    </svg>
                </div>
                <div class="likes__panel">
                    <ul class="likes__list">
                        
                         <!--
                        <li>
                            <a class="likes__link" href="#23456">
                                <figure class="likes__fig">
                                    <img src="img/test-1.jpg" alt="Test">
                                </figure>
                                <div class="likes__data">
                                    <h4 class="likes__name">Pasta with Tomato ...</h4>
                                    <p class="likes__author">The Pioneer Woman</p>
                                </div>
                            </a>
                        </li>
                        -->
                    </ul>
                </div>
            </div>
        </header>


        <div class="results">
            
        
         <ul class="results__list">
              <!--  
                <li>
                    <a class="results__link results__link--active" href="#23456">
                        <figure class="results__fig">
                            <img src="img/test-1.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Pasta with Tomato ...</h4>
                            <p class="results__author">The Pioneer Woman</p>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="results__link" href="#76767">
                        <figure class="results__fig">
                            <img src="img/test-2.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Pasta Salad with ...</h4>
                            <p class="results__author">Spicy Perspective</p>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="results__link" href="#85354">
                        <figure class="results__fig">
                            <img src="img/test-3.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Homemade Tomato ...</h4>
                            <p class="results__author">All Recipes</p>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="results__link" href="#43563">
                        <figure class="results__fig">
                            <img src="img/test-4.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Pasta with Tomato ...</h4>
                            <p class="results__author">The Pioneer Woman</p>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="results__link" href="#2256665">
                        <figure class="results__fig">
                            <img src="img/test-5.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Greek Pasta with ...</h4>
                            <p class="results__author">Chow</p>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="results__link" href="#7567567">
                        <figure class="results__fig">
                            <img src="img/test-9.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Cherry tomato, kale ...</h4>
                            <p class="results__author">BBC Good Food</p>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="results__link" href="#5676577">
                        <figure class="results__fig">
                            <img src="img/test-7.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Pasta with Fresh ...</h4>
                            <p class="results__author">Chow</p>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="results__link" href="#98798">
                        <figure class="results__fig">
                            <img src="img/test-8.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Buttery Tomato Pasta ...</h4>
                            <p class="results__author">Simply Recipes</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="results__link" href="#5464646456">
                        <figure class="results__fig">
                            <img src="img/test-10.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Pesto Pasta Salad ...</h4>
                            <p class="results__author">Eats Well With Others</p>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="results__link" href="#345345435">
                        <figure class="results__fig">
                            <img src="img/test-6.jpg" alt="Test">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">Pasta with Roasted ...</h4>
                            <p class="results__author">Two Peas and Their Pod</p>
                        </div>
                    </a>
                </li>-->
            
            </ul>

            <div class="results__pages">
                <!--
                <button class="btn-inline results__btn--prev">
                    <svg class="search__icon">
                        <use href="img/icons.svg#icon-triangle-left"></use>
                    </svg>
                    <span>Page 1</span>
                </button>
                <button class="btn-inline results__btn--next">
                    <span>Page 3</span>
                    <svg class="search__icon">
                        <use href="img/icons.svg#icon-triangle-right"></use>
                    </svg>
                </button>
                -->
            </div>
        </div>



        <div class="recipe">

            
            <figure class="recipe__fig">
                <img src="img/test-1.jpg" alt="Tomato" class="recipe__img">
                <h1 class="recipe__title">
                    <span>Pasta with tomato cream sauce</span>
                </h1>
            </figure>
            <div class="recipe__details">
                <div class="recipe__info">
                    <svg class="recipe__info-icon">
                        <use href="img/icons.svg#icon-stopwatch"></use>
                    </svg>
                    <span class="recipe__info-data recipe__info-data--minutes">45</span>
                    <span class="recipe__info-text"> minutes</span>
                </div>
                <div class="recipe__info">
                    <svg class="recipe__info-icon">
                        <use href="img/icons.svg#icon-man"></use>
                    </svg>
                    <span class="recipe__info-data recipe__info-data--people">4</span>
                    <span class="recipe__info-text"> servings</span>

                    <div class="recipe__info-buttons">
                        <button class="btn-tiny">
                            <svg>
                                <use href="img/icons.svg#icon-circle-with-minus"></use>
                            </svg>
                        </button>
                        <button class="btn-tiny">
                            <svg>
                                <use href="img/icons.svg#icon-circle-with-plus"></use>
                            </svg>
                        </button>
                    </div>

                </div>
                <button class="recipe__love">
                    <svg class="header__likes">
                        <use href="img/icons.svg#icon-heart-outlined"></use>
                    </svg>
                </button>
            </div>



            <div class="recipe__ingredients">
                <ul class="recipe__ingredient-list">
                    <li class="recipe__item">
                        <svg class="recipe__icon">
                            <use href="img/icons.svg#icon-check"></use>
                        </svg>
                        <div class="recipe__count">1000</div>
                        <div class="recipe__ingredient">
                            <span class="recipe__unit">g</span>
                            pasta
                        </div>
                    </li>

                    <li class="recipe__item">
                        <svg class="recipe__icon">
                            <use href="img/icons.svg#icon-check"></use>
                        </svg>
                        <div class="recipe__count">1/2</div>
                        <div class="recipe__ingredient">
                            <span class="recipe__unit">cup</span>
                            ricotta cheese
                        </div>
                    </li>

                    <li class="recipe__item">
                        <svg class="recipe__icon">
                            <use href="img/icons.svg#icon-check"></use>
                        </svg>
                        <div class="recipe__count">1</div>
                        <div class="recipe__ingredient">
                            <span class="recipe__unit"></span>
                            can of tomatoes, whole or crushed
                        </div>
                    </li>


                    <li class="recipe__item">
                        <svg class="recipe__icon">
                            <use href="img/icons.svg#icon-check"></use>
                        </svg>
                        <div class="recipe__count">1</div>
                        <div class="recipe__ingredient">
                            <span class="recipe__unit"></span>
                            can tuna packed in olive oil
                        </div>
                    </li>

                    <li class="recipe__item">
                        <svg class="recipe__icon">
                            <use href="img/icons.svg#icon-check"></use>
                        </svg>
                        <div class="recipe__count">1/2</div>
                        <div class="recipe__ingredient">
                            <span class="recipe__unit">cup</span>
                            grated parmesan cheese
                        </div>
                    </li>

                    <li class="recipe__item">
                        <svg class="recipe__icon">
                            <use href="img/icons.svg#icon-check"></use>
                        </svg>
                        <div class="recipe__count">1/4</div>
                        <div class="recipe__ingredient">
                            <span class="recipe__unit">cup</span>
                            fresh basil, chopped or torn
                        </div>
                    </li>
                </ul>

               <!-- <button class="btn-small recipe__btn">
                    <svg class="search__icon">
                        <use href="img/icons.svg#icon-shopping-cart"></use>
                    </svg>
                    <span>Add to Cart</span>
                </button>-->
            </div>

            <div class="recipe__directions">
                <h2 class="heading-2">How to cook it</h2>
                <p class="recipe__directions-text">
                    This recipe was carefully designed and tested by
                    <span class="recipe__by">The Pioneer Woman</span>. Please check out directions at their website.
                </p>
                <a class="btn-small recipe__btn" href="http://thepioneerwoman.com/cooking/pasta-with-tomato-cream-sauce/" target="_blank">
                    <span>Directions</span>
                    <svg class="search__icon">
                        <use href="img/icons.svg#icon-triangle-right"></use>
                    </svg>

                </a>
            </div>
            
        </div>





       <!-- <div class="shopping">
            <h2 class="heading-2">My Cart</h2>

            <ul class="shopping__list">

                <!--
                <li class="shopping__item">
                    <div class="shopping__count">
                        <input type="number" value="500" step="100">
                        <p>g</p>
                    </div>
                    <p class="shopping__description">Pasta</p>
                    <button class="shopping__delete btn-tiny">
                        <svg>
                            <use href="img/icons.svg#icon-circle-with-cross"></use>
                        </svg>
                    </button>
                </li>

                <li class="shopping__item">
                    <div class="shopping__count">
                        <input type="number" value="0.5" step="0.1">
                        <p>cup</p>
                    </div>
                    <p class="shopping__description">Ricotta cheese</p>
                    <button class="shopping__delete btn-tiny">
                        <svg>
                            <use href="img/icons.svg#icon-circle-with-cross"></use>
                        </svg>
                    </button>
                </li>

                <li class="shopping__item">
                    <div class="shopping__count">
                        <input type="number" value="3.5" step="0.1">
                        <p>tbsp</p>
                    </div>
                    <p class="shopping__description">Toasted almond slices</p>
                    <button class="shopping__delete btn-tiny">
                        <svg>
                            <use href="img/icons.svg#icon-circle-with-cross"></use>
                        </svg>
                    </button>
                </li>

                <li class="shopping__item">
                    <div class="shopping__count">
                        <input type="number" value="0.5" step="0.1">
                        <p>tbsp</p>
                    </div>
                    <p class="shopping__description">Sea salt</p>
                    <button class="shopping__delete btn-tiny">
                        <svg>
                            <use href="img/icons.svg#icon-circle-with-cross"></use>
                        </svg>
                    </button>
                </li>

                <li class="shopping__item">
                    <div class="shopping__count">
                        <input type="number" value="0.25" step="0.1">
                        <p>cup</p>
                    </div>

                    <p class="shopping__description">Minced green onions</p>
                    <button class="shopping__delete btn-tiny">
                        <svg>
                            <use href="img/icons.svg#icon-circle-with-cross"></use>
                        </svg>
                    </button>
                </li>

                <li class="shopping__item">
                    <div class="shopping__count">
                        <input type="number" value="45" step="10">
                        <p>g</p>
                    </div>
                    <p class="shopping__description">Sesame seeds</p>
                    <button class="shopping__delete btn-tiny">
                        <svg>
                            <use href="img/icons.svg#icon-circle-with-cross"></use>
                        </svg>
                    </button>
                </li>
                
            </ul>-->
            <div class="copyright">
                &copy; by Sumit Ghosh. Powered by
                <a href="http://food2fork.com" target="_blank" class="link">Food2Fork.com</a>.
            </div>

        </div>
    <script>
            
            document.getElementById('show').addEventListener('click',()=>{

             document.getElementById('modal-wrapper').style.display='block';

});
    </script>
     <script  src="./js/index.js" type="text/javascript"></script> 


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/344716cae9.js" crossorigin="anonymous"></script>
 </body>

</html>
