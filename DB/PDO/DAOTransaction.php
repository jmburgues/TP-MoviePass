<?php
  namespace DB\PDO;

  use \DateTime as DateTime;
  use \Exception as Exception;
  use Models\Transaction as Transaction;
  use Models\Tickets as Tickets;
  use Models\User as User;
  use DB\PDO\Connection as Connection;
  use DB\PDO\DAOUser as DAOUser;

  class DAOTransaction{
    private $connection;
    private $tableNameTransactions = "TRANSACTIONS";
    private $tableNameTickets = "TICKETS";
    private $tableNameUsers = "USERS";
    private $tableNameShows = "SHOWS";
    private $tableNameCinemas = "CINEMAS";
    private $tableNameRooms = "ROOMS";



    //Inserta una transacción en la tabla por medio de procedure  para obtener el ID
    public function p_add_transaction($transaction){
        // $query = "CALL p_add_transaction (". ":username" .",". ":dateTransaction" ."," . ":ticketAmount" .",". ":costPerTicket" ."," ." @out);";
        $query = "INSERT INTO ".$this->tableNameTransactions." (username, transacctionDate, ticketAmount, costPerTicket) VALUES (:username, :dateTransaction, :ticketAmount, :costPerTicket);";
        $parameters['username'] = $transaction->getUser()->getUserName();
        $parameters['dateTransaction'] = $transaction->getDate();
        $parameters['ticketAmount'] = $transaction->getTicketAmount();
        $parameters['costPerTicket'] = $transaction->getCostPerTicket();

        $this->connection = Connection::GetInstance();
        $response = $this->connection->ExecuteNonQuery($query, $parameters);
        return $response;
        }

    //Retorna el último ID agregado de transaction
    public function call($transacctionDate,$username){
        $query = "SELECT idTransaction FROM ".$this->tableNameTransactions." WHERE transacctionDate = :transDate && username =:username;";
        $parameters['transDate'] = $transacctionDate;
        $parameters['username'] = $username;

        $this->connection = Connection::GetInstance();
        $response = $this->connection->Execute($query, $parameters);
        return $response[0][0];
    }

     //Retorna todas las transacciones en la tabla
    public function getAllTransactions(){
        $query = "SELECT * FROM ".$this->tableNameTransactions;
        
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);

        return $this->toArray($this->parseToObject($resultSet));
    } 

    public function getAllTransactionsBetweenDates($firstDate, $lastDate){
        $query = "SELECT * FROM ".$this->tableNameTransactions." 
        WHERE ".$this->tableNameTransactions.".transacctionDate BETWEEN \"".$firstDate."\" AND \"".$lastDate."\"";

        #$parameters['firstDate'] = $firstDate;
        #$parameters['lastDate'] = $lastDate;
        
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);

        return $this->toArray($this->parseToObject($resultSet));
    } 

    //Retorna la tabla de usuarios, transacciones y tickets según el nmbre de un usuario.
    public function getTransactionsByUser($user){
        $query = "SELECT * FROM ".$this->tableNameUsers ." INNER JOIN ". $this->tableNameTransactions ." ON ". $this->tableNameUsers .".username = ". $this->tableNameTransactions .".username INNER JOIN ". $this->tableNameTickets ." ON ". $this->tableNameTransactions .".idTransaction = ". $this->tableNameTickets .".idTransaction WHERE " .$this->tableNameUsers .".username = :name GROUP BY " . $this->tableNameTransactions .".idTransaction ORDER BY ".$this->tableNameTransactions.".transacctionDate DESC;";
        $parameters['name'] = $user->getUserName();
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query, $parameters);
        return $this->parseToObject($resultSet);
    } 
    
    public function getById($id){
        $query = "SELECT * FROM ".$this->tableNameTransactions." where idTransaction = :id";
        $parameters['id'] = $id;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $this->parseToObject($resultSet);
    }

    //Retorna las transacciones según el cine.
    public function getTransactionsByCinema($cinema){
        $query = "SELECT SUM(" .$this->tableNameTransactions . ".costPerTicket * ". $this->tableNameTransactions . ".ticketAmount) AS ti 
        FROM " . $this->tableNameTransactions . 
        " INNER JOIN " .$this->tableNameTickets .
        " ON " . $this->tableNameTransactions . ".idTransaction = ". $this->tableNameTickets .".idTransaction INNER JOIN ". $this->tableNameShows. 
        " ON " . $this->tableNameTickets .".idShow = ". $this->tableNameShows .".idShow INNER JOIN ". $this->tableNameRooms .
        " ON " . $this->tableNameShows .".idRoom = ". $this->tableNameRooms .".idRoom INNER JOIN ".$this->tableNameCinemas. 
        " ON " . $this->tableNameRooms .".idCinema = " . $this->tableNameCinemas .".idCinema 
        WHERE " . $this->tableNameCinemas .".idCinema = :cinema GROUP BY ". $this->tableNameTransactions .".idTransaction;";
        
        $parameters['cinema'] = $cinema;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query, $parameters);
        return $resultSet;
    } 



    public function parseToObject($value) {  
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($p) {
            
            $DAOUser = new DAOUser();
            $user = $DAOUser->getByUserName($p['username']);
            return new Transaction($user, $p['transacctionDate'], $p['ticketAmount'], $p['costPerTicket'], $p['idTransaction']);
        }, $value);
    
        if (empty($resp)) {
            return $resp;
        } else {
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

