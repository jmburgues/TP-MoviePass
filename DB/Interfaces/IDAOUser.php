<?php
    namespace DB\Interfaces;
    use models\User as User;
    
    interface IDAOUser {

        function add(User $user);
        function getAll();
    }
?>
