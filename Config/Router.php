<?php 
    namespace Config;

    use Config\Request as Request;
    use Controllers\ViewController;

    class Router
    {
        public static function Route(Request $request)
        {
            $controllerName = $request->getcontroller() . 'Controller';

            $methodName = $request->getmethod();

            $methodParameters = $request->getparameters();

            $controllerClassName = "Controllers\\". $controllerName;

            $classPath = ucwords(str_replace("\\", "/", ROOT.$controllerClassName).".php");

            if(file_exists($classPath)){
                $controller = new $controllerClassName;

                if(!isset($methodParameters))            
                    call_user_func(array($controller, $methodName));
                else
                    call_user_func_array(array($controller, $methodName), $methodParameters);
            }
            else{
                ViewController::errorView("ERROR 404: Invalid URL.");
            }
        }
    }
?>
