<?php

    use App\User;
    use App\Session; 

         function  dd($args){
            $var=func_get_args();
            foreach($var as $arg){
                echo '<pre>'.
                    var_dump($arg).
                    '</pre>';
            } 
            die;
        }

            /**
     * Require a view.
     *
     * @param  string $name
     * @param  array  $data
     */
    function view($name, $data = [])
    {
        extract($data, EXTR_OVERWRITE);
        return require "src/views/{$name}.view.php";
    }


    function controller($name, $data = [])
    {
        extract($data, EXTR_OVERWRITE);
        
        return require "./src/Controllers/{$name}.php";
    }

    function root(){
        if($_ENV['ROOT']=='/'){
            return '';
        }
        return $_ENV['ROOT'];
    }

    function getURI(){
       $uri = $_SERVER['REQUEST_URI']; 
       $return = ucfirst(substr($uri,7));
       if($return == "Logout/"){
        return "Logout";
       }
       if($return == "Dashboard/setup"){
        return "Dashboard";
       }
       return $return;
    }

    function checkLogin(){
        if(isset($_SESSION["status"]) && $_SESSION["status"] != null){
            //no hagas nada, es correcto
            return true;
        }else{
            header("location:".root()."/pages/login");
        }
        //si da algún error
        return false;
    }
    //funcion para conseguir las sesiones desde un controlador dentro de las vistas
    function getSession($session){
         //usando la clase App\User podemos acceder a los metodos de la misma
         if(Session::exists($session)){
             //devolvemos la sessión creada por el usuario
                return (Session::get($session));
         }else{
             return "error404";
         }
    }

    function showClasses($array){
        $newArray = [];
        $dinamic = [];
        for($i = 0; $i<strlen($array[0]["class"]);$i++){
            $alert = false;
            if($array[0]["class"][$i] == ";"){
                $newArray[] =implode($dinamic);
                $dinamic = [];
            }else{ 
                $dinamic[] = $array[0]["class"][$i];
            }
            
        }
       return $newArray;
    }
    function getNameAssoc($array){
        print(" /");
        foreach($array as $val){
            print_r(" ".$val[0]["name"]. " / ");
        }
    }

    function constructlists($data){
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

    function teachersInfo($data){
        $count=count($data);
       
        foreach($data as $key){
            $title = "<div class='classdata'><h3 class='list-title'>".$key[0]."</h3>";
    
            if(isset($key[1])) {//estamos comprovando si el usuario tiene tareas
    
            for($a=0; $a<count($key[1]); $a++){
                $arrayZoom = $key[1];
                $teachers[] = "<p class='teacher'>".$arrayZoom."</p>";
            } 
            $prepareString[] = $title.implode($teachers)."</div>";    //cada lista tendra una o varias tareas, no será de otra manera
            $teachers = null;  //reseteamos el array
        }else{
            $prepareString[] = $title."</div>";  //en el caso de no tener tareas este "row" solo tendrá un título
        }
           
        }
        return implode($prepareString); //devolvemos como string
    }

    function teachersSubject($data){
        $count=count($data);
       
        foreach($data as $key){
            $title = "<div class='classdata'><h3 class='list-title'>".$key["name"]."</h3>";
    
            if(isset($key["duration"])) {//si al propiedad de duración esta definida
    
            for($a=0; $a<count($key["duration"]); $a++){
                $arrayZoom = $key["duration"];
                $teachers[] = "<p class='teacher'>".$arrayZoom." hours</p><p class='teacher'>".$key["uf"]." uf</p>";
            } 
            $prepareString[] = $title.implode($teachers)."</div>";    //cada lista tendra una o varias tareas, no será de otra manera
            $teachers = null;  //reseteamos el array
        }else{
            $prepareString[] = $title."</div>";  //en el caso de no tener tareas este "row" solo tendrá un título
        }
           
        }
        return implode($prepareString); //devolvemos como string
    }
    
    

    function prepareCourses($array){
        if(count($array) == 1){
            return $array[0]["course"];
        }else if(count($array ) > 1){
            foreach($array as $course){
                $return[] = $course;
            }
            return $return;
        }else{
            return "error404";
        }
    }

    