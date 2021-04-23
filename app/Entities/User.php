<?php
namespace App\Entities;
use CodeIgniter\Entity;
use App\Models\GradeModel;

class User extends Entity
{

    public function getGrade($idRecipe){
        $gradeModel = new GradeModel();
        $grade = $gradeModel -> where('id_users',$this->id_users)->where('id_recipes',$idRecipe)->find();
        return $grade;
    }    


}
