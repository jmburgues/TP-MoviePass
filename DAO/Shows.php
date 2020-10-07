<?php namespace DAO;

use DB\ShowsRepository as showsRepo;

class DAOShows {

    public function getAll(){
        $showsRepo = new ShowsRepository();
        $showsList = $showsRepo->GetAll();
        
        /// AQUI SE PUEDE IMPLEMENTAR EL SORTING POR FECHA DE FUNCION
        // function comparador($a,$b){
        //     return $a->getId() > $b->getId();
        // }

        // usort($cinemasList,'comparador');   
        
        return $showsList;
    }

    public function add($newShow){
        $showsRepo = new showsRepo();

        $showsList = $cineRepo->GetAll();

        foreach ($cinemasList as $existentCinema){
            if($newCinema->getName() == $existentCinema->getName()){
                return false;
            }
        }

        $cineRepo->Add($newCinema);

        return true;
    }

    public function remove($cinemaObject){
        $cineRepo = new CinemaRepository();
        $cineRepo->Remove($cinemaObject);
    }

    public function update($modifiedCinema){
        $cineRepo = new CinemaRepository();

        $cinemasList = $cineRepo->GetAll();

        foreach ($cinemasList as $existentCinema){
            if($modifiedCinema->getId() == $existentCinema->getId()){
                $cineRepo->Remove($existentCinema);
                $cineRepo->Add($modifiedCinema);
                
                return true;
            }
        }
        return false;        
    }
}

?>