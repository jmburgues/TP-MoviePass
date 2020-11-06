<?php
  namespace DB\PDO;

  use \DateTime as DateTime;
  use \Exception as Exception;
  use Models\Transaction as Transaction;
  use DB\PDO\Connection as Connection;


  class DAOTransaction{
    private $connection;
    private $tableNameTransaction = "TRANSACTIONS";

    public function add($transaction)    {
        try 
        {
            $query = "INSERT INTO ".$this->tableNameTransaction."
            (username, transacctionDate )
            values
            (:username, :date );";
            
            $parameters['username'] = $transaction->getUserName();
            $parameters['date'] = $transaction->getDate();

            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
            return $response;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function getAll(){
        try{
            $query = "SELECT * FROM ".$this->tableNameTransaction;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $resultSet;
            }
            catch(Exception $ex){
            throw $ex;
            }
        }

}
?>