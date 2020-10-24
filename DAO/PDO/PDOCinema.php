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
        (cinemaName,adress,adressNumber,openning,closing,ticketValue,isActive)
        values
        (:name, :address, :number,:openning, :closing, :ticketValue, :active);";

        $parameters['name'] = $cinema->getName();
        $parameters['address'] = $cinema->getAddress();
        $parameters['number'] = $cinema->getNumber();
        $parameters['openning'] = $cinema->getOpenning();
        $parameters['closing'] = $cinema->getClosing();
        $parameters['ticketValue'] = $cinema->getTicketValue();
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
        $query = "UPDATE ".$this->tableName. " SET cinemaName = :name, adress = :address, adressNumber = :number , openning = :openning , closing = :closing , ticketValue = :ticketValue 
        WHERE idCinema = :id;";
        
        $parameters['id'] = $cinema->getId();
        
        $parameters['name'] = $cinema->getName();
        $parameters['address'] = $cinema->getAddress();
        $parameters['number'] = $cinema->getNumber();
        $parameters['openning'] = $cinema->getOpenning();
        $parameters['closing'] = $cinema->getClosing();
        $parameters['ticketValue'] = $cinema->getTicketValue();

        $this->connection = Connection::GetInstance(); 
        return $this->connection->ExecuteNonQuery($query, $parameters);
      }
      catch(Exception $ex)
      {
        throw $ex;
      }
    }

    
  }
?>