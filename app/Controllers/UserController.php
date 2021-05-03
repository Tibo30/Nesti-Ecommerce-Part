<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;
use App\Models\GradeModel;
use App\Models\RecipeIngredientModel;
use App\Models\ParagraphModel;
use App\Models\CommentModel;

use App\Entities\Recipe;
use App\Entities\RecipeIngredient;
use App\Entities\Paragraph;

class UserController extends BaseController
{
    public function createUser()
    {

        $data = [];
        helper('form');

        if ($this->request->getMethod() == 'post') {

            $validation = \Config\Services::validation();

            $validation->setRules(
                [
                    'firstname' => 'required|regex_check_name',
                    'lastname' => 'required|regex_check_name',
                    'username'     => 'required|regex_check_username|is_unique[users.username]',
                    'password'     => 'required|regex_check_password',
                    'confirmPassword' => 'required|matches[password]',
                    'email'        => 'required|valid_email|is_unique[users.email]',
                    'address1' => 'required',
                    'postcode' => 'required|regex_check_postcode',
                    'city' => 'required',
                ],
                [   // Errors
                    'lastname' => [
                        'regex_check_name' => 'The %s field is not valid!'
                    ],
                    'firstname' => [
                        'regex_check_name' => 'The %s field is not valid!'
                    ],
                    'username' => [
                        'regex_check_username' => 'The username has to be between 7 to 20 alphanumeric characters("." "_" "-" accepted)'
                    ],
                    'password' => [
                        'regex_check_password' => 'The password isn\'t strong enough or doesn\'t respect the conditions'
                    ],
                    'postcode' => [
                        'regex_check_postcode' => 'TPlease enter a valid postcode (5 digits)'
                    ],

                ]
            );

            $res = $validation->withRequest($this->request)->run();

            if (!$res) {
                $data['validation'] = $validation;
                var_dump($validation->getErrors());
            } else {


                // // 3. On récupère les données     
                // $name = $this->request->getPost('tag_name');
                // // 4. On rempli un objet Entity        
                // $tag = new Tag();
                // $tag->fill([
                //     'name' => ucfirst($name),
                //     //'slug' => $this->slugify($name)
                //     // `slugify()` est une fonction perso, définie dans Common.php        
                // ]);


                // // 5. On fait appel au model        
                // $model = new TagModel();
                // // 6. On sauvegarde 
                // // si l'id est renseigné il fait un update, sinon il fait un insert       

                // $s = $model->insert($tag);

                // // 7. On traite les erreurs éventuelles
                // if ($s === false) {
                //     // les données enregistrées dans flasData ne sont concervés
                //     // que pour la prochaine page, puis elles seront détruites.            
                //     $session->setFlashdata('errors', $model->errors());
                //     dd($session->getFlashdata('errors'));
                // } else {
                //     $session->setFlashdata('success', true);
                // }
            }
        }

        // 8. on redirige ou on affiche une vue
        return $this->twig->render("pages/register.html", $data);
    }
}
