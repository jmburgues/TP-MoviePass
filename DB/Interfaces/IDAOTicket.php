<?php
    namespace DB\Interfaces;
    use models\Ticket as Ticket;
    
    interface IDAOTicket {

        function add(Ticket $ticket);
        function getAll();
    }
?>
