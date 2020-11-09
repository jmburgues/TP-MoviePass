<?php
    namespace Controllers;
    use DB\PDO\DAOTransaction as DAOTransaction;
    use DB\PDO\DAOTicket as DAOTicket;
    use DB\PDO\DAOCinema as DAOCinema;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    use DB\PDO\DAORoom as DAORoom;


    use Models\Transaction as Transaction;  
    use Models\Ticket as Ticket;  
    use Models\Cinema as Cinema;  
    use Models\Movie as Movie;  
    use Models\Show as Show;
    use Models\Room as Room;  



    class SaleController{
        private $DAOTransaction;
        private $DAOTicket;
        private $DAOCinema;
        private $DAOMovie;
        private $DAOShow;
        private $DAORoom;


        public function __construct(){
            $this->DAOTransaction = new DAOTransaction();
            $this->DAOTicket = new DAOTicket();
            $this->DAOCinema = new DAOCinema();
            $this->DAOMovie = new DAOMovie();
            $this->DAOShow = new DAOShow();
            $this->DAORoom = new DAORoom();
        }
        
        //getAll de transacciones, muestra todas las transacciones. 
        public function showSales($inferiorInterval = null, $superiorInterval = null){
            ViewController::navView($genreList=null,$moviesYearList=null,null);
            $transactions = $this->DAOTransaction->getAllTransactions();
            $totalTicketsAmount = 0;
            $totalCostSold = 0;

            foreach($transactions as $t){
                $totalCostSold =  $totalCostSold + ($t->getCostPerTicket() * $t->getTicketAmount());
            }
            foreach($transactions as $t){
                $totalTicketsAmount =  $totalTicketsAmount +  $t->getTicketAmount();
            }
            
            $costs = $totalCostSold;
            $tickets = $totalTicketsAmount;
            
            
            $shows = $this->DAOShow->getAll();
            $ticketByShow = array();
            
            $i = 0;

            foreach ($shows as $show) {
                $ticketAmount = 0;
                $ticketSold = 0;
                $unsoldTickets = $show->getRoom()->getCapacity();

                foreach ($this->DAOTicket->getTicketsByShow($show->getIdShow()) as $corn) {
                    $ticketAmount += $corn->getTransaction()->getTicketAmount();
                    $ticketSold += ($corn->getTransaction()->getCostPerTicket()) * $ticketAmount;
                    $unsoldTickets -= $ticketAmount;
                }
                $ticketByShow[$i]['nameShow'] = $show->getMovie()->getTitle();
                $ticketByShow[$i]['ticketSold'] = $ticketSold;
                $ticketByShow[$i]['ticketAmount'] = $ticketAmount;
                $ticketByShow[$i]['unsoldTickets'] = $unsoldTickets;
                $i++;
            }


            
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
