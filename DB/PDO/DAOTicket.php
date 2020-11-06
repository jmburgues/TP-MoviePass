<?php
  namespace DB\PDO;

  use \Exception as Exception;
  use Models\Ticket as Ticket;
  use DB\PDO\Connection as Connection;


  class DAOTicket{
    private $connection;
    private $tableNameTicket = "Ticket";

    public function add($ticket)    {
        try 
        {
            $query = "INSERT INTO ".$this->tableNameTicket."
            (qrCode, idShow, idTransaction )
            values
            (:QRCode, :idShow, :idTransaction);";
            
            $parameters['QRCode'] = $ticket->getQRCode();
            $parameters['idShow'] = $ticket->getIdShow();
            $parameters['idTransaction'] = $ticket->getTdTransaction();

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
            $query = "SELECT * FROM ".$this->tableNameTicket;
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