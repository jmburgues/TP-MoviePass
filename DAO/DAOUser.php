<?php

namespace DAO;

use Models\User as User;

class DAOUser
{
    private $users;
    private $fileName = ROOT."Data/users.json";

    public function add($user)
    {
        $this->retrieveData();
        array_push($this->users, $user);
        $this->saveData();
    }

    public function getAll()
    {
        $this->retrieveData();
        return $this->users;
    }

    public function getByUserName($userName)
    {
        $this->retrieveData();

        foreach ($this->users as $user) {
            if ($user->getUserName() == $userName) {

                return $user;
            }
        }
    }

    private function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->users as $user) {
            $valueArray['userName'] = $user->getUserName();
            $valueArray['password'] = $user->getPassword();
            $valueArray['email'] = $user->getEmail();
            $valueArray['birthDate'] = $user->getBirthDate();
            $valueArray['DNI'] = $user->getDNI();
            $valueArray['admin'] = $user->isAdmin();
            
            array_push($arrayToEncode, $valueArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

    private function retrieveData()
    {
        $this->users = array();

        if(file_exists($this->fileName)){
            $jsonContent = file_get_contents($this->fileName);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valueArray) {
                $user = new User($valueArray['userName'], $valueArray['password'],
                $valueArray['email'], $valueArray['birthDate'], $valueArray['DNI'],
                $valueArray['admin']);

                array_push($this->users, $user);
            }
        }
    }
}

?>