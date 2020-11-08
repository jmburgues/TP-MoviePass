<?php
    namespace DB\Interfaces;
    use models\Genre as Genre;
    
    interface IDAOGenre {

        function add(Genre $genre);
        function getAll();
    }
?>
