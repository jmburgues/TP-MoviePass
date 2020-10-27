<?php
  namespace DAO\PDO;

  use \Exception as Exception;
  use Models\Cinema as Cinema;
  use DAO\PDO\Connection as Connection;

  class PDOCinema{
    private $connection;
    private $tableName ='CINEMAS';

    public function add($cinema){
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

      catch(Exception $ex){
        throw $ex;
      }

    }

    public function removeCinema($id){
      try{
        $query = "Update ".$this->tableName. " SET isActive = :active WHERE idCinema = :id;";
        
        $parameters['id'] = $id;
        $parameters['active'] = false;
        
        $this->connection = Connection::GetInstance();
        return $this->connection ->ExecuteNonQuery($query,$parameters);
      }

      catch(Exception $ex){
          throw $ex;
      }

    }

    public function modify(Cinema $cinema){
      try{
        $query = "UPDATE ".$this->tableName. " SET cinemaName = :name, adress = :address, adressNumber = :number ,
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
      catch(Exception $ex)
      {
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


    public function placeholderCinemaDAO($id){
        try{
          
          $query = "SELECT * FROM ".$this->tableName. " WHERE idCinema = :id";
          $parameters['id'] = $id;
          $this->connection = Connection::GetInstance();
          $resultSet = $this->connection->Execute($query,$parameters);
          $placeCinema = $this->parseToObject($resultSet);
          return $placeCinema;
        }
        catch(Exception $ex){
          throw $ex;
        }
    }


    public function getActiveCinemas(){
      try{
        $query = "SELECT * FROM ".$this->tableName. " WHERE isActive = :active";
        $parameters['active'] = true;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        $activeCinemas = $this->parseToObject($resultSet);
        return $activeCinemas;
      }
      catch(Exception $ex){
        throw $ex;
      }
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
  }
?>