<?php
/*
define("F_V", "Views/");
define("F_R", "/TP-MoviePass/");
define("V_P", "Views/");
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "Config/Autoload.php";
require "Config/Config.php";


use Config\Autoload as Autoload;
use Config\Router 	as Router;
use Config\Request 	as Request;

Autoload::start();
Router::Route(new Request());
require_once(VIEWS_PATH."header.php");
if(session_status() != 2)
    session_start();
?>