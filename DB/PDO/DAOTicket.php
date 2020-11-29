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

        //Retorna todos los tickets en la tabla
        public function getAllTickets(){
            $query = "SELECT * FROM ".$this->tableNameTicket;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
        
            return $resultSet;
        }
       
        public function getTicketsByShow($idShow){
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

        public function getTicketsByCinema($idCinema){
            $query = "SELECT ". $this->tableNameTicket .".* FROM ". $this->tableNameTicket ." INNER JOIN ". 
            $this->tableNameShow . " ON ". $this->tableNameTicket .".idShow =  ". $this->tableNameShow .".idSHow".
            " INNER JOIN ". $this->tableNameRoom ." ON ". $this->tableNameShow .".idRoom = " . $this->tableNameRoom .".idRoom".
            " INNER JOIN ". $this->tableNameCinema ." ON ". $this->tableNameRoom .".idCinema = ". $this->tableNameCinema .".idCinema
            WHERE ". $this->tableNameRoom .".idCinema = :idCinema
            GROUP BY ". $this->tableNameTicket .".idTransaction;";
        
            $parameters['idCinema'] = $idCinema;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            return $this->toArray($this->parseToObject($resultSet));
        }

        public function getTicketsByRoom($idRoom){
            $query = "SELECT ". $this->tableNameTicket .".* FROM ". $this->tableNameTicket ." INNER JOIN ". 
            $this->tableNameShow . " ON ". $this->tableNameTicket .".idShow =  ". $this->tableNameShow .".idSHow".
            " INNER JOIN ". $this->tableNameRoom ." ON ". $this->tableNameShow .".idRoom = " . $this->tableNameRoom .".idRoom".
            " INNER JOIN ". $this->tableNameCinema ." ON ". $this->tableNameRoom .".idCinema = ". $this->tableNameCinema .".idCinema
            WHERE ". $this->tableNameRoom .".idRoom = :idRoom
            GROUP BY ". $this->tableNameTicket .".idTransaction;";
        
            $parameters['idRoom'] = $idRoom;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            return $this->toArray($this->parseToObject($resultSet));
        }

        public function getTicketsByShowBetween($idShow, $firstDate, $lastDate){
            $query = "SELECT ". $this->tableNameTicket .".* 
            FROM ". $this->tableNameTicket ." INNER JOIN ". 
            $this->tableNameShow . " ON ". $this->tableNameTicket .".idShow =  ". $this->tableNameShow .".idSHow".
            " INNER JOIN ". $this->tableNameRoom ." ON ". $this->tableNameShow .".idRoom = " . $this->tableNameRoom .".idRoom".
            " INNER JOIN ". $this->tableNameCinema ." ON ". $this->tableNameRoom .".idCinema = ". $this->tableNameCinema .".idCinema 
            WHERE ". $this->tableNameTicket .".idShow = :idShow AND ".$this->tableNameShow.".dateSelected BETWEEN :firstDate AND :lastDate 
            GROUP BY ". $this->tableNameTicket .".idTransaction;";
        
            $parameters['idShow'] = $idShow;
            $parameters['firstDate'] = $firstDate;
            $parameters['lastDate'] = $lastDate;
            
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            return $this->toArray($this->parseToObject($resultSet));
        }

        public function getTicketsByCinemaBetween($idCinema, $firstDate, $lastDate){
            $query = "SELECT ". $this->tableNameTicket .".* FROM ". $this->tableNameTicket ." INNER JOIN ". 
            $this->tableNameShow . " ON ". $this->tableNameTicket .".idShow =  ". $this->tableNameShow .".idSHow".
            " INNER JOIN ". $this->tableNameRoom ." ON ". $this->tableNameShow .".idRoom = " . $this->tableNameRoom .".idRoom".
            " INNER JOIN ". $this->tableNameCinema ." ON ". $this->tableNameRoom .".idCinema = ". $this->tableNameCinema .".idCinema 
            WHERE ". $this->tableNameCinema .".idCinema = :idCinema AND ".$this->tableNameShow.".dateSelected BETWEEN :firstDate AND :lastDate 
            GROUP BY ". $this->tableNameTicket .".idTransaction;";
        
            $parameters['idCinema'] = $idCinema;
            $parameters['firstDate'] = $firstDate;
            $parameters['lastDate'] = $lastDate;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            return $this->toArray($this->parseToObject($resultSet));
        }

        public function getTicketsByRoomBetween($idRoom, $firstDate, $lastDate){
            $query = "SELECT ". $this->tableNameTicket .".* FROM ". $this->tableNameTicket ." INNER JOIN ". 
            $this->tableNameShow . " ON ". $this->tableNameTicket .".idShow =  ". $this->tableNameShow .".idSHow".
            " INNER JOIN ". $this->tableNameRoom ." ON ". $this->tableNameShow .".idRoom = " . $this->tableNameRoom .".idRoom".
            " INNER JOIN ". $this->tableNameCinema ." ON ". $this->tableNameRoom .".idCinema = ". $this->tableNameCinema .".idCinema 
            WHERE ". $this->tableNameRoom .".idRoom = :idRoom AND ".$this->tableNameShow.".dateSelected BETWEEN :firstDate AND :lastDate 
            GROUP BY ". $this->tableNameTicket .".idTransaction;";
        
            $parameters['idRoom'] = $idRoom;
            $parameters['firstDate'] = $firstDate;
            $parameters['lastDate'] = $lastDate;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            return $this->toArray($this->parseToObject($resultSet));
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