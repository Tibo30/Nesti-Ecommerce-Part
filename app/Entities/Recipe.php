<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\TagModel;
use App\Models\PictureModel;
use App\Models\GradeModel;
use App\Models\UserModel;

class Recipe extends Entity
{

    /**
     * Get all the tags of the recipe
     */
    public function getTags()
    {
        $tagModel = new TagModel();
        $tags = $tagModel->tagsByRecipe($this->id_recipes);
        return $tags;
    }

    /**
     * Get the recipe picture
     */
    public function getPicture()
    {

        $pictureModel = new PictureModel();
        if ($this->id_pictures != null) {
            $picture = $pictureModel->find($this->id_pictures);
        } else {
            $picture = null;
        }
        return $picture;
    }

    /**
     * Get the grades of the recipe
     */
    public function getGrades()
    {
        $gradeModel = new GradeModel();
        $grades = $gradeModel->where('id_recipes', $this->id_recipes)->findAll(); // get all the grades for a recipe
        return count($grades);
    }

    /**
     * Get the average grade
     */
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

     /**
     * Get the display time (xH yM)
     */
    public function getDisplayTime()
    {
        $troncatedTime = explode(":", $this->time);

        $hour = ($troncatedTime[0]!=null && $troncatedTime[0]!="00") ? $troncatedTime[0] . ' h ' : '';
        $min = $troncatedTime[1] ? $troncatedTime[1] . ' min ' : '';

        $displayTime = $hour . $min;
        return $displayTime;
    }

     /**
     * Get the chief
     */
    public function getChief()
    {
        $userModel = new UserModel();
        $chief = $userModel->find($this->id_chief);
        return $chief;
    }
}
