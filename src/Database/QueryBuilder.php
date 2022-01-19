<?php

namespace App\Database;
use App\Session;
use Exception;

class QueryBuilder{
    private $selectables=[];
    private $table;
    private $whereClause;
    private $limit;
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo=$pdo;
    }

    

    function selectAll($table){
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS);
    }
    //función que comprueba la existencia de un usuario (por medio del mail)
    function selectUser($mail){
       $statement = $this->pdo->prepare("select count(*) from users where email='{$mail}'");
       $statement->execute();
       //si el mail existe da true
       if(($statement->fetchAll(\PDO::FETCH_ASSOC)[0]["count(*)"]) == 1){
            return true;
       }
       //si no existe da false
       return false;
    }
    
    public function getCourse($id){
        $statement = $this->query("select course from users where id='{$id}'LIMIT 1;");    //se deben de cumplir las dos opciones de usuario y contraseña simultaneamente para que el login sea valido
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function checkValidCourse(){
        $statement = $this->query("select course from courses;");   
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

   public function getTeacherId($iduser){
    $statement = $this->pdo->prepare("select id from teachers where iduser='{$iduser}'");
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_ASSOC)[0]["id"];
   }

    public function getTeachersData($array){
        $result =[];
        foreach($array as $subj){
            $row = $subj[0]["teacher"];
            try{
                $statement = $this->query("select id,fullname,studies from teachers where id='{$row}';");   
                $statement->execute();
                $result[] = $statement->fetchAll(\PDO::FETCH_ASSOC);    
                }catch(Exception $e){
                    //ha ocurrido algun error
                }
                    
        }
        return $result  ;
    }

    public function subjectName($array){
        $result =[];
        foreach($array as $subj){
            try{
            $statement = $this->query("select code, duration, name, teacher from subjects where code='{$subj}';");   
            $statement->execute();
            $result[] = $statement->fetchAll(\PDO::FETCH_ASSOC);
            }catch(Exception $e){
                //ha ocurrido algun error
            }
        }
        return $result;
        
    }

    public function subjectNameById($id){
            $statement = $this->query("select name, duration, uf from subjects where teacher='{$id}';");   
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateCourse($mail, $course){
        $stmt = $this->query("update users set course='{$course}' where email='{$mail}';");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getAdminUsers(){
            $statement = $this->query("select id,email, uname, role from users where role != 3;");   
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAdminMatriculation(){
        $statement = $this->query("select id,email, uname, role,course from users where role = 1;");   
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
}

    public function getAdminTeachers(){
        $statement = $this->query("select * from teachers");   
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function updateRole($mail, $role){
        $statement = $this->query("update users set role='{$role}' where email='{$mail}';");
        if( $statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function updateUser($mail, $newField, $option){
        
            if($option == "uname"){
                $statement = $this->query("update users set uname='{$newField}' where email='{$mail}';");
               
            if( $statement->execute()){
                return true;
            }
            }elseif($option == "email"){
                $statement = $this->query("update users set email='{$newField}' where email='{$mail}';");
                if( $statement->execute()){
                    return true;
                }
         
            }else{
                return false;
            }
            
        
    }
    public function deleteTeacher($id){
        $stmt = $this->query("delete from teachers where id='{$id}';");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function insertTeacher($id, $fullname, $iduser, $studies){
        try{
        $stmt = $this->query("INSERT INTO teachers (id,fullname,iduser,studies) VALUES ('{$id}','{$fullname}','{$iduser}','{$studies}')");
        if($stmt->execute()){
            return true;
        }
        }catch(Exception $e){
            return false;
        }
        return false;
    }

    public function getSubjects(){
        $stmt = $this->query("select * from subjects");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertSubjects($code,$name, $duration, $course, $uf, $teacher){
        try{
            $stmt = $this->query("INSERT INTO subjects (code,name,duration,course,uf,teacher) VALUES ('{$code}','{$name}','{$duration}','{$course}','{$uf}','{$teacher}');");
            if($stmt->execute()){
                return true;
            }
            }catch(Exception $e){
                return false;
            }
            return false;
    }

    public function deleteSubjects($code){

        try{
            $stmt = $this->query("delete from subjects where code='{$code}';");
            if($stmt->execute()){
                return true;
            }
            }catch(Exception $e){
                return false;
            }
            return false;
    }

    public function deleteUser($mail){
        $statement = $this->query("delete from users where email='{$mail}';");   
        if($statement->execute()){
            return true;
        }
    }


    public function getTeacherStudentsName($course){
        if(count($course) > 1){
            $return = [];
            try{
            foreach($course as $co){
                $statement = $this->query("select uname,email from users where course='{$co}' and role='1';");   
                $statement->execute();
                $return[] = $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            }catch(Exception $e){
                //error
            }
            return $return;
        }

        $statement = $this->query("select uname,email from users where course='{$course}' and role='1';");   
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
   
    public function selectCourses($idTeacher){
        $statement = $this->query("select course from subjects where teacher='{$idTeacher}';");   
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getClass($course){
        $statement = $this->query("select class from courses where course='{$course}';");    //se deben de cumplir las dos opciones de usuario y contraseña simultaneamente para que el login sea valido
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCourseName($num){
        $stmt = $this->query("SELECT modality from courses where course={$num} LIMIT 1;");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function registerUser($username, $mail, $password, $course){
        var_dump($username);
        var_dump($mail);
        var_dump($password);
        var_dump($course);
        $encryptVariable = "M7mola";
        $encryptPassword = hash_hmac("sha256",$password, $encryptVariable);
        //no he habilitado que se puedan registrar profesores por ahora ya que quiero hacerlo de otra manera, todos los usuarios tendrán el rol 1 de estudiantes, no voy a habilitar la creación de profesores, unicamente se pueden usar los correos ya existentes
        $stmt = $this->query("INSERT into users (email,uname,passw,`role`, course)values('{$mail}','{$username}','{$encryptPassword}','1','{$course}')");
        //si se ha podido insertar
        if($stmt->execute()){
             return true;
        }
        //si no se ha podido da false
        return false;
    }

    public function getRole($mail){
        $statement = $this->pdo->prepare("select role from users where email='{$mail}'");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC)[0]["role"];
    }

    function selectId($mail){
        $statement = $this->pdo->prepare("select id from users where email='{$mail}'");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC)[0]["id"];
    }
    //función que retorna un 1 o 0 si se ha encontrado una cuenta con los datos correctos
    function selectUserPasswd($mail , $passwd){
        $statement = $this->pdo->prepare("select email, passw from users where email='{$mail}' and passw='{$passwd}';");    //se deben de cumplir las dos opciones de usuario y contraseña simultaneamente para que el login sea valido
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selec(){
        $this->selectables=func_get_args();
        return $this;
    }

    public function query($sql){
        return $statement = $this->pdo->prepare($sql);
    }


    function insert ($table, $parameters){
        $sql = sprintf('insert into %s (%s) values (%s)'. $table, implode(', ', array_keys($parameters)), ':' . implode(',:', array_keys($parameters)));
    }


    //Métodos para conseguir datos facilmente
    public function getUname($mail){
        $stmt = $this->query("SELECT uname FROM users WHERE email ='{$mail}' LIMIT 1;");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //metodo para conseguir la id del usuario
    public function getId($mail){
        $stmt = $this->query("SELECT id FROM users WHERE email ='{$mail}' LIMIT 1;");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
    }

    //metodo para conseguir las listas del usuario
    public function getLists($id){
        $stmt = $this->query("SELECT * FROM lists where propietary= '{$id}';");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getListId($listName){
        $stmt = $this->query("SELECT idList FROM lists where tasksData= '{$listName}';");
        try{
            $stmt->execute();
            $final = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch(Exception $e){
            $final= null;
        }
        if($final != null){
            return $final[0]["idList"];
        }else{
            return $final;
        }
    }

    public function getTaskbyName($content){
        //limito a 1 esta consulta ya que si el usuario pone 2 tareas iguales quiero que solo aparezca una y que manualmente tenga que borrar las tareas una a una
        $stmt = $this->query("SELECT * FROM tasks where description= '{$content}' LIMIT 1;");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTasks($id){
        $stmt = $this->query("SELECT * FROM tasks where whichlist= '{$id}';");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function insertTaskList($object,$task, $list){
        $alreadyExists= false;
        if($object == "tasks"){
            $stmt = $this->query("INSERT INTO tasks (whichList,description) VALUES ('{$list}','{$task}')");
        }elseif($object == "lists"){
            //si la lista no existe creala
            if(!$this->getListId($task)){
                $stmt = $this->query("INSERT INTO lists (propietary,tasksData) VALUES ('".Session::get("id")."','{$task}')");
            }else{
                $alreadyExists = true;
            }
        }
        if($alreadyExists == false){
            if($stmt->execute()){
                return true;
            }else{
                return false;
        }
        return false;
        }
        return false;
    }

    public function isEmptyList($idList){
        if(is_array($idList)){
            $id = implode($idList);
        }else{
            $id = $idList;
        }
        $stmt = $this->query("SELECT count(*) FROM tasks WHERE whichList ='{$id}'");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]["count(*)"];
    }

    public function deleteAllTasks($id){
        $stmt = $this->query("DELETE FROM tasks WHERE whichList='{$id}';");
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
    public function deleteTaskbyId($id){
        $stmt = $this->query("DELETE FROM tasks WHERE idTask='{$id}';");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function deleteTaskList($object,$task){
        var_dump($object);
        if($object == "tasks"){
        $stmt = $this->query("DELETE FROM tasks WHERE description='{$task}'");
        }
            elseif($object == "lists"){
                echo"elimina lista";
                $stmt = $this->query("DELETE FROM  lists where tasksData='{$task}'");
        }
        try{
            $stmt->execute();
            $executed = "true";
        }catch(Exception $e){
            $executed = false;
        }
        if(isset($executed) && $executed == true){
            return true;
        }else{
            return false;
        }
    }

    public function downloadList(){
        $lists = $this->getLists(Session::get("id"));

        for($i = 0; $i< count($lists); $i++){
            $getListId = $lists[$i]["idList"];
            $getListName = $lists[$i]["tasksData"];
            
            if(count($lists) != 0){
                $tasks = $this->getTasks($getListId);    //necesito tener esta consulta para poder cuadrar las listas con las tareas
                if($tasks != null){ //este usuario no tiene tareas 
                for($a=0; $a<count($tasks); $a++){
                    $getTaskData[] =  $tasks[$a]["description"];
                 
                }
                
                $data[] = array($getListName, array($getTaskData));
                $getTaskData = null;    //reseteamos el array
            }else{
                $data[] = array($getListName);
            }
            }
        }
        return $data;
        //Estamos devolviendo un array de este tipo: ejemplo:
        //Array ( [0] => Array ( [0] => firts list [1] => Array ( [0] => Array ( [0] => esto es una tarea de m8 [1] => hola mundo ) ) ) [1] => Array ( [0] => second list [1] => Array ( [0] => Array ( [0] => esto pertenece a la otra ) ) ) ) 
    }
    
    public function getAll($object){
        if($object == "tasks"){
            $stmt = $this->query("SELECT * FROM tasks");
            }
                elseif($object == "lists"){
                    
                    $stmt = $this->query("SELECT * FROM lists");
            }
            try{
                $stmt->execute();
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }catch(Exception $e){
                return false;
            }
    }
}