<?php 
    namespace Config;

    use Config\Request as Request;
use Controllers\ViewController;
use ErrorException;
use Exception;

class Router
    {
        public static function Route(Request $request)
        {
            $controllerName = $request->getcontroller() . 'Controller';

            $methodName = $request->getmethod();

            $methodParameters = $request->getparameters();          

            $controllerClassName = "Controllers\\". $controllerName;            
            
            if(class_exists($controllerClassName)){
                $controller = new $controllerClassName;
                if(!isset($methodParameters))            
                    call_user_func(array($controller, $methodName));
                else
                    call_user_func_array(array($controller, $methodName), $methodParameters);
            }
            else{
                ViewController::errorView("Class doesn't exists");
            }
        }
    }
?>
