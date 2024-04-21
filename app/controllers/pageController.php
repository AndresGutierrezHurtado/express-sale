<?php

class PageController {
    public function home(){
        require_once(__DIR__ . "/../views/pages/home.view.php");
    }  
    public function about(){
        require_once(__DIR__ . "/../views/pages/home.view.php");
    }
    public function login(){
        require_once(__DIR__ . "/../views/auth/login.php");
    }
    public function register(){
        require_once(__DIR__ . "/../views/auth/register.php");
    }
}