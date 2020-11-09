<?php
    namespace DB\PDO;

    use \Exception as Exception;
    use Models\Ticket as Ticket;
    use DB\PDO\Connection as Connection;
    use Models\Show as Show;
    use DB\PDO\DAOShow as DAOShow;
    use Models\Transaction as Transaction;
    use DB\PDO\DAOTransaction as DAOTransaction;
    use DB\Interfaces\IDAOShow as IDAOShow;


    class DAOTicket{
        private $connection;
        private $tableNameTicket = "TICKETS";
        private $tableNameShow = "SHOWS";
        private $tableNameTransaction = "TRANSACTIONS";
        private $tableNameUser = "USERS";
        private $tableNameCinema = "CINEMAS";
        private $tableNameRoom = "ROOMS";
    
    

        //Ingresa un nuevo ticket en la table TICKETS
        public function add($ticket)    {
            try 
            {
                $query = "INSERT INTO ".$this->tableNameTicket."
                (qrCode, idShow, idTransaction )
                values
                (:QRCode, :idShow, :idTransaction);";
                
                $parameters['QRCode'] = $ticket->getQRCode();
                $parameters['idShow'] = $ticket->getShow()->getIdShow();
                $parameters['idTransaction'] = $ticket->getTransaction()->getIdTransaction();

                $this->connection = Connection::GetInstance();
                $response = $this->connection->ExecuteNonQuery($query, $parameters);
                
                $query2 = "UPDATE " .$this->tableNameShow . " SET spectators = spectators+1 WHERE idShow = :idShow;";
                $parameters2['idShow'] = $ticket->getShow()->getIdShow();
                
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query2, $parameters2);

                return $response;
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

    //Retorna todos los tickets en la tabla
    public function getAllTickets(){
        
        try{
            $query = "SELECT * FROM ".$this->tableNameTicket;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
        
            return $resultSet;
            }
            catch(Exception $ex){
            throw $ex;
            }
    }

/*SELECT TICKETS .* 
	FROM
		TICKETS INNER JOIN SHOWS ON TICKETS.idShow = SHOWS.idShow
		INNER JOIN ROOMS ON SHOWS.idRoom = ROOMS.idRoom
		INNER JOIN CINEMAS ON ROOMS.idCinema = CINEMAS.idCinema
	WHERE 
        TICKETS.idShow = 1; */
        
    public function getTicketsByShow($idShow){
        try{
                $query = "SELECT ". $this->tableNameTicket .".* 
                FROM ". $this->tableNameTicket ." INNER JOIN ". 
                $this->tableNameShow . " ON ". $this->tableNameTicket .".idShow =  ". $this->tableNameShow .".idSHow".
                " INNER JOIN ". $this->tableNameRoom ." ON ". $this->tableNameShow .".idRoom = " . $this->tableNameRoom .".idRoom".
                " INNER JOIN ". $this->tableNameCinema ." ON ". $this->tableNameRoom .".idCinema = ". $this->tableNameCinema .".idCinema
                WHERE ". $this->tableNameTicket .".idShow = :idShow
                GROUP BY ". $this->tableNameTicket .".idTransaction;";
            
                $parameters['idShow'] = $idShow;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query,$parameters);
                
                return $this->toArray($this->parseToObject($resultSet));
            }
            catch(Exception $ex){
                throw $ex;
            }
        }


    public function parseToObject($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){
            
            $DAOShow = new DAOShow();
            $show = $DAOShow->getById($p['idShow']);

            $DAOTransaction = new DAOTransaction();
            $transaction = $DAOTransaction->getById($p['idTransaction']);
        
            return new Ticket ($show, $transaction, $p['qrCode'], $p['idTicket']);
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