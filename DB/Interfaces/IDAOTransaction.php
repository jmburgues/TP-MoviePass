<?php
    namespace DB\Interfaces;
    use models\Transaction as Transaction;
    
    interface IDAOTransaction {

        function add(Transaction $transaction);
        function getAll();
    }
?>
