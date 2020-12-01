<?php 
namespace Controllers;

    class AuthController{

        public static function validate($accessRole){

            $auth = false;

            if(isset($_SESSION['role'])){
                if($accessRole == 'owner' && ($_SESSION['role'] == 'owner')){
                    $auth = true;
                }
                else if($accessRole == 'admin' && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'owner')){
                    $auth = true;
                }
                else if($accessRole == 'user'){
                    $auth = true;
                }
            }
            if(!$auth){
                ViewController::errorView("ERROR 403: Access denied.");
            }
            return $auth;            
        }
    }