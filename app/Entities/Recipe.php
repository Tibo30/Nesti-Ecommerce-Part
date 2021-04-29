<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\TagModel;
use App\Models\PictureModel;
use App\Models\GradeModel;

class Recipe extends Entity
{

    public function getTags()
    {
        $tagModel = new TagModel();
        $tags = $tagModel->tagsByRecipe($this->id_recipes);
        return $tags;
    }

    public function getPicture()
    {

        $pictureModel = new PictureModel();
        $picture = $pictureModel->find($this->id_pictures);
        return $picture;
    }

    public function getGrades()
    {
        $gradeModel = new GradeModel();
        $grades = $gradeModel->where('id_recipes', $this->id_recipes)->findAll(); // get all the grades for a recipe
        return count($grades);
    }

    public function getAverageGrade()
    {
        $gradeModel = new GradeModel();
        $grades = $gradeModel->where('id_recipes', $this->id_recipes)->findAll(); // get all the grades for a recipe

        // calcul the average grade
        $totalGrades = 0;
        foreach ($grades as $grade) {
            $totalGrades += $grade->grade;
        }
        $averageGrade = null;
        if (count($grades) > 0) {
            $averageGrade = $totalGrades / count($grades);
        }
        return $averageGrade;
    }
}
