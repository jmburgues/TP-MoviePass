<?php namespace Config;
//Archivo de configuracion para constantes comunes

define("ROOT", dirname(__DIR__) . "/"); //Establece la URL absoluta a la carpeta de nuestro ROOT

//FRONT_ROOT -> Ruta relativa al directorio root, se cambia en cada proyecto. 
define("FRONT_ROOT", "/Movie-pass");

//VIEWS_PATH -> Define como constante la carperta de las vistas
define("VIEWS_PATH", "Views/");

//CSS, JS_PATH -> Define como constante la carperta de las vistas
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
?>

