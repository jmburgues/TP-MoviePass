<?php
    namespace DAO;
    use models\User as User;
    
    interface IDAOUser {

        function add(User $user);
        function getAll();
    
    }
?>
