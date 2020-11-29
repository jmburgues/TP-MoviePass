<?php
    namespace DB\Interfaces;
    use models\Room as Room;
    
    interface IDAORoom {

        function add(Room $room);
        function getAll();
    }
?>
