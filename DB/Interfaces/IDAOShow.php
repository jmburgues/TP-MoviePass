<?php
    namespace DB\Interfaces;
    use models\Show as Show;
    
    interface IDAOShow {

        function add(Show $Show);
        function getAll();
    }
?>
