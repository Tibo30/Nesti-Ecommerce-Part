<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;
use App\Models\GradeModel;
use App\Models\CommentModel;

use App\Entities\Recipe;
use App\Entities\Grade;
use App\Entities\Comment;

use App\Models\OrderLineModel;
use App\Entities\OrderLine;

use App\Models\OrderRequestModel;
use App\Entities\OrderRequest;

class AjaxController extends BaseController
{

    /**
     * Get all the recipes according to the tags selected (ajax request)
     * @return void
     */
    public function recipesTagged()
    {
        $data = [];
        $data['success'] = false;

        $model = new RecipeModel();

        $tags = json_decode($this->request->getPost('tags')); // get the tags from the post

        // refresh CSRF token
        $data['csrf_token'] = csrf_hash();


        if (count($tags) > 0) {
            $recipes = $model->getRecipesbyTags($tags); // method that get all the recipes from tags selected. Return an array of object
        } else {
            $recipes = $model->findAll(); // if there is no tag selected, we display all the recipes. Return an array of recipe object
        }

        usort($recipes, function ($r1, $r2) { // sort the array ASC according to the product name of the article
            return $r1->recipe_name <=> $r2->recipe_name;
        });

        $html = "";
        $index = 0;
        $numberPage = ceil((count($recipes) / 8));
        $pagination = "";

        foreach ($recipes as $recipe) { // update html recipes
            if (count($tags) > 0) {
                $recipeObject = new Recipe(get_object_vars($recipe)); // change the array of object to array of recipe object.
            } else {
                $recipeObject = $recipe;
            }
            $averageGrade = $recipeObject->getAverageGrade();
            $copyAverageGrade = $averageGrade;
            $picture = $recipeObject->getPicture();
            $html .= '<div class="recipe-card" data-number="' . $index . '" ' . ($index > 7 ? 'hidden' : '') . '>' .
                '<img class="recipe-img" src="https://jolivet.needemand.com/realisations/nesti-admin/public/pictures/pictures/' . $picture->name . "." . $picture->extension . '" alt="Card image cap">' .
                '<div class="recipe-card-body"><h5 class="recipe-card-title">' . $recipeObject->recipe_name . '</h5>' .
                '<div class="recipe-info"><div class="recipe-info-element"><i class="far fa-clock" aria-hidden="true"></i>'.
                '<p>'.$recipe->time.'</p></div><div class="recipe-info-element"><i class="fa fa-utensils" aria-hidden="true"></i>'.
                '<p>'.$recipe->number_of_people.'</p></div><div class="recipe-info-element"><i class="fa fa-fire" aria-hidden="true"></i>'.
                '<p>'.$recipe->difficulty.'</p></div></div><div class="recipes-card-grade"><div class="recipes-grade-stars">';

            for ($i = 1; $i <= 5; $i++) {
                $html .= '<span class="fa-stack" style="width:1em"><i class="far fa-star fa-stack-1x"></i>';
                if ($copyAverageGrade > 0) {
                    if ($copyAverageGrade >= 1) {
                        $html .= '<i class="fas fa-star fa-stack-1x"></i>';
                    } else {
                        $html .= '<i class="fas fa-star-half fa-stack-1x"></i>';
                    }
                }
                $html .= '</span>';
                $copyAverageGrade--;
            }
            $html .= '</div><div class="recipes-grade-value">';
            if ($recipeObject->getGrades() > 0) {
                $html .= (ceil($averageGrade * 10) / 10) . '/5 on ' . $recipeObject->getGrades() . ' view';
            } else {
                $html .= '0 view';
            }
            $html .= '</div></div>' . '<a href="' . base_url("/recipe/" . $recipeObject->id_recipes) . '"><button class="recipe-btn-see">See Recipe</button>' .
                '</a></div></div>'; // we prepare the updated html (cards)
            $index++;
        }

        if (intval($numberPage) > 1) { //update pagination part html
            $pagination .= '<button id="btn_prev" class="btn-pagination" onclick="prevPage()">Prev</button>';
            for ($i = 1; $i <= intval($numberPage); $i++) {
                $pagination .= '<button id="btn_page" class="btn-pagination" onclick="goPage(' . $i . ')">' . $i . '</button>';
            }
            $pagination .= '<button id="btn_next" class="btn-pagination" onclick="nextPage()">Next</button>';
        }

        $data["recipes"] = $recipes;
        $data['success'] = true;
        $data["html"] = $html;
        $data["pagination"] = $pagination;

        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }

    /**
     * Add grade to a recipe (ajax request)
     * @return void
     */
    public function addgrade()
    {
        $data = [];
        $data['success'] = false;

        $gradeModel = new GradeModel();

        $grade = $this->request->getPost('grade'); // get the grade from the post
        $idRecipe = $this->request->getPost('id_recipe'); // get the id recipe from the post
        $idUser = $this->request->getPost('id_user'); // get the id user from the post

        // refresh CSRF token
        $data['csrf_token'] = csrf_hash();

        $gradeObject = new Grade();
        $gradeObject->fill([
            'id_users' => $idUser,
            'id_recipes' => $idRecipe,
            'grade' => $grade
        ]);

        $error = "";
        try {
            $s = $gradeModel->save($gradeObject);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        if ($error == "") {
            $grades = $gradeModel->where('id_recipes', $idRecipe)->findAll(); // get all the grades for a recipe

            // calcul the average grade
            $totalGrades = 0;
            foreach ($grades as $grade) {
                $totalGrades += $grade->grade;
            }
            $averageGrade = null;
            if (count($grades) > 0) {
                $averageGrade = $totalGrades / count($grades);
            }

            $data["averageGrade"] = $averageGrade;
            $data['success'] = true;
        } else {
            $errorMessage = $error;
            if ($error == ("Duplicate entry '" . $idUser . "-" . $idRecipe . "' for key 'PRIMARY'")) {
                $errorMessage = "You already gave a grade to this recipe !";
            }


            $data["error"] = $errorMessage;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }

    /**
     * Add comment to a recipe (ajax request)
     * @return void
     */
    public function addcomment()
    {
        $data = [];
        $data['success'] = false;

        $commentModel = new CommentModel();
        // filter_input(INPUT_POST, "id_recipe", FILTER_SANITIZE_STRING);
        $title = $this->request->getPost('title'); // get the title from the post
        $comment = $this->request->getPost('comment'); // get the comment from the post
        $idRecipe = $this->request->getPost('id_recipe'); // get the id recipe from the post
        $idUser = $this->request->getPost('id_user'); // get the id user from the post

        // refresh CSRF token
        $data['csrf_token'] = csrf_hash();

        $commentObject = new Comment();
        $commentObject->fill([
            'id_users' => $idUser,
            'id_recipes' => $idRecipe,
            'comment_content' => $comment,
            'comment_title' => $title
        ]);

        $check = $commentModel->where('id_users', $idUser)->where('id_recipes', $idRecipe)->find(); // check if the user already wrote a comment for the recipe
        $error = "";
        if (count($check) == 0) {
            try {
                $s = $commentModel->save($commentObject);
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }

            if ($error == "") {
                $data['success'] = true;
            } else {
                $errorMessage = $error;
                if ($error == "Duplicate entry '" + $idUser + "-" + $idRecipe + "' for key 'PRIMARY'") {
                    $errorMessage = "You already wrote a comment to this recipe !";
                }
                $data["error"] = $errorMessage;
            }
        } else {
            $data["error"] = "You already wrote a comment for this recipe !";
        }

        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }


    /**
     * Add grade to a recipe (ajax request)
     * @return void
     */
    public function payCart()
    {

        $data = [];
        $data['success'] = false;

        $orderRequestModel = new OrderRequestModel();
        $orderLineModel = new OrderLineModel();

        $cart = json_decode($this->request->getPost('cart')); // get the cart

        if (count($cart) > 0) {
            $newOrder = new OrderRequest();
            $newOrder->fill([
                'state' => "a",
                'id_users' => $_SESSION['id']
            ]);
            $idOrder = $orderRequestModel->insert($newOrder);
            foreach ($cart as $orderLine) {
                $newOrderLine = new OrderLine();
                $newOrderLine->fill([
                    'id_order' => $idOrder,
                    'id_article' => $orderLine->id_article,
                    "quantity_ordered" => $orderLine->quantity
                ]);
                $orderLineModel->insert($newOrderLine);
            }
            $data['success'] = true;
        }


        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }
}
