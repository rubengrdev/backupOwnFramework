<?php

    namespace App\Controllers;
    
    use App\Controller;
    use App\Registry;
    use App\Request;
    use App\Session;
    use Exception;
    ini_set("display_errors", "ON");

class AdminController extends Controller{

    public function adu(){
        
       //recogemos la opción que ha seleccionado el usuario (ejemplo: UNAME, EMAIL, DELETE)
       $option = filter_input(INPUT_POST, "option");
       //recogemos la opción que nos indica si queremos afectar a la lista o a la tarea
       $mail = filter_input(INPUT_POST, "getuserselect");
       $selected = filter_input(INPUT_POST, "userselect");
       //en el caso de que se seleccionen tareas deberemos de obtener un 4º campo que es el contenido de la tarea
       
       if($selected == "update"){
        $newfield = filter_input(INPUT_POST, "getNewSelect");
           if($newfield == null){
               Session::set("errList", true);
           }
       }

       if($mail != null){
           if($selected == "update"){
          
               $update = Registry::get("database")->updateUser($mail, $newfield, $option);
               var_dump($update);
            
           }elseif($selected == "delete"){
                $delete = Registry::get("database")->deleteUser($mail);
           }
           //recargamos el controlador de dashboard
           return $this->next();
           
            
       }else{
            return $this->redirectTo("dashboard");
       }
    }

    public function ads(){
        $option = filter_input(INPUT_POST, "option");
        $mail = filter_input(INPUT_POST, "studentmail");
        if($option != null && $mail != null){
           
            Registry::get("database")->updateRole($mail, $option);
            return $this->next();
        
        }
    }

    public function adt(){
        $userSelect = filter_input(INPUT_POST, 'userselect');
        $id = filter_input(INPUT_POST, 'id');
        $name = filter_input(INPUT_POST, 'name');
        $userid = filter_input(INPUT_POST, 'userid');
        $desc = filter_input(INPUT_POST, 'desc');

        if($userSelect != null && $userSelect == "update"){
            if($id != null && $name != null && $userid != null && $desc != null){
                    if(strlen($id) <= 8 && $userid >= 0 && strlen($name) <= 25 ){

                    
                    //comprovacion de todos los datos
                    try{
                       Registry::get("database")->insertTeacher($id,$name,$userid,$desc);
                    }catch(Exception $e){
                        //error
                    }
                    return $this->next();
                }
                
            }
        }else if($userSelect != null && $userSelect == "delete" && $id != null){
            Registry::get("database")->deleteTeacher($id);
            return $this->next();
        }else{
            return $this->next();
        }
    }

    public function adsa(){
        $userSelect = filter_input(INPUT_POST, 'userselect');
        $code = filter_input(INPUT_POST, 'code');
        $name = filter_input(INPUT_POST, 'name');
        $duration = filter_input(INPUT_POST, 'duration');
        $course = filter_input(INPUT_POST, 'course');
        $uf = filter_input(INPUT_POST, 'uf');
        $teacher = filter_input(INPUT_POST, 'teacher');
        if($userSelect == "add"){
        if($userSelect != null && $name != null && $code != null && $duration != null && $course != null && $uf != null && $teacher != null){
            
            if(strlen($code) <= 8 && $duration > 0 && $course > 0 && $course <= 2 && $uf > 0 && strlen($teacher) <= 8){
                try{
                    Registry::get("database")->insertSubjects($code,$name, $duration, $course, $uf, $teacher);
                }catch(Exception $e){
                    //error
                }
                return $this->next();
            }
        }elseif($userSelect == "delete"){
            if($code != null){
                try{
                    Registry::get("database")->deleteSubjects($code);
                }catch(Exception $e){
                    //error
                }
                return $this->next();
            }
        }
        }
        return $this->next();
    }


    public function adm(){
        $mail = filter_input(INPUT_POST,'useremail');
        $option = filter_input(INPUT_POST,'option');

        if($mail != null && $option != null){
            Registry::get("database")->updateCourse($mail, $option);

        }

        return $this->next();
    }




    public function next(){
        $session=new Session();
        $req = new Request();
        $dboard = new DashboardController($req, $session);
        $dboard->setup();
    }


}