<?php

//Este controlador se ocupa de destruir la sessión del usuario
namespace App\Controllers;

use App\Controller;
use App\Session;


class LogoutController extends Controller{

    public function des(){
        if($this->destroyChecker(filter_input(INPUT_POST, "validator"))){
            //Destruimos la sessión
            Session::destroy();
            //Redirigimos al cliente
            $this->redirectTo($this->goToLogin());
        }else{
            //en el caso de que haya dicho que no quiere cerrar la sessión le mandamos de vuelta al dashboard
            $this->redirectTo($this->goToDashboard());
        }

    }

    public function goToLogin(){
        return "login";
    }
    
    public function goToDashboard(){
        return "dashboard";
    }
    
    public function destroyChecker($option){
        //si el usuario ha dicho que si
        if($option == "SI"){
            //eliminamos
            return true;
        }
        //si el usuario ha dicho que no
        return false;
    }
}