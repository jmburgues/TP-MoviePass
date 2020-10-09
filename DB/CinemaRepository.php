<?php namespace DB;


class CinemaRepository {

    public function getAll(){
        $cineRepo = new CinemaRepository();
        $cinemasList = $cineRepo->GetAll();
        
        function comparador($a,$b){
            return $a->getId() > $b->getId();
        }

        usort($cinemasList,'comparador');
        
        return $cinemasList;
    }

    public function add($newCinema){
        $cineRepo = new CinemaRepository();

        $cinemasList = $cineRepo->GetAll();

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