<?php
namespace Controllers;
use Models\User as User;

class UserController{
    public function showLogin(){
        include dirname(__FILE__).'/../Views/login-view.php';
    }
}

?>