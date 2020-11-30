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

  use \Exception as Exception;

  use \DateTime as DateTime;
  use \DateTimeZone as DateTimeZone;

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
    public function showSales($firstDate="", $lastDate=""){
      if(AuthController::validate('admin')){
        try {
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          #LADO SIN BETWEEN#######################################################################################################################
          if ((empty($firstDate)) && (empty($lastDate))){
            $transactions = $this->DAOTransaction->getAllTransactions();
            $totalTicketsAmount = 0;
            $totalCostSold = 0;
            foreach($transactions as $t){
              $totalCostSold =  $totalCostSold + ($t->getCostPerTicket() * $t->getTicketAmount());
              $totalTicketsAmount =  $totalTicketsAmount +  $t->getTicketAmount();
            }

            $costs = $totalCostSold;
            $tickets = $totalTicketsAmount;
            
            #por Show
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
              $ticketByShow[$i]['dateShow'] = $show->getDate();
              $ticketByShow[$i]['ticketSold'] = $ticketSold;
              $ticketByShow[$i]['ticketAmount'] = $ticketAmount;
              $ticketByShow[$i]['unsoldTickets'] = $unsoldTickets;
              $i++;
            }
              
            #por Cinema
            $cinemas = $this->DAOCinema->getAll();
            $ticketByCinema = array();
            $i = 0;
              
            foreach ($cinemas as $cinema) {
              $ticketAmount = 0;
              $ticketSold = 0;
              $unsoldTickets = $this->DAOShow->getCapacityByCinema($cinema->getId());
                
              foreach ($this->DAOTicket->getTicketsByCinema($cinema->getId()) as $corn) {
                $ticketAmount += $corn->getTransaction()->getTicketAmount();
                $ticketSold += ($corn->getTransaction()->getCostPerTicket()) * $ticketAmount;
                $unsoldTickets -= $ticketAmount;
              }

              $ticketByCinema[$i]['nameCinema'] = $cinema->getName();
              $ticketByCinema[$i]['ticketSold'] = $ticketSold;
              $ticketByCinema[$i]['ticketAmount'] = $ticketAmount;
              $ticketByCinema[$i]['unsoldTickets'] = $unsoldTickets;
              $i++;
            }
              
            #por Sala
            $rooms = $this->DAORoom->getAll();
            $ticketByRoom = array();
            $i = 0;
              
            foreach ($rooms as $room) {
              $ticketAmount = 0;
              $ticketSold = 0;
              $unsoldTickets = $this->DAOShow->getCapacityByRoom($room->getId());
                
              foreach ($this->DAOTicket->getTicketsByRoom($room->getId()) as $corn) {
                $ticketAmount += $corn->getTransaction()->getTicketAmount();
                $ticketSold += ($corn->getTransaction()->getCostPerTicket()) * $ticketAmount;
                $unsoldTickets -= $ticketAmount;
              }

              $ticketByRoom[$i]['nameCinema'] = $room->getCinema()->getName();
              $ticketByRoom[$i]['nameRoom'] = $room->getName();
              $ticketByRoom[$i]['ticketSold'] = $ticketSold;
              $ticketByRoom[$i]['ticketAmount'] = $ticketAmount;
              $ticketByRoom[$i]['unsoldTickets'] = $unsoldTickets;
              $i++;
            }
          #LADO CON BETWEEN#######################################################################################################################
          }elseif ((!empty($firstDate)) && (!empty($lastDate))) {
            if ($firstDate < $lastDate){
              $firstDate = new DateTime($firstDate);
              $firstDate = $firstDate->format('Y-m-d');
              $lastDate = new DateTime($lastDate);
              $lastDate = $lastDate->format('Y-m-d');
              $transactions = $this->DAOTransaction->getAllTransactionsBetweenDates($firstDate,$lastDate);
              $totalTicketsAmount = 0;
              $totalCostSold = 0;
              foreach($transactions as $t){
                $totalCostSold =  $totalCostSold + ($t->getCostPerTicket() * $t->getTicketAmount());
                $totalTicketsAmount =  $totalTicketsAmount +  $t->getTicketAmount();
              }
              
              $costs = $totalCostSold;
              $tickets = $totalTicketsAmount;
              
              #por Cinema
              $cinemas = $this->DAOCinema->getAll();
              $ticketByCinema = array();
              $i = 0;
                
              foreach ($cinemas as $cinema) {
                $ticketAmount = 0;
                $ticketSold = 0;
                $unsoldTickets = $this->DAOShow->getCapacityByCinemaBetween($cinema->getId(),$firstDate,$lastDate);
                  
                foreach ($this->DAOTicket->getTicketsByCinemaBetween($cinema->getId(),$firstDate,$lastDate) as $corn) {
                  $ticketAmount += $corn->getTransaction()->getTicketAmount();
                  $ticketSold += ($corn->getTransaction()->getCostPerTicket()) * $ticketAmount;
                  $unsoldTickets -= $ticketAmount;
                }
                $ticketByCinema[$i]['nameCinema'] = $cinema->getName();
                $ticketByCinema[$i]['ticketSold'] = $ticketSold;
                $ticketByCinema[$i]['ticketAmount'] = $ticketAmount;
                $ticketByCinema[$i]['unsoldTickets'] = $unsoldTickets;
                $i++;
              }
                
              #por Sala
              $rooms = $this->DAORoom->getAll();
              $ticketByRoom = array();
              $i = 0;
                
              foreach ($rooms as $room) {
                $ticketAmount = 0;
                $ticketSold = 0;
                $unsoldTickets = $this->DAOShow->getCapacityByRoomBetween($room->getId(),$firstDate,$lastDate);
                  
                foreach ($this->DAOTicket->getTicketsByRoomBetween($room->getId(),$firstDate,$lastDate) as $corn) {
                  $ticketAmount += $corn->getTransaction()->getTicketAmount();
                  $ticketSold += ($corn->getTransaction()->getCostPerTicket()) * $ticketAmount;
                  $unsoldTickets -= $ticketAmount;
                }

                $ticketByRoom[$i]['nameCinema'] = $room->getCinema()->getName();
                $ticketByRoom[$i]['nameRoom'] = $room->getName();
                $ticketByRoom[$i]['ticketSold'] = $ticketSold;
                $ticketByRoom[$i]['ticketAmount'] = $ticketAmount;
                $ticketByRoom[$i]['unsoldTickets'] = $unsoldTickets;
                $i++;
              }
            } else {
              $msg = "intervalo invalido: Fin del intervalo anterior al inicio";
              throw new Exception($msg);
            }
          } else {
            $msg = "intervalo invalido: Falta una fecha";
            throw new Exception($msg);
          }
        include VIEWS_PATH.'adminSales.php';
      } 
      catch (PDOException $ex){
        $arrayOfErrors [] = $ex->getMessage();
        ViewController::errorView($arrayOfErrors);
      }
        
      }
    }

    //getAll de tickets, muestra todas las tickets. 
    public function getTickets(){
      ViewController::navView($genreList=null,$moviesYearList=null,null,null);
      $tickets = $this->DAOTicket->getAllTickets();
      return $tickets;
    }
  }
?>
