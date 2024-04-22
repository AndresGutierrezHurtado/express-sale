<?php 

class Router {
    private $controller;
    private $method;

    public function __construct() {
        $this->matchRoute();
    }

    public function matchRoute() {
        $url = explode("/", URL);
        $this -> controller = !empty($url[1]) ? $url[1] : 'Page' ;
        $this->method = !empty($url[2]) ? $url[2] : 'Home';        
        $this -> controller = $this -> controller . 'Controller';
        require_once(__DIR__ . "/controllers/$this->controller.php");
    } 

    public function run(){
        $controller = new $this -> controller();
        $method = $this -> method;
        $controller -> $method();
    }
}