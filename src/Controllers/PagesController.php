<?php

    namespace App\Controllers;
    
  

    class PagesController{

        function index(){
            return view('index');
        }

        function about(){
            return view('about');
        }

        function login(){
            return view('login');
        }

        function register(){
            return view('register');
        }

        function dashboard(){
            return view('dashboard');
        }

        function lists(){
            return view('lists');
        }

        function logout(){
            return view('logout');
        }
        
        function error(){
            return "";
        }
        
        
        
     
    }