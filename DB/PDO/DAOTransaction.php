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
        try{
            $query = "CALL p_add_transaction (". ":username" .",". ":dateTransaction" ."," . ":ticketAmount" .",". ":costPerTicket" ."," ." @out);";
            $parameters['username'] = $transaction->getUser()->getUserName();
            $parameters['dateTransaction'] = $transaction->getDate();
            $parameters['ticketAmount'] = $transaction->getTicketAmount();
            $parameters['costPerTicket'] = $transaction->getCostPerTicket();
        

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
            $query = "SELECT * FROM ".$this->tableNameTransactions;
            
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            return $this->parseToObject($resultSet);
            }
            catch(Exception $ex){
            throw $ex;
            }
    } 

    //Retorna la tabla de usuarios, transacciones y tickets según el nmbre de un usuario.
    public function getTransactionsByUser($user){
        try{
            $query = "SELECT * FROM ".$this->tableNameUsers ." INNER JOIN ". $this->tableNameTransactions ." ON ". $this->tableNameUsers .".username = ". $this->tableNameTransactions .".username INNER JOIN ". $this->tableNameTickets ." ON ". $this->tableNameTransactions .".idTransaction = ". $this->tableNameTickets .".idTransaction WHERE " .$this->tableNameUsers .".username = :name GROUP BY " . $this->tableNameTransactions .".idTransaction;";
            
            $parameters['name'] = $user->getUserName();
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            return $resultSet;
            }
            catch(Exception $ex){
            throw $ex;
            }
    } 
    
    public function getById($id){
        try{
            $query = "SELECT * FROM ".$this->tableNameTransactions." where idTransaction = :id";
            $parameters['id'] = $id;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            return $this->parseToObject($resultSet);
        }
        catch(Exception $ex){
            throw $ex;
        }
    }


    //Retorna las transacciones según el cine.
    public function getTransactionsByCinema($cinema){
        try{
        /*   SELECT tr.*, c.cinemaName FROM TRANSACTIONS as tr INNER JOIN TICKETS as tk ON tr.idTransaction = tk.idTransaction 
            INNER JOIN SHOWS as sh ON tk.idShow = sh.idShow INNER JOIN  ROOMS as r ON sh.idRoom = r.idRoom INNER JOIN CINEMAS as c 
            ON r.idCinema = c.idCinema WHERE c.idCinema = 1 GROUP BY tr.idTransaction;
*/
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
            catch(Exception $ex){
            throw $ex;
            }
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
}

?>

