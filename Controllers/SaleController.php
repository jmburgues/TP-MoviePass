<?php
    namespace Controllers;

    class SaleController{

    
    public function showSales(){
        
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'adminSales.php';
    }
}

    ?>