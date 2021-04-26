<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;
use App\Models\GradeModel;

use App\Entities\Recipe;
use App\Entities\Grade;

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

        $html = "";
        foreach ($recipes as $recipe) {
            if (count($tags) > 0) {
                $recipeObject = new Recipe(get_object_vars($recipe)); // change the array of object to array of recipe object.
            } else {
                $recipeObject = $recipe;
            }
            $picture = $recipeObject->getPicture();
            $html .= '<div class="recipe-card">' .
                '<img class="recipe-img" src="https://jolivet.needemand.com/realisations/nesti-admin/public/pictures/pictures/' . $picture->name . "." . $picture->extension . '" alt="Card image cap">' .
                '<div class="recipe-card-body"><h5 class="recipe-card-title">' . $recipeObject->recipe_name . '</h5><a href="' . base_url("/recipe/" . $recipeObject->id_recipes) . '"><button class="recipe-btn-see">See Recipe</button>' .
                '</a></div></div>'; // we prepare the updated html (cards)
        }

        $data["recipes"] = $recipes;
        $data['success'] = true;
        $data["html"] = $html;

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


        // $s = $gradeModel->save($gradeObject);
        // var_dump($gradeModel->db->error());
        // // 7. On traite les erreurs éventuelles
        // if ($s === false) {
        //     // les données enregistrées dans flasData ne sont concervés
        //     // que pour la prochaine page, puis elles seront détruites.            
        //     $this->session->setFlashdata('errors', $gradeModel->db->error());
        //     // dd($this->session->getFlashdata('errors'));
        // } else {
        //     $this->session->setFlashdata('success', true);
        // }

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
            if ($error == "Duplicate entry '3-251' for key 'PRIMARY'") {
                $errorMessage = "You already gave a grade to this recipe !";
            }
            $data["error"] = $errorMessage;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }
}
