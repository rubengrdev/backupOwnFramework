<?php

namespace App\Controllers;

use App\Controller;
use App\Registry;
use Exception;
use App\Request;
use App\Session;


class SubjectController extends Controller{


    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function subjects(){
        if(Session::get("role") == 1){   //en el caso de ser alumno

        $asignaturas = Registry::get("database")->getClass(Session::get("courseNum"));
        Session::set("asignaturas", showClasses($asignaturas));
        $names = Registry::get("database")->subjectName(Session::get("asignaturas"));
        Session::set("subjectName", $names);
        $teacher = Registry::get("database")->getTeachersData($names);
        Session::set("teachers", $teacher);

        //ordenamos estos datos
        $prepared = $this->orderTeacherSubject($names, $teacher);
        Session::set("prepared", $prepared);
        }else if(Session::get("role") == 2){     //en el caso de ser profesor
            $iduser = Session::get("id");    //id usuario
            $id= Registry::get("database")->getTeacherId($iduser);
            Session::set("teacherId", $id);
            $subjects = Registry::get("database")->subjectNameById($id);
            Session::set("subjectsName", $subjects);

            //cursos del profesor
            $courses = Registry::get("database")->selectCourses($id);
            Session::set("courses", prepareCourses($courses));
            //recogemos los alumnos de este profesor
            $students = Registry::get("database")->getTeacherStudentsName(prepareCourses($courses));
            Session::set("students", $students);

        }


    }


    function selectCode($array){
        $result =[];
        foreach($array as $teach){
            $result[] = $teach["code"];
        }
        return $result;
    }

    function orderTeacherSubject($subjectsArray, $teachersArray){
        $prepare = [];
        foreach($subjectsArray as $sj){
            $teacher =$sj[0]["teacher"];
            foreach($teachersArray as $tr){
                if($teacher == $tr[0]["id"]){
                    $prepare[] = array($sj[0]["name"],$tr[0]["fullname"]);
                }
            }
        }
        return $prepare;
    }


}