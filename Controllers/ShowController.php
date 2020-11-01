<?php
    namespace Controllers;

    use \DateTime as DateTime;
    use \DateInterval as DateInterval;
    use DAO\PDO\PDOMovie as DAOMovie;
    use DAO\PDO\PDORoom as DAORoom;
    use DAO\PDO\PDOShow as DAOShow;
    use DAO\PDO\PDOCinema as DAOCinema;
    use DAO\PDO\PDOGenre as PDOGenre;
    use Models\Show as Show;
    use Models\Cinema as Cinema;
    use Models\Movie as Movie;
    

    class ShowController{
        private $DAOMovie;
        private $DAORoom;
        private $DAOShow;
        private $PDOMovie;
        private $PDOGenre;


        public function __construct(){
            $this->DAOMovie = new DAOMovie();   
            $this->DAORoom = new DAORoom(); 
            $this->DAOShow = new DAOShow();    
            $this->PDOMovie = new DAOMovie();     
            $this->PDOCinema = new DAOCinema();    
            $this->PDOGenre = new PDOGenre();    
        }
        
    public function showShows(){
        $shows = array();
        $aux =$this->DAOShow->getAll();
        if (is_array($aux)){
            $shows = $aux;
        }else{
            $shows[0] = $aux;
        }

        $auxMovie = new DAOMovie();
        $auxCinema = new DAOCinema();
        $auxRoom = new DAORoom();



      //  include VIEWS_PATH.'showAddView.php';
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'adminShows.php';
    }
    
    public function addShowView(){
        $shows=$this->DAOShow->getAll();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        $this->showShows();
        include VIEWS_PATH.'showAddView.php';
    }

    public function addShow($date, $start){
        $shows=$this->DAOShow->getAll();
        $movies=$this->DAOMovie->GetAll();
        $moviesDB = $this->PDOMovie->getAll();

        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'listMoviesAdmin.php';
    }

    public function addCurrentShow( $date, $start, $end, $selectedMovieId, $roomId ){
        $newShow = new Show();
        $newShow->setDate($date);
        $newShow->setStart($start);
        $newShow->setEnd($end);
        $newShow->setIdMovie($selectedMovieId);
        $newShow->setIdRoom($roomId);
        $rooms = $this->DAORoom->getAll(); 
        $movies=$this->DAOMovie->GetAll();
        foreach($rooms as $room){
            if($room->getRoomID() == $roomId){
                $selectedRoom = $room;
            }
        } 
        foreach($movies as $movie){
            if($movie->getMovieId() == $selectedMovieId){
                $selectedMovie = $movie;
            }
        } 
        
        $flag = 0; 
        
        $lookingForShows = array();
        $aux =$this->DAOShow->getAll();
        if (is_array($aux)){
            $lookingForShows = $aux;
        }else{
            $lookingForShows[0] = $aux;
        }


        foreach ($lookingForShows as $show) {
          //  echo "Entra";
            if ($newShow->getDate() == $date) {
                //echo $newShow->getStart();
                //echo $date;
                if ($show->getIdRoom() == $roomId) {
                  //  echo "id";
                    $extremoInferior = new DateTime($show->getStart());
                    $extremoSuperior = new DateTime($show->getEnd());
                    $inicio = new DateTime($start);
                    $fin = new DateTime($end);
                    
                 

                    if ($inicio>=$extremoInferior && $inicio<=$extremoSuperior) {
                        $flag = 1;
                    } else {
                        if ($fin>=$extremoInferior && $fin<=$extremoSuperior) {
                            $flag = 1;
                        }
                    }
                }
            }
        }    
            if ($flag != 1) {
                $this->DAOShow->add($newShow);
            } else {
                $message = "Horario ocupado";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }        
        $shows=$this->DAOShow->getAll();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        $this->showShows();
    }

    function getMoviesByDate($year){ // returns an array of movies (Object) created on a given date (1st revision)
    
        $genreList = $this->PDOGenre->getGenresListFromShows();
        $showList = $this->DAOShow->getAll();

        $moviesYearList = $this->PDOMovie->getArrayOfYearsFromShows();
    
        if ($year > 1900 && $year <= 2020) {
            $moviesList = $this->PDOMovie->getAll();
    
            $movies = array();
    
            foreach ($moviesList as $oneMovie) {
                $releaseDate = $oneMovie->getReleaseDate();
                $releaseYear = DateTime::createFromFormat('Y-m-d', $releaseDate)->format('Y');
    
                if ($releaseYear == $year && !in_array( $oneMovie, $movies)) {
                    foreach($showList as $show){
                        if($show->getIdMovie() == $oneMovie->getMovieID()){
                            array_push($movies, $oneMovie);
                        }
                    }
                    
                }
            }
        }
    
        ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION
        ViewController::homeView($movies,1,"Year: ".$year);
      }

    public function selectMovie($date, $start, $movieId){
        $dateTime = new DateTime();
        $movies=$this->DAOMovie->GetAll();
        
        foreach($movies as $movie){
            if($movie->getMovieId() == $movieId){
        
                $auxDate = $start;
                $dateToInsert = new DateTime($auxDate.'M');

                $auxEnd = ($movie->getDuration() +15 );
                
                $interval = new DateInterval('PT'.$auxEnd.'M');         

                $dateToInsertEnd = new DateTime($auxDate);
                $dateToInsertEnd->add($interval);
            
                $dateToInsert = $dateToInsert->format('Y-m-d H:i:s');
                $dateToInsertEnd = $dateToInsertEnd->format('Y-m-d  H:i:s');

                $selectedMovie = $movie;
            }
        } 
        $rooms = $this->DAORoom->getAll(); 
      //  print_r($rooms);

        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'listCinemasAdmin.php';
    }

    function listByGenre($genreId){

        $genreName = $this->PDOGenre->getById($genreId)->getName();
        $showList = $this->DAOShow->getAll();
        $genreList = $this->PDOGenre->getGenresListFromShows(); 

        $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
        $moviesList = $this->DAOMovie->getAll();
        $movies = array();

        foreach($moviesList as $oneMovie){

          $movieGenres = $oneMovie->getGenre();

          foreach($movieGenres as $oneGenre){
            if($oneGenre->getId() == $genreId){
                foreach($showList as $show){
                    if($show->getIdMovie() == $oneMovie->getMovieID()){
                        array_push($movies,$oneMovie);
                    }
                }
             } 
            }
        }
 
        ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION
        ViewController::homeView($movies,1,"Genre: ".$genreName);
      }
}



    ?>