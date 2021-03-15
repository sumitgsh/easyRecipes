// Global app controller
//https://www.food2fork.com/api/search
//88402853c57baf75a29bb75cb4f3e6f8
//sumitkey=88402853c57baf75a29bb75cb4f3e6f8;
//Global
//Config.js 
const key='221919b245916e568a2606f268e0dd97';
//${proxy}

//BASE.js

const elements={

	searchForm:document.querySelector('.search1'),
	searchInput:document.querySelector('.search__field'),
	searchResList:document.querySelector('.results__list'),
	searchRes:document.querySelector('.results'),
	searchResPages:document.querySelector('.results__pages'),
	recipe:document.querySelector('.recipe'),
    likesMenu:document.querySelector('.likes__field'),
    likesList:document.querySelector('.likes__list')


};
const elementStrings={

	loader:'loading',
     //that round circle is called loader
};

const renderLoader=parent=>{

const loader=`
			<div class="${elementStrings.loader}">
               <div class="bounceball"></div>
                 <div class="text">NOW LOADING</div>
     </div>`
  ;

parent.insertAdjacentHTML('afterbegin',loader);

};

const clearLoader=()=>{
	const loader=document.querySelector(`.${elementStrings.loader}`);
	if(loader) loader.parentElement.removeChild(loader);
};





////////////////////////////

/** gloabl state of the app
*- search object
*- current recipe object
*-shopping list object
*- liked recipes
*/

 
const state={}; 

//Model
//model search using API
class Search{

	constructor(query){
		this.query=query;
	}




async getResults(){
	const proxy='https://cors-anywhere.herokuapp.com/';
	const key='221919b245916e568a2606f268e0dd97';
try{
 const res=await fetch(`https://forkify-api.herokuapp.com/api/search?key=${key}&q=${this.query}`);
 const data = await res.json();
 this.result=data.recipes;
}catch(error){
alert(error);
  }
}

}

//Recipe.js
class Recipe{

    constructor(id){
        this.id=id;
    }



async getRecipe(){

try{
 const res=await fetch(`https://forkify-api.herokuapp.com/api/get?key=${key}&rId=${this.id}`);
 const data = await res.json();
 this.title=data.recipe.title;
 this.author=data.recipe.publisher;
 this.img=data.recipe.image_url;
 this.url=data.recipe.source_url;
 this.ingredients=data.recipe.ingredients;	

}catch(error){
alert('Something went Wrong:(');
  }
}

calcTime(){

const numIng=this.ingredients.length;
const periods=Math.ceil(numIng/3);

this.time=periods*15;


}

calcServings(){
    this.servings=4;
}

parseIngredients(){

const unitsLong=['tablespoons','tablespoon','ounces','ounce','teaspoons','teaspoon','cups','pounds'];
const unitsShort=['tbsp','tbsp','oz','oz','tsp','tsp','cup','pound'];
const units=[...unitsShort,'kg','g']

const newIngredients=this.ingredients.map(el=>{
//1) Uniform units
    let ingredient=el.toLowerCase();

    unitsLong.forEach((unit,i)=>{
        ingredient=ingredient.replace(unit,unitsShort[i]);

    });


//2)Remove Parenthesis

ingredient=ingredient.replace(/ *\([^)]*\) */g,' ');


//3)Parse ingredients into count,unit and ingredients

const arrIng=ingredient.split(' ');
const unitIndex=arrIng.findIndex(el2=>unitsShort.includes(el2));//includes loop over the unitShort in order to find whether a current element is there or not


let objIng;
if(unitIndex>-1){
    //There is a unit
    //Ex. 4 1/2 cups,arrCount is [4,1/2]
    //Ex. 4 cups,arrCount is [4]
const arrCount=arrIng.slice(0,unitIndex);

   let count;

    if(arrCount.length===1){
        count=eval(arrIng[0].replace('-','+'));

    }else{
        count=arrIng.slice(0,unitIndex);
     
    }
    objIng={
        count,//similar to count=count
        unit:arrIng[unitIndex],
        ingredient:arrIng.slice(unitIndex+1).join(' ')
    }
}
else if(parseInt(arrIng[0],10))//here 10 denotes decimal values
{
//There is NO unit,but 1st element is a number
objIng={
        count:parseInt(arrIng[0],[10]),
        unit:'',
        ingredient:arrIng.slice(1).join(' ')


    }
}
else if(unitIndex=== -1){
//Ther is NO unit No number in the 1st position
objIng={
        count:1,
        unit:'',
        ingredient


    }
}
return objIng;

});
 return this.ingredients=newIngredients;

}
updateServings(type){
    //Servings

    const newServings=type==='dec'?this.servings-1:this.servings+1;



    //Ingridients
    this.ingredients.forEach(ing=>{

        ing.count=ing.count* (newServings / this.servings);
        //console.log(ing.count);
    });


    this.servings=newServings;
}


}

//Likes .js
class Likes{

constructor(){
    this.likes=[];
}

addlike(id,title,author,img){

    const like={id,title,author,img};

    this.likes.push(like);
    return like;
}

deleteLike(id){
    const index=this.likes.findIndex(el=>el.id === id);

    //[2,4,8] splice(1,2) -> return [4,8],original array is [2]
   this.likes.splice(index,1);

}

isLiked(id){
    return this.likes.findIndex(el=> el.id===id) !== -1;//if true return
}

getNumLikes(){

    return this.likes.length;
}
}





//VIEWS//

//SEARCH VIEW//
const getInput=()=>elements.searchInput.value;

const clearInput=()=>elements.searchInput.value='';


const clearResults=()=>{
	elements.searchResList.innerHTML='';
	elements.searchResPages.innerHTML='';

};


const renderRecipe=recipe=>{

const markup=` 

             <li>
                    <a class="results__link" href="#${recipe.recipe_id}">
                        <figure class="results__fig">
                            <img src="${recipe.image_url}" alt="${recipe.title}">
                        </figure>
                        <div class="results__data">
                            <h4 class="results__name">${limitRecipeTitle(recipe.title,20)}</h4>
                            <p class="results__author">${recipe.publisher}</p>
                        </div>
                    </a>
                </li>
          `;


elements.searchResList.insertAdjacentHTML('afterbegin',markup);



};



// 'Pasta with tomata and spanich'
/*
acc:0  acc+cur.length=5;
acc:5  acc+cur.length=9;
acc:9

*/
const limitRecipeTitle=(title,limit=17)=>{


const newTitle=[];
if(title.length>limit){
title.split(' ').reduce((acc,cur)=>{//split(' ') around space

    if(acc+cur.length<=limit){
    }
        newTitle.push(cur);

    return acc+cur.length;
},0);

//return the results
return `${newTitle.join(' ')}...`;

}

return title;
};

//type: 'prev' or 'next'
const createButton=(page,type)=>`
                   <button class="btn-inline results__btn--${type}" data-goto=${type==='prev'?page-1:page+1}>
                   <span>Page${type==='prev'?page-1:page+1}</span>
                    <svg class="search__icon">
                        <use href="./img/icons.svg#icon-triangle-${type==='prev'?'left':'right'}"></use>
                    </svg>
                    
                </button>

            `;


const renderButtons=(page,numResults,resPerPage)=>{

    const pages=Math.ceil(numResults/resPerPage);
    let button;
    if(page===1 &&pages>1){
        //Button to go to next page
        button=createButton(page,'next');
    
    }else if(page<pages){
        //Both the pages
    button=`
        ${createButton(page,'prev')}
        ${createButton(page,'next')}
    `;
    }
    else if(page===pages && pages>1){
        //Only button to go to next page

    button=createButton(page,'prev');

    }

elements.searchResPages.insertAdjacentHTML('afterbegin',button);

};



const renderResults=(recipes,page=1,resPerPage=10)=>{
	 const start=(page-1)*resPerPage;
    const end=page*resPerPage;

    recipes.slice(start,end).forEach(renderRecipe);

    
   
    //Rendering pagination
    renderButtons(page,recipes.length,resPerPage);

};
//RECIPE VIEW
clearRecipe=()=>{

elements.recipe.innerHTML='';


};

const createIngredient=ingredient=>`
 <li class="recipe__item">
             <svg class="recipe__icon">
                            <use href="img/icons.svg#icon-check"></use>
                        </svg>
                        <div class="recipe__count">${ingredient.count}</div>
                        <div class="recipe__ingredient">
                            <span class="recipe__unit">${ingredient.unit}</span>
                            ${ingredient.ingredient}
                        </div>
             

                   </li>`;
const renderReciped=(recipe,isLiked)=>{

const markup=` 

            <figure class="recipe__fig">
                <img src="${recipe.img}" alt="${recipe.title}" class="recipe__img">
                <h1 class="recipe__title">
                    <span>${recipe.title}</span>
                </h1>
            </figure>
            <div class="recipe__details">
                <div class="recipe__info">
                    <svg class="recipe__info-icon">
                        <use href="img/icons.svg#icon-stopwatch"></use>
                    </svg>
                    <span class="recipe__info-data recipe__info-data--minutes">${recipe.time}</span>
                    <span class="recipe__info-text"> minutes</span>
                </div>
                <div class="recipe__info">
                    <svg class="recipe__info-icon">
                        <use href="img/icons.svg#icon-man"></use>
                    </svg>
                    <span class="recipe__info-data recipe__info-data--people">${recipe.servings}</span>
                    <span class="recipe__info-text"> servings</span>

                    <div class="recipe__info-buttons">
                        <button class="btn-tiny btn-decrease">
                            <svg>
                                <use href="img/icons.svg#icon-circle-with-minus"></use>
                            </svg>
                        </button>
                        <button class="btn-tiny btn-increase">
                            <svg>
                                <use href="img/icons.svg#icon-circle-with-plus"></use>
                            </svg>
                        </button>
                    </div>

                </div>
                <button class="recipe__love">
                    <svg class="header__likes">
                        <use href="img/icons.svg#icon-heart${isLiked?'':'-outlined'}"></use>
                    </svg>
                </button>
            </div>



            <div class="recipe__ingredients">
                <ul class="recipe__ingredient-list">

                 ${recipe.ingredients.map(el=>createIngredient(el)).join(' ')}
                
                   
                </ul>

                
            </div>

            <div class="recipe__directions">
                <h2 class="heading-2">How to cook it</h2>
                <p class="recipe__directions-text">
                    This recipe was carefully designed and tested by
                    <span class="recipe__by">${recipe.author}</span>. Please check out directions at their website.
                </p>
                <a class="btn-small recipe__btn" href="${recipe.url}" target="_blank">
                    <span>Directions</span>
                    <svg class="search__icon">
                        <use href="img/icons.svg#icon-triangle-right"></use>
                    </svg>

                </a>
            </div>
          
`;


elements.recipe.insertAdjacentHTML('afterbegin',markup);


};
 const updateServingsIngredients=recipe=>{

//Update Servings
document.querySelector('.recipe__info-data--people').textContent=recipe.servings;


//update Ingredients

 const countElements=Array.from(document.querySelectorAll('.recipe__count'));
 //console.log(countElements);

  countElements.forEach((el,i)=>{

    el.textContent=recipe.ingredients[i].count;
 });


};

//LikesView

const toggleLikedBtn=(isLiked)=>{

    const iconString =isLiked?'icon-heart':'icon-heart-outlined';
    document.querySelector('.recipe__love use').setAttribute('href',`img/icons.svg#${iconString}`);

    //icons.svg#icon-heart-outlined

};

const toggleLikedMenu=numLikes=>{

    elements.likesMenu.style.visibility=numLikes>0?'visible':'hidden';
};

const renderLike=like=>{

const markup=`<li>
                            <a class="likes__link" href="#${like.id}">
                                <figure class="likes__fig">
                                    <img src="${like.img}" alt="${like.title}">
                                </figure>
                                <div class="likes__data">
                                    <h4 class="likes__name">${limitRecipeTitle(like.title)}</h4>
                                    <p class="likes__author">${like.author}</p>
                                </div>
                            </a>
                        </li>`;


    elements.likesList.insertAdjacentHTML('beforeend',markup);                    

}
const deleteLike=id=>{

const el=document.querySelector(`.likes__link[href*="${id}"]`).parentElement;

if(el)el.parentElement.removeChild(el);

}

/////////////////////////////////////


//CONTROLLER//


//SEARCH CONTROLLER

 const controlSearch= async () =>{

// 1)Get query from view

	  const query=getInput(); //TO Do
   
    clearInput();
	

	if(query){
		//2) New search object and add to state
		state.search=new Search(query);


		//3) Prepare UI  for recipes
		
    	clearInput();
        clearResults();
	
		renderLoader(elements.searchRes);
		
        //4)Search for recipes

		try{

		await state.search.getResults();	
			
        //5)Render results on UI
        clearLoader();
		renderResults(state.search.result);
	}
	catch(err){
		alert('Something went wrong');
         clearLoader();
		
	}

	}

 	
 };

//Recipe COntroller

const controlRecipe=async ()=>{

//Get ID from url
const id=window.location.hash.replace('#','');

if(id){

//Prepare UI for changes
clearRecipe();
renderLoader(elements.recipe);

//create new recipe object

state.recipe=new Recipe(id); 
//testing
try{

//Get recipe data
//Get Parse Ingredients

await state.recipe.getRecipe();
state.recipe.parseIngredients();
//Calculate Servings and time
state.recipe.calcServings();
state.recipe.calcTime();



//Render the recipe
clearLoader();
renderReciped(state.recipe,state.likes.isLiked(id));

}catch(err){
    alert('Error Processing Recipe!');
}

}

};

//LIKE CONTROLLER


state.likes=new Likes();
toggleLikedMenu(state.likes.getNumLikes());
const controlLike=()=>{

if(!state.likes) state.likes=new Likes();
const currentID=state.recipe.id;




//User has NOT yet liked current recipe
if(!state.likes.isLiked(currentID)){
    //ADD like to the state

       const newLike=state.likes.addlike(
        currentID,
        state.recipe.title,
        state.recipe.author,
        state.recipe.img
        );

    //Toggle the like button
    toggleLikedBtn(true);



    //ADD like to UI LIST

    renderLike(newLike);

//User HAS liked current recipe
}else{
//Remove likes from the state
//Remove likes from the state
state.likes.deleteLike(currentID);
//Toggle the like button


    toggleLikedBtn(false);

//Remove like from UI list
deleteLike(currentID);

}

toggleLikedMenu(state.likes.getNumLikes());
};





// window.addEventListener('hashchange',controlRecipe);
// window.addEventListener('load',controlRecipe);

['hashchange','load'].forEach(event => 
    window.addEventListener(event,controlRecipe));


elements.searchForm.addEventListener('submit',e=>{
		
e.preventDefault();
controlSearch();

});

//Handling recipes Button clicks
elements.recipe.addEventListener('click',e=>{

if(e.target.matches('.btn-decrease, .btn-decrease *')){

    //Decrease button is clicked
    if(state.recipe.servings>1){

    state.recipe.updateServings('dec');
    updateServingsIngredients(state.recipe);

}

}else if(e.target.matches('.btn-increase, .btn-increase *'))
{

//Increase button is clicked
    state.recipe.updateServings('inc');
    updateServingsIngredients(state.recipe);

}
else if(e.target.matches('.recipe__love,.recipe__love *')){

    //Like Controller
    controlLike();
}

//console.log(state.recipe);

});


//testing

elements.searchResPages.addEventListener('click',e=>{

	const btn=e.target.closest('.btn-inline');

	if(btn){
		const goToPage=parseInt(btn.dataset.goto,10);//Imp to base 10
		clearResults();
		renderResults(state.search.result,goToPage);
		
	}
	

});




