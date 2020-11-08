<?php
    namespace DB\Interfaces;
    use models\Movie as Movie;
    
    interface IDAOMovie {

        function add(Movie $movie);
        function getAll();
    }
?>
