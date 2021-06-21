<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Entities\Tag;

class TagsController extends BaseController
{
    public function index()
    {
        helper('form');
        $model = new TagModel();
        $tags = $model->findAll();
        return $this->twig->render("tag/all-tags.html", ['tags' => $tags]);
    }

    /**
     * Get tag according to its ID
     * int $id
     */
    public function readTag($id)
    {
        helper('form');
        $model = new TagModel();
        $tag = $model->find($id);
        return $this->twig->render("tag/one-tag.html", ['tag' => $tag]);
    }

    /**
     * Edit a tag
     * int $id
     */
    public function editTag($id)
    {
        helper('form');
        $session = session();
        $model = new TagModel();
        $tag = $model->find($id);
        return $this->twig->render("tag/edit-tag.html", ['tag' => $tag, 'errors' => $session->getFlashdata('errors'), 'success' => $session->getFlashdata('success')]);
    }

    /**
     * Create a tag
     */
    public function createTag()
    {
        helper('form');
        return $this->twig->render("tag/create-tag.html");
    }

    /**
     * Search a tag
     */
    public function searchTag()
    {
        helper('form');
        return $this->twig->render("tag/search-tag.html");
    }

    /**
     * Update a tag
     */
    public function updateTag()
    {
        $session = session();
        helper('form');
        // 1. On définie des règles 
        // il faut que les clés correspondent à nom des "input";    
        $rules = [
            'tag_name' => 'required|alpha_numeric_space|min_length[2]',
            'tag_id' => 'required|numeric'
        ];
        // 2. On valide les entrées en faisant appelle à la méthode
        // `$this->validate()`
        if ($this->validate($rules)) {
            // 3. On récupère les données        
            $id = $this->request->getPost('tag_id');
            $name = $this->request->getPost('tag_name');
            // 4. On rempli un objet Entity        
            $tag = new Tag();
            $tag->fill([
                'name' => ucfirst($name),
                'id_tag' => $id,
                //'slug' => $this->slugify($name)
                // `slugify()` est une fonction perso, définie dans Common.php        
            ]);
            // 5. On fait appel au model        
            $model = new TagModel();
            // 6. On sauvegarde 
            // si l'id est renseigné il fait un update, sinon il fait uninsert        
            $s = $model->update($id, $tag);
            // 7. On traite les erreurs éventuelles
            if ($s === false) {
                // les données enregistrées dans flasData ne sont concervés
                // que pour la prochaine page, puis elles seront détruites.            
                $session->setFlashdata('errors', $model->errors());
            } else {
                $session->setFlashdata('success', true);
            }
        }
        // 8. on redirige ou on affiche une vue
        return redirect()->to('/tag/' . $id . '/edit');
    }

    public function createATag()
    {
        $session = session();
        helper('form');
        // 1. On définie des règles 
        // il faut que les clés correspondent à nom des "input";    
        $rules = [
            'tag_name' => 'required|alpha_numeric_space|min_length[2]'
        ];
        // 2. On valide les entrées en faisant appelle à la méthode
        // `$this->validate()`
        if ($this->validate($rules)) {
            // 3. On récupère les données     
            $name = $this->request->getPost('tag_name');
            // 4. On rempli un objet Entity        
            $tag = new Tag();
            $tag->fill([
                'name' => ucfirst($name),
                //'slug' => $this->slugify($name)
                // `slugify()` est une fonction perso, définie dans Common.php        
            ]);


            // 5. On fait appel au model        
            $model = new TagModel();
            // 6. On sauvegarde 
            // si l'id est renseigné il fait un update, sinon il fait un insert       

            $s = $model->insert($tag);

            // 7. On traite les erreurs éventuelles
            if ($s === false) {
                // les données enregistrées dans flasData ne sont concervés
                // que pour la prochaine page, puis elles seront détruites.            
                $session->setFlashdata('errors', $model->errors());
                dd($session->getFlashdata('errors'));
            } else {
                $session->setFlashdata('success', true);
            }
        }
        // 8. on redirige ou on affiche une vue
        return redirect()->to('/tag/create');
    }

    // public function deleteTag($id)
    // {
    //     $model = new TagModel();
    //     $model->delete($id);
    //     return redirect()->to('/tags');
    // }

    /**
     * Recu depuis une requete Ajax
     * @return void
     */
    public function deleteTag()
    {
        $data = [];
        $data['success'] = false;


        if ($this->validate([
            'id_recipe' => 'required|numeric',
            'id_tag' => 'required|numeric'
        ])) {

            $model = new TagModel();

            $success = $model->removeTag(
                $this->request->getPost('id_tag'),
                $this->request->getPost('id_recipe')
            );

            if ($success) {
                // rafraichissement du token CSRF
                $data['csrf_token'] = csrf_hash();
                $data['success'] = true;
            }
        } else {
            $data['errors'] = $this->validator;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
