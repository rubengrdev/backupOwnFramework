<?php

    namespace App\Controllers;
    
    use App\Controller;
    use App\Registry;
    use App\Request;
    use App\Session;
    use Exception;

class ListsController extends Controller{

    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function li(){
        //creamos un "contador" de errores, si esta propiedad da true nos dará información, en un principio siempre debería ser false
        Session::set("errList", false);

        //recogemos la opción que ha seleccionado el usuario (ejemplo: UPDATE, INSERT, DELETE)
        $option = filter_input(INPUT_POST, "option");
        //recogemos la opción que nos indica si queremos afectar a la lista o a la tarea
        $type = filter_input(INPUT_POST, "liststasks");
        //recogemos el nombre del campo
        $field = filter_input(INPUT_POST, "listname");
        //en el caso de que se seleccionen tareas deberemos de obtener un 4º campo que es el contenido de la tarea
        if($type == "tasks"){
            $taskContent = filter_input(INPUT_POST, "taskname");
            if($taskContent == null){
                Session::set("errList", true);
                return $this->redirectTo("dashboard");
            }
        }
        if($this->checkData($option,$type,$field)){
           switch($option){
            case 'INSERT':
                Session::set("action", "insert");
                //comprobamos que los datos sean correctos antes de intentar nada
                if($type == "lists"){
                    Registry::get('database')->insertTaskList($type,$field,"");
                    
                }elseif($type == "tasks"){
                    $listID = Registry::get("database")->getListId($field);
                    if($listID != null){
                        //en el caso de que la lista existe
                        Registry::get("database")->insertTaskList($type, $taskContent, $listID);
                    }else{
                        //en el caso de que la lista no exista
                        Session::set("errList", true);
                    }
                }
                break;
            case 'DELETE':
                Session::set("action", "delete");
                $getListId = Registry::get("database")->getListId($field);
                if($getListId == null){
                    Session::set("errList", true);
                    break;
                }
                $check = Registry::get("database")->isEmptyList($getListId);
                if($type == "lists"){
                    //primero debemos de comprobar que la lista esté vacia
                    //conseguimos la id de la lista
                    if($check != 0){
                        //si tiene alguna tarea dentro
                        Registry::get("database")->deleteAllTasks($getListId);
                    }
                    $insert = Registry::get('database')->deleteTaskList($type,$field);
                    
                }elseif($type == "tasks"){
                    //comprobamos si la tarea existe
                    $getTask = Registry::get("database")->getTaskbyName($taskContent);
                    if($getTask == null){
                        Session::set("errList", true);
                        break;
                    }
                    $taskId = $getTask[0]["idTask"];
                    Registry::get("database")->deleteTaskbyId($taskId);

                }
                
                break;
           }
       
          
           
        }else{
            Session::set("errList", true);
        }
        

        $construct = $this->createListsHTML(Registry::get("database")->downloadList());
       
        
        Session::set("construct", $construct);
        return $this->redirectTo("dashboard");
    }

    function createListsHTML($data){
        $count=count($data);
       
        for($i = 0; $i<$count; $i++){
            $title = "<div class='newlist'><h3 class='list-title'>".$data[$i][0]."</h3>";
    
            if(isset($data[$i][1])) {//estamos comprovando si el usuario tiene tareas
    
            for($a=0; $a<count($data[$i][1][0]); $a++){
                $arrayZoom = $data[$i][1][0];
                $tasks[] = "<p class='taskdesc'>".$arrayZoom[$a]."</p>";
            }
            $prepareString[] = $title.implode($tasks)."</div>";    //cada lista tendra una o varias tareas, no será de otra manera
            $tasks = null;  //reseteamos el array
        }else{
            $prepareString[] = $title."</div>";  //en el caso de no tener tareas este "row" solo tendrá un título
        }
           
        }
        return implode($prepareString); //devolvemos como string
        
    }

    //get all list id's
    public function getListsId(){
        $requestedLists = Registry::get("database")->getAll("lists");
        $arrayId = [];
        foreach($requestedLists as $key){
            $arrayId = $key["idList"];
        }
        return $arrayId;
    }

    //get all task-list id'
    public function getTasksId(){
        $requestedLists = Registry::get("database")->getAll("tasks");
        $arrayId = [];
        foreach($requestedLists as $key){
            $arrayId = $key["whichlist"];
        }
        return $arrayId;
    }

    


    public function checkData($option, $type, $field){
        if($option != null && $type != null && $field != null){
            return true;
        }
        return false;
    }
}