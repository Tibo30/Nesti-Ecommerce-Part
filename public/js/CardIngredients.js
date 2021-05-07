class CardsIngredients {

    // Construtor of the class CardsIngredients
    constructor(ingredientId, name, url) {
        this.ingredientId = ingredientId;
        this.name = name;
        this.url = url;
    }

    // Creation of the ingredient cards
    createIngredientCards(index) {

        // Creation of all the variables
        var containerIngredientCards = document.querySelector('#containerIngredientCards');
        var cardIngredient = document.createElement("div");
        var titleIngredient = document.createElement("p");
        var titleText = document.createTextNode(this.name);
        var pictureDiv = document.createElement("div");
        var buttonContainer = document.createElement("div");
        var buttonDislike = document.createElement("button");
        var iconDislike = document.createElement("i");
        var buttonLike = document.createElement("button");
        var iconLike = document.createElement("i");

        // Add the image paths
        pictureDiv.style["background-image"] = "url('https://jolivet.needemand.com/realisations/nesti-admin/public/pictures/pictures/" + this.url +"')";

        // Add style in the various div (with the framework Tailwind)
        // For the top elements
       
        cardIngredient.className += "cardIngredient";
        pictureDiv.className += "pictureDiv";
        buttonContainer.className += "buttonContainer";

        // For the dislike button
        buttonDislike.className += "buttonDislike ";
        iconDislike.className += "iconDislike fa fa-times";

        // For the like button
        buttonLike.className += "buttonLike";
        iconLike.className += "iconLike fa fa-heart";


        // Add ID to the card ingredients
        cardIngredient.id += this.ingredientId;

        cardIngredient.setAttribute("data-index",index+1)
        // If the ingredient card is one of the first three, add a class name
        if (this.ingredientId == ingredientsJSON[0].ingredientId) {
            cardIngredient.className += " currentCard";
        } else if (this.ingredientId == ingredientsJSON[1].ingredientId) {
            cardIngredient.className += " cardNext";
        } else if (this.ingredientId == ingredientsJSON[2].ingredientId) {
            cardIngredient.className += " thirdCard";
        }

        // Add nodes in the various HTML elements
        containerIngredientCards.prepend(cardIngredient);
        cardIngredient.appendChild(titleIngredient);
        titleIngredient.appendChild(titleText);
        cardIngredient.appendChild(pictureDiv);
        cardIngredient.appendChild(buttonContainer);
        buttonContainer.appendChild(buttonDislike);
        buttonDislike.appendChild(iconDislike);
        buttonContainer.appendChild(buttonLike);
        buttonLike.appendChild(iconLike);
        buttonDislike.setAttribute("aria-hidden", "true");
        buttonLike.setAttribute("aria-hidden", "true");
    }

}