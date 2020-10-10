<?php

namespace DAO;

use Models\User as User;

class DAOUser
{
    private $users;

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
        $jsonPath = $this->getJsonFilePath();
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($jsonPath, $jsonContent);
    }

    private function retrieveData()
    {
        $this->users = array();

        $jsonPath = $this->getJsonFilePath();

        $jsonContent = file_get_contents($jsonPath);

        $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

        foreach ($arrayToDecode as $valueArray) {
            $user = new User($valueArray['userName'], $valueArray['password'],
            $valueArray['email'], $valueArray['birthDate'], $valueArray['DNI'],
            $valueArray['admin']);

            array_push($this->users, $user);
        }
    }

    private function getJsonFilePath()
    {
        $jsonFilePath = ROOT."Data/User.json";
        if (!file_exists($jsonFilePath))
            file_put_contents($jsonFilePath, "");
        return $jsonFilePath;
    }
}

?>