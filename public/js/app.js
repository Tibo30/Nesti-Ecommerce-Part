/* global ROOT */

/* global ROOT */

document.addEventListener("DOMContentLoaded", function () {
    console.log('Ready');
    
    /** ---- Initialisation ---- **/
    const btns = document.querySelectorAll(".recipe_tag--remove");
    const ul = document.querySelector("#recipe_tag--list");
    const id = ul.getAttribute('data-id');
    const csrf = document.querySelector('input[name="csrf_nesti"]');
    
    
    /** ---- Event ----**/
    btns.forEach(function (elt) {
        elt.addEventListener('click', function (event) {
            event.preventDefault();
            let id_tag = this.getAttribute('data-id');
            deleteTag(id, id_tag).then((response) => {
                if (response) {
                    if (response.success && response.csrf_token) {
                        alert('Suppresion ok');
                        // Raffraichissement du CSRF
                        csrf.setAttribute('value', response.csrf_token);
                        this.parentElement.remove();
                    }
                }
            });
        });
    });

    /**
     * Requete Ajax pour supprimer un tag d'une recette
     * @param {int} id_recipe
     * @param {int} id_tag
     * @returns mixed
     */
    async function deleteTag( id_recipe, id_tag) {
        // Requete
        var myHeaders = new Headers();
        
        

        let formData = new FormData();
        formData.append('id_recipe', id_recipe);
        formData.append('id_tag', id_tag);
        formData.append(csrf.name, csrf.value);

        var myInit = {method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + '/tag/delete', myInit);
        try {
            if (response.ok) {
                return await response.json();
            } else {
                return false;
            }
        } catch (e) {
            console.error(e.message);
        }


    }


});