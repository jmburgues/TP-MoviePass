<?php
namespace Config;
/*class Autoload {
    public static function Start(){
    spl_autoload_register(function($className){
        $root = dirname(__DIR__)."/";
        $class = str_replace('\\','/',$className);
        strtolower($class); // Checkear esto funcione
        $fileName = $root.$class.".php";  
        include_once($fileName); 
    });
    }
}*/
class Autoload {

    public static function Start() {
        spl_autoload_register(function($className)
        {
            $classPath = ucwords(str_replace("\\", "/", ROOT.$className).".php");

            include_once($classPath);
        });
    }
}
?>
