<?php
    namespace Controllers;

    class ViewController{

        public static function homeView($movies,$page,$title){
            
            include(VIEWS_PATH.'home.php');
        }

    }


?>