<?php
  namespace DB\PDO;

  use \Exception as Exception;
  use Models\User as User;
  use DB\PDO\Connection as Connection;
  use DB\Interfaces\IDAOUser as IDAOUser;

  class DAOUser implements IDAOUser{
    private $connection;
    private $tableName ='USERS';

    public function add(User $user){
      $query = "INSERT INTO ".$this->tableName." (username,pass,email,birthdate,dni,userRole)
      values(:userName, :password, :email,:birthDate, :dni, :userRole);";

      $parameters['userName'] = $user->getUserName();
      $parameters['password'] = $user->getPassword();
      $parameters['email'] = $user->getEmail();
      $parameters['birthDate'] = $user->getBirthDate();
      $parameters['dni'] = $user->getDNI();
      $parameters['userRole'] = $user->getRole();

      $this->connection = Connection::GetInstance();

      return $this->connection->ExecuteNonQuery($query, $parameters);
    }

    public function changeRole($userName,$userRole){
      $query = "UPDATE ".$this->tableName." SET userRole = :userRole WHERE userName = :userName;";

      $parameters['userName'] = $userName;
      $parameters['userRole'] = $userRole;

      $this->connection = Connection::GetInstance();

      return $this->connection->ExecuteNonQuery($query, $parameters);
    }

    public function getAll(){
      $query = "SELECT * FROM ".$this->tableName;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);
      
      return $this->toArray($this->parseToObject($resultSet));
    }

    public function getByUserName($name){
      $query = "SELECT * FROM ".$this->tableName." where username = :name";
      $parameters['name'] = $name;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query,$parameters);
      
      return $this->parseToObject($resultSet);
    }

    public function getByEmail($email){
      $query = "SELECT * FROM ".$this->tableName." where email = :email";
      $parameters['email'] = $email;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query,$parameters);
      
      return $this->parseToObject($resultSet);    
    }

    public function getByDni($dni){
      $query = "SELECT * FROM ".$this->tableName." where dni = :dni";
      $parameters['dni'] = $dni;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query,$parameters);
      
      return $this->parseToObject($resultSet);    
    }

    public function parseToObject($value) {
			$value = is_array($value) ? $value : [];
			$resp = array_map(function($p){
      
				return new User ($p['username'],$p['pass'],$p['email'],$p['birthdate'],$p['dni'],$p['userRole']);
        }, $value);
        
      if(empty($resp)){
        return $resp;
      }
      else {
        return count($resp) > 1 ? $resp : $resp['0'];
      }
    }
    
    private function toArray($value){
      if(is_array($value))
        return $value;
      else
        return array($value);
    }

  }
?>