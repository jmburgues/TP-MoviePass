<?php
    namespace DB\Interfaces;
    use models\Cinema as Cinema;
    
    interface IDAOCinema {

        function add(Cinema $cinema);
        function getAll();
    }
?>
