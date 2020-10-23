<?php namespace Config;
/* PATH CONSTANTS */

define("ROOT", dirname(__DIR__) . "/"); 
define("FRONT_ROOT", "/TP-MoviePass/");
define("VIEWS_PATH", ROOT."Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");

define('CONFIG',ROOT.'Config');
//define('ROOT', str_replace('\\','/',dirname(__DIR__).'/'));

//$a = explode($_SERVER['DOCUMENT_ROOT'],ROOT);
//define('FRONT_ROOT',$a[1]);
//define('DATA',ROOT.'data/');
//define('VIEWS', ROOT . 'Views/');
//define('CSS_PATH', FRONT_ROOT . 'Views/css/');
//define('JS_PATH', FRONT_ROOT . 'Views/js/');
define('IMG_PATH', FRONT_ROOT . "Views/img/");
//define('ADMIN_VIEWS', ROOT . '/views/admin/');
//define('IMG_UPLOADS', ROOT . '/asset/uploads/img/');

define('API_KEY','783ce81a4a4455d3719eb5ca1f039861');
define('API_IMAGE_URL','https://image.tmdb.org/t/p/');
define('POSTER_WIDTH_92', "w92/");
define('POSTER_WIDTH_154', "w154/");
define('POSTER_WIDTH_185', "w185/");
define('POSTER_WIDTH_342', "w342/");
define('POSTER_WIDTH_500', "w500/");
define('POSTER_WIDTH_780', "w780/");
define('POSTER_WIDTH_ORIGINAL', "original/");

/* DATABASE CONSTANTS */

define("DB_HOST", "localhost");
define("DB_NAME", "MOVIEPASSDB");
define("DB_USER", "root");
define("DB_PASS", "");

?>

