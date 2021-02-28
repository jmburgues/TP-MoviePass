<?php
  namespace DB\PDO;

  use \Exception as Exception;
  use Models\Cinema as Cinema;
  use DB\PDO\Connection as Connection;
  use DB\Interfaces\IDAOCinema as IDAOCinema;

  class DAOCinema implements IDAOCinema{
    private $connection;
    private $tableName ='CINEMAS';

    //INSERT INTO CINEMAS
    public function add(Cinema $cinema){
      try{
        $query = "INSERT INTO ".$this->tableName." 
        (cinemaName,adress,adressNumber,openning,closing,isActive)
        values
        (:name, :address, :number,:openning, :closing, :active);";

        $parameters['name'] = $cinema->getName();
        $parameters['address'] = $cinema->getAddress();
        $parameters['number'] = $cinema->getNumber();
        $parameters['openning'] = $cinema->getOpenning();
        $parameters['closing'] = $cinema->getClosing();
        $parameters['active'] = $cinema->getActive();

        $this->connection = Connection::GetInstance();

        return $this->connection->ExecuteNonQuery($query, $parameters);
      }

      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }

    //SET isActive = 0
    public function removeCinema($id){
      try{
        $query = "Update ".$this->tableName. " SET isActive = :active WHERE idCinema = :id;";
        
        $parameters['id'] = $id;
        $parameters['active'] = 0;
        
        $this->connection = Connection::GetInstance();
        return $this->connection ->ExecuteNonQuery($query,$parameters);
      }

      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }

    }

    //UPDATE CINEMAS
    //query para modificar los cines, recibe un objeto tipo cine.
    public function modify(Cinema $cinema){
      try{
        $query = "UPDATE ".$this->tableName. " SET cinemaName = :name,
        adress = :address, adressNumber = :number ,
        openning = :openning , closing = :closing, isActive = :active 
        WHERE idCinema = :id;";   
        $parameters['id'] = $cinema->getId();
        $parameters['name'] = $cinema->getName();
        $parameters['address'] = $cinema->getAddress();
        $parameters['number'] = $cinema->getNumber();
        $parameters['openning'] = $cinema->getOpenning();
        $parameters['closing'] = $cinema->getClosing();
        $parameters['active'] = $cinema->getActive();
        $this->connection = Connection::GetInstance(); 
        return $this->connection->ExecuteNonQuery($query, $parameters);
      }
      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }

    
    //SELECT * FROM CINEMAS
    public function getAll(){
      try{
        $query = "SELECT * FROM ".$this->tableName;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);
        
        return $this->toArray($this->parseToObject($resultSet));
      }

      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }


    //SELECT * FROM CINEMAS WHERE id
    public function placeholderCinemaDAO($id){
        try{
          
          $query = "SELECT * FROM ".$this->tableName. " WHERE idCinema = :id";
          $parameters['id'] = $id;
          $this->connection = Connection::GetInstance();
          $resultSet = $this->connection->Execute($query,$parameters);
          $placeCinema = $this->parseToObject($resultSet);
          return $placeCinema;
        }
        catch(PDOException $ex)
        {
            $arrayOfErrors [] = $ex->getMessage();
            ViewController::errorView($arrayOfErrors);
        }
    }

    //SELECT * FROM CINEMAS WHERE isActive = 1
    public function getActiveCinemas(){
      try{
        $query = "SELECT * FROM ".$this->tableName. " WHERE isActive = :active";
        $parameters['active'] = true;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        $activeCinemas = $this->toArray($this->parseToObject($resultSet));
        return $activeCinemas;
      }
      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }

    public function getOpenCinemas($starting){
      try{
        $query = "SELECT * FROM ".$this->tableName. " WHERE isActive = :active AND openning <= :starting;";
        $parameters['active'] = true;
        $parameters['starting'] = $starting;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        $activeCinemas = $this->toArray($this->parseToObject($resultSet));
        return $activeCinemas;
      }
      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }

    //SELECT * FROM CINEMAS WHERE id
    public function getById($id){
      $query= "SELECT * FROM ".$this->tableName." WHERE idCinema = :id;";
      $parameters['id'] = $id;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query,$parameters);

      return $this->parseToObject($resultSet);
    }

    protected function parseToObject($value) {
			$value = is_array($value) ? $value : [];
			$resp = array_map(function($p){
      
				return new Cinema ($p['cinemaName'],$p['adress'],$p['adressNumber'],$p['openning'],$p['closing'],$p['isActive'],$p['idCinema']);
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


/*
placeholderCinemaDAO() y getById() cumplen la misma función, cambiar las llamadas de la primera por getById();
*/

?>


