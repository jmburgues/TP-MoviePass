<?php
  namespace DB\PDO;

  use \DateTime as DateTime;
  use \Exception as Exception;
  use Models\Transaction as Transaction;
  use DB\PDO\Connection as Connection;


  class DAOTransaction{
    private $connection;
    private $tableNameTransaction = "TRANSACTIONS";

    //Inserta una transacción en la tabla por medio de procedure  para obtener el ID
    public function p_add_transaction($transaction){
        try{
            $query = "CALL p_add_transaction (". ":username" .",". ":dateTransaction" ."," ." @out);";
            $parameters['username'] = $transaction->getUser()->getUserName();
            $parameters['dateTransaction'] = $transaction->getDate();

            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
            return $response;
            }
            catch(Exception $ex){
            throw $ex;
            }
        }

    //Retorna el último ID agregado de transaction
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

     //Retorna todas las transacciones en la tabla
    public function getAllTransactions(){
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


    public function parseToObject($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){
    
        return new Transaction ($p['username'], $p['transacctionDate'], $p['idTransaction']);
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

