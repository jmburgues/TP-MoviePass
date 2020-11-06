<?php
    namespace Controllers;
    use DB\PDO\DAOTransaction as DAOTransaction;
    use DB\PDO\DAOTicket as DAOTicket;

    use Models\Transaction as Transaction;  
    use Models\Ticket as Ticket;  

    class SaleController{
        private $DAOTransaction;
        private $DAOTicket;

        public function __construct(){
            $this->DAOTransaction = new DAOTransaction();
            $this->DAOTicket = new DAOTicket();
        }
        
        //getAll de transacciones, muestra todas las transacciones. 
        public function showSales(){
            ViewController::navView($genreList=null,$moviesYearList=null,null);
            $transactions = $this->DAOTransaction->getAllTransactions();
           // print_r($transactions);
            $tickets = $this->getTickets();
            include VIEWS_PATH.'adminSales.php';
    }

        //getAll de tickets, muestra todas las tickets. 
        public function getTickets(){
            ViewController::navView($genreList=null,$moviesYearList=null,null);
            $tickets = $this->DAOTicket->getAllTickets();
            return $tickets;
        }

}

    ?>
