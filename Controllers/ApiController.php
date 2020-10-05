<?php
    namespace Controllers;
    use models\Movie as Movie;
    use models\Genre as Genre;
    class ApiController
    {
        public static function getGenreJSON()
        {
          
            //se podria lograr lo mismo con un file_get_contents ya que es un json lo que viene de la api
            //inicia la session cURL
            $curl = curl_init();
    
            //setea las variables
            curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.themoviedb.org/3/genre/movie/list?language=en-US&api_key=".API_KEY,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            ));
    
            //Ejecuta la sesion y guarda en response lo que devuelva
            $response = curl_exec($curl);
    
            //Se guarda en err el error si es que hubo alguno
            $err = curl_error($curl);
    
            //se cierra la sesion
            curl_close($curl);
    
            if ($err) echo "cURL Error #:" . $err;
            else return $response;
            
        }

        public static function getLatestMoviesJSON()
        {  echo "HOLA";
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.themoviedb.org/3/movie/latest?api_key=601e12bf1e7197e7532eb9c4901b0d3a&language=en-US",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 200,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

         //   print_r($response);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            return $response;
            }
            
          //  file_get_contents("https://api.themoviedb.org/3/movie/latest?api_key=601e12bf1e7197e7532eb9c4901b0d3a&language=en-US");
        }

        public static function getMovieDataJSON($id)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.themoviedb.org/3/movie/".$id."?language=en-US&api_key=".API_KEY,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 200,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            ));
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            return $response;
            }
        }


        public static function getLatestMoviesID()
        {
            $idMoviesList = array();
            // $this->getLatestMoviesJSON();
            $jsonContent = self::getLatestMoviesJSON(); 
            

            $arrayToDecode = array();     
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            //puedo acceder directamente a ese conjunto
            foreach($arrayToDecode['results'] as $valueArray){
                array_push($idMoviesList,$valueArray['id']);
            }

            return $idMoviesList;
        }

        public static function createMovieFromJSON($movieID){
            //$this->getMovieDataJSON($movieID)
            $movieJSON = self::getMovieDataJSON($movieID);
                
            $arrayToDecode = array();     
            $arrayToDecode = ($movieJSON) ? json_decode($movieJSON, true) : array();
            
            $movieGenreList = array();
            
            foreach($arrayToDecode['genres'] as $genre){
                $genre= new Genre($genre['name'],$genre['id']);

                array_push($movieGenreList,$genre);   
            }
            
            $id = $arrayToDecode['id'];
            $name = $arrayToDecode['title'];
            $runtime = $arrayToDecode['runtime'];
            $language = $arrayToDecode['original_language'];
            $imageURL = $arrayToDecode['poster_path'];

            $movie = new Movie($id,$name,$runtime,$language,$movieGenreList,$imageURL);
        
            return $movie;
        } 
    }
?>