<?php
    namespace DB\PDO;

    use \Exception as Exception;
    use Models\Ticket as Ticket;
    use DB\PDO\Connection as Connection;


    class DAOTicket{
        private $connection;
        private $tableNameTicket = "TICKETS";
        private $tableNameShow = "SHOWS";

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

        public function parseToObject($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                return new Ticket ($p['qrCode'],$p['idShow'], $p['idTransaction'], $p['idTicket']);
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