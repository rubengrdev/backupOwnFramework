<?php

namespace App\Controllers;

use App\Controller;
use App\Registry;
use Exception;
use App\Request;
use App\Session;

ini_set('display_errors', 1);

class RegisterController extends Controller{

    public function reg(){
        Session::set("errReg", false);
        $username = filter_input(INPUT_POST, "username");
        $mail = filter_input(INPUT_POST, "mail");
        $password = filter_input(INPUT_POST, "password");
        $course = filter_input(INPUT_POST, "course");

        if($username != null && $mail != null && $password != null && $course != null){
            //comprovamos que el curso de DAW existe
            $valid = false;
            $getCourses = Registry::get("database")->checkValidCourse();
            for($i = 0; $i<=count($getCourses); $i++){
                if($getCourses[$i]["course"] == $course){
                    $valid = true;
                }
            }

            //una vez comprovamos que el usuario no ha dejado campos vacios comprovaremos que el mail no está asociado a otro usuario
            if((Registry::get("database")->selectUser($mail)) != true && $valid == true){
                Registry::get("database")->registerUser($username, $mail, $password, $course);
            }else{
                //el usuario ya existia y no se va a completar el registro
                Session::set("errReg", true);
                return $this->redirectTo("register");
            }
        }
        return $this->redirectTo("login");
    }
}