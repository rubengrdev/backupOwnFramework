<?php

namespace App\Controllers;

use App\Controller;
use App\Registry;
use Exception;
use App\Request;
use App\Session;

ini_set("display_errors", 1);
class LoginController extends Controller{

    protected String $email;
    protected String $password;
    static protected $req;

   

    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    //método principal
     public function log(){
         //siempre que entremos al login le preguntaremos lo siguiente
         //en el caso de tener la cuenta ya abierta no haremos las comprovaciones
        $this->logged();
        //recogida de las variables
        $mail = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $get = $this->sanitize($mail,$password);
        $secureMail = $get[0];
        $securePassword = $get[1];

        //comprobamos la contraseña
        if($this->auth($secureMail,$securePassword)){  //devuelve true si es correcto / devuelve false si no es correcto
            //Usamos la clase session para crear una nueva session mediante el método estático set
            Session::set("mail", $secureMail);
            Session::set("status", "connected");
            //guardamos otros datos
            $id = Registry::get('database')->selectID($secureMail);
            Session::set("id", $id);
        }
        $this->next();

    }
    //método para sanear los datos y protegernos (muy simple, esto muy seguro no es :c )
    public function sanitize(String $mail,String $passwd){
        $this->$mail = filter_var ( $mail, FILTER_SANITIZE_EMAIL); //saneamos el correo
        $encryptVariable = "M7mola";
        $this->$passwd = hash_hmac("sha256", $passwd, $encryptVariable); //la contraseña la encriptamos (no debemos trabajar en texto plano nunca) (en la bd la contraseña tmb se encuentra encriptada)
        return [$this->$mail, $this->$passwd];
    }

    public function auth($mail, $password){
        //comprobamos la existencia de el mail antes que nada:
        if(Registry::get('database')->selectUser($mail) == false){
            //si da false significa que NO existe
            Session::set("authNotice", "Mail inexistente");
            return false;
        }
        //si llegamos aquí significa que el mail existe
         try{
             //Esta consulta devuelve un array similar a la siguiente: Array(0)[["usuario"=>"valor", "contraseña"=>"valor"]];
            $data = Registry::get('database')->selectUserPasswd($mail,$password);
            //accedemos al campo interesado i lo comparamos con la contraseña del usuario
            if($data){  //si data no es null
                if( Registry::passwordVerify($data["0"]["passw"], $password)){
                    return true;    //login correcto
                }
            }
            return false;   //login incorrecto

    }catch(Exception $e){
        return false;
    }
    }

    public function goToLogin(){
        return "login";
    }
    public function goToView(){
        $this->next();
    }

    //siguiente paso, ir al controlador del dashboard
    public function next(){
        $session=new Session();
        $req = new Request();
        $dboard = new DashboardController($req, $session);
        $dboard->setup();
    }

    public function back(){
        $session=new Session();
        $req = new Request();
        $login = new LoginController($req, $session);
    }

    public function logged(){
        //si esta sessión existe
        if(Session::exists("status")){
            if(Session::get("status") == "connected" && Session::exists("mail") != null){
                //al existir le preguntamos si se encuentra con una sessión iniciada
                $this->redirectTo($this->goToView());
            }else{
                //en el caso de que no exista lo enviamos a la vista de login de vuelta
                $this->redirectTo($this->goToLogin());
            }
        }else{
            
            //decimos que está desconectado y lo mandamos al login
            Session::set("status", "disconnected");
            $this->redirectTo($this->goToLogin());
        }
        
    }
}
