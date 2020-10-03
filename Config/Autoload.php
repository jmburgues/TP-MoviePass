<?php
namespace Config;
class Autoload {
    public static function Start(){
    spl_autoload_register(function($className){
        $root = dirname(__DIR__)."/";
        $class = str_replace('\\','/',$className);
        $fileName = $root.$class.".php";  
        include_once($fileName); 
    });
    }
}
?>