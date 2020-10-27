<?php
    namespace Controllers;

    class ViewController{

        public static function homeView($movies,$page,$title){
            
            include(VIEWS_PATH.'home.php');
        }

        public static function ownerView($usersList){
                
            include(VIEWS_PATH.'ownerView.php');
        }

    }


?>