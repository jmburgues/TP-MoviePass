<?php
  namespace DAO\PDO;

  use \Exception as Exception;
  use Models\User as User;
  use DAO\PDO\Connection as Connection;

  class PDOUser{
    private $connection;
    private $tableName ='users';

    public function add($user){
      try{
        $query = "INSERT INTO ".$this->tableName." (username,pass,email,birthdate,dni,isAdmin)
        values(:userName, :password, :email,:birthDate, :dni, :admin);";

        $parameters['userName'] = $user->getUserName();
        $parameters['password'] = $user->getPassword();
        $parameters['email'] = $user->getEmail();
        $parameters['birthDate'] = $user->getBirthDate();
        $parameters['dni'] = $user->getDNI();
        $parameters['admin'] = $user->isAdmin();

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

    protected function parseToObject($value) {
			$value = is_array($value) ? $value : [];
			$resp = array_map(function($p){
      
				return new User ($p['username'],$p['pass'],$p['email'],$p['birthdate'],$p['dni'],$p['isAdmin']);
        }, $value);
        
      if(empty($resp)){
        return $resp;
      }
      else {
        return count($resp) > 1 ? $resp : $resp['0'];
      }
		}
  }
?>