<?php
  namespace dao\pdo;

  use \Exception as Exception;
  use models\User as User;
  use DAO\PDO\Connection as Connection;

  class PDOUser{
    private $connection;
    private $tableName ='users';

    public function add($user){
      try{
        $query = "INSERT INTO ".$this->tableName." (username,pass,email,birthdate,dni,isAdmin)
        values(:userName, :password, :email,:birthDate, :dni, :admin);";

        $parameters['userName'] = $newUser->getUserName();
        $parameters['password'] = $newUser->getPassword();
        $parameters['email'] = $newUser->getEmail();
        $parameters['birthDate'] = $newUser->getBirthDate();
        $parameters['dni'] = $newUser->getDNI();
        $parameters['admin'] = $newUser->isAdmin();

        $this->connection = Connection::GetInstance();

        return $this->connection->ExecuteNonQuery($query, $parameters);
      }

      catch(Exception $ex){
        throw $ex;
      }

    }

    public function getAll(){
      try{
        $query = "SELECT * FROM ".$this->tableName;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);
        
        return $this->parseToObject($resultSet);
      }

      catch(Exception $ex){
        throw $ex;
      }

    }

    public function getByEmail($email){
      try{
        $query = "SELECT * FROM ".$this->tableName." where email = :email";
        $parameters['email'] = $email;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $this->parseToObject($resultSet);
      }

      catch(Exception $ex){
        throw $ex;
      }
      
    }
  }
?>