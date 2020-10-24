<?php

namespace Models;

class User
{
    private $userName;
    private $password;
    private $email;
    private $birthDate;
    private $dni;
    private $role;

    function __construct($userName, $password, $email, $birthDate, $dni, $role)
    {
        $this->userName = $userName;       
        $this->password = $password;
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->dni = $dni;
        $this->role = $role;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function getDNI()
    {
        return $this->dni;
    }
    
    public function setUserName($userName){
        $this->userName = $userName; 
    }
    
    public function setPassword($password){
        $this->password = $password;
    }
    
    public function setEmail($email){
        $this->email = $email;
    }

    public function setBirthDate($birthDate){
        $this->birthDate = $birthDate;
    }

    public function setDNI($dni){
        $this->dni = $dni;
    }

    public function setRole($role){
        $this->role = $role;
    }
    
    public function getRole()
    {
        return $this->role;
    }
}
