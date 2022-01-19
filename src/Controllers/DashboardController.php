<?php

    namespace App\Controllers;
    
    use App\Controller;
    use App\Registry;
    use App\Request;
    use App\Session;
    use Exception;

class DashboardController extends Controller{

    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function setup()
    {
        if(Session::exists("mail")){
        try{
            //conseguimos el nombre de usuario del usuario
            $uname = Registry::get('database')->getUname(Session::get("mail"));

            //lo guardamos en una sessión
            Session::set("uname", $uname[0]["uname"]);
            //conseguimos la ID del usuario
            $id = Registry::get("database")->getID(Session::get("mail"));  
            //guardamos la ID en una sessión
            Session::set("id", $id[0]["id"]);
            //guardamos el rol en una sessión
            $role = Registry::get("database")->getRole(Session::get("mail"));
            Session::set("role", $role);
            //conseguimos el curso del usuario y las asignaturas
            $course = Registry::get("database")->getCourse(Session::get("id"));
            Session::set("courseNum", $course[0]["course"]);
            //conseguimos el curso por nombre
            $modality = Registry::get("database")->getCourseName($course[0]["course"]);
            Session::set("course",Session::get("courseNum")." ".$modality[0]["modality"]);

           
            //generamos las asignaturas de la base de datos
            $this->getSubjects();

            //si se trata de un admin
            if($role == 3){
                //guardamos una copia de la base de datos de usuarios
                $extract = Registry::get("database")->getAdminUsers();
                Session::set("useradmin",$extract);

                $teachersextract = Registry::get("database")->getAdminTeachers();
                Session::set("teachersextract", $teachersextract);

                $subjects = Registry::get("database")->getSubjects();
                Session::set("subjects", $subjects);

                $matriculation = Registry::get("database")->getAdminMatriculation();
                Session::set("matriculation", $matriculation);
            }

            //conseguimos las listas de la base de datos
            $lists = Registry::get('database')->getLists(Session::get("id"));
            //guardamos las listas en una sesión
            Session::set("lists", $lists[0]);
            $tasks = Registry::get('database')->getTasks(Session::get("id"));
            Session::set("tasks", $tasks);
            $constructor = constructlists(Registry::get("database")->downloadList());
            Session::set("construct", $constructor);
            return $this->redirectTo("dashboard");
          

        }catch(Exception $e){
            return $this->redirectTo("login");
        }
        }else{
            return $this->redirectTo("login");
        }
        
    }

    public function getSubjects(){
        $session=new Session();
        $req = new Request();
        $subject = new SubjectController($req, $session);
        $subject->subjects();
    }


}