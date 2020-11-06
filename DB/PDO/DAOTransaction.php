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
/*
    public function p_add_transaction($username, $dateTransaction, $p_idTRansaction)    {
        try 
        {
            $query = "CREATE PROCEDURE p_add_transaction (:username VARCHAR(20), :dateTransaction DateTime, OUT ".$p_idTRansaction." INT BEGIN INSERT INTO ".$this->tableNameTransaction." (username, transacctionDate ) VALUES (:username, :dateTransaction); SET ".$p_idTRansaction." = LAST_INSERT_ID(); END; $$";
            
            
            $parameters['username'] = $username;
            $parameters['dateTransaction'] = $dateTransaction;

            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
    
            return $p_idTRansaction;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }
*/
    

    public function p_add_transaction($transaction){
        try{
            $query = "CALL p_add_transaction (". ":username" .",". ":dateTransaction" ."," ." @out);";
            $parameters['username'] = $transaction->getUserName();
            $parameters['dateTransaction'] = $transaction->getDate();

            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
            return $response;
            }
            catch(Exception $ex){
            throw $ex;
            }
        }

    public function call(){
        try{
            $query = "SELECT @out;";
            
            $this->connection = Connection::GetInstance();
            $response = $this->connection->execute($query);
            return $response[0][0];
            }
            catch(Exception $ex){
            throw $ex;
            }
    }

}
?>