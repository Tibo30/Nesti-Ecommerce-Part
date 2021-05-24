// Attach a click event to the document
document.addEventListener("DOMContentLoaded", function() {

    localStorage.setItem("validRecipes",null);

    // Creation of the variables
    var myObj = ingredientsJSON;
    var myObjRecipe = recipesJSON;
    var rightList = [];
    var validRecipes = [];
    var recipesAvailables;
    var consultButton = document.querySelector("#consultRecipe");
    var tryAgain = document.querySelector("#tryAgain");
    var form = document.querySelector(".form-get-suggestions");

    // Set normal value of the button recipes available
    consultButton.disabled = true;

            // For each element in the JSON, create a card (with the constructor)
            myObj.forEach((element,index) => {
                var card = new CardsIngredients(element.ingredientId, element.name, element.url);
                card.createIngredientCards(index);
            });

            // Add event listener on the like buttons that launches the right animation on click
            var right = document.querySelectorAll(".buttonLike");
            right.forEach(element => {
                element.addEventListener('click', (e) => swipe("Right"))
            })

            // Add event listener on the dislike buttons that launches the left animation on click
            var left = document.querySelectorAll(".buttonDislike");
            left.forEach(element => {
                element.addEventListener('click', (e) => swipe("Left"))
            })

            // Add event listener on the recipe review button that launches the web page that displays the recipes
            var consult = document.querySelector("#consultRecipe");
            consult.addEventListener('click', function() {
                doSetRecipe();
                // window.location.href = 'recipe.html';
            });
        

    // Identify the cards, store the ones selected and display recipes available
    function swipe(leftOrRight) {

        // Identification of the first four cards
        identificationCards(leftOrRight);

        // Store the ingredient 
        if (leftOrRight == "Right") {
            checkRecipesAvailable();
        }

        // Display the number of recipes available 
        resultRecipe();
    }

    // Identification of the first four cards
    function identificationCards(leftOrRight) {

        // Creation of the local variables
        var currentCard = event.currentTarget.parentNode.parentNode;
        var cardNext;
        var thirdCard;
        var fourthCard;

        // Change the class of the card to keep a controle on the first four (necessary for the inclination)
        if (currentCard.getAttribute("data-index") != (myObj.length)) {
            if (currentCard.getAttribute("data-index")  == (myObj.length - 1)) {
                cardNext = currentCard.previousSibling;
            } else {
                if (currentCard.getAttribute("data-index")  == (myObj.length - 2)) {
                    cardNext = currentCard.previousSibling;
                    thirdCard = cardNext.previousSibling;
                } else {
                    cardNext = currentCard.previousSibling;
                    thirdCard = cardNext.previousSibling;
                    fourthCard = thirdCard.previousSibling;
                    fourthCard.classList.add("thirdCard");
                }
                thirdCard.classList.add("cardNext");
                thirdCard.classList.remove("thirdCard");
            }
            cardNext.classList.add("currentCard");
            cardNext.classList.remove("cardNext");
        }

        // Add direction of the cards
        var direction = "swipe" + leftOrRight;
        currentCard.classList.add(direction);

        // Remove the tag currentCard at the end of the animation
        document.addEventListener('animationend', () => {
            currentCard.classList.remove("currentCard");
        });
    }

    

    // Compare the list of ingredients chosed by the user with the list of recipes available
    function checkRecipesAvailable() {

        var divCurrentCard = event.currentTarget.parentNode.parentNode; // Get the informations of the chosen card after the click on the like button
        var ingredientAdd = divCurrentCard.childNodes[0].textContent; // Get the title of the chosen card
        rightList.push(ingredientAdd); // Push the title in an array

        validRecipes = [];

        for (var i = 0; i < myObjRecipe.length; i++) { // Browse all the recipes
            if (rightList.every(e => myObjRecipe[i].ingredients.includes(e))) { // Check if all the ingredients contained in the ingredients list are included in the ingredients of each recipe in the recipe list
                validRecipes.push(myObjRecipe[i]); // Push the recipe in the array validRecipes
            }
        }
    }

    // Display the color of the buttons in function of the number of recipes available 
    function resultRecipe() {

        consultButton.style.background = 'var(--primaryColor)';
        tryAgain.style.background = 'var(--primaryColor)';

        if (rightList.length > 0) { // If at least one ingredient is selected
            if (validRecipes.length < 2) {
                recipesAvailables = "There is " + validRecipes.length + " recipe available.";
                consultButton.disabled = false;
                consultButton.style.background = '#10b981';
                if (validRecipes.length == 0) {
                    // Change parameters of buttons Try Again and Consult the recipes if there is no recipes available
                    consultButton.style.background = '#ef4444';
                    tryAgain.style.background = '#10b981';
                    consultButton.style.color = 'white';
                    tryAgain.style.color = 'white';
                    consultButton.disabled = true;
                }
            } else {
                recipesAvailables = "There are " + validRecipes.length + " recipes available.";
                consultButton.style.background = '#10b981';
                consultButton.style.color = 'white';
                consultButton.disabled = false;
            }
            document.getElementById("sentenceRecipesAvailable").innerHTML = recipesAvailables;
        } else {
            consultButton.disabled = true;
        }
    }

    // Save the list containing the valid recipes into the local storage
    function doSetRecipe() {
        localStorage.setItem("validRecipes", JSON.stringify(validRecipes));
        event.preventDefault();
        
        var champCache = document.createElement("input");
        champCache.hidden=true;
        champCache.setAttribute("name", 'validRecipes');
        champCache.setAttribute("value", localStorage.getItem("validRecipes"));
        form.appendChild(champCache);

        form.submit();
    }

   
});