<?php
    require_once('nav.php');
    require_once('header.php');
    
?>
<!--Estilo de la página-->
    <style type="text/css">
            body {
                background-color: white; 
                background-image: none; 
            }
            </style>
<?php 
    if (isset($movies)) {
        foreach ($movies as $movie) {
?>             
    <form action="<?php echo FRONT_ROOT?>Show/selectMovie" method="POST" class= " mt-5">
        <div class= "container">            
            <div class="card card-body ">
                <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                <input type="hidden"  value="<?php echo $time?>" name="time" ></input>     
                <input type="hidden"  value="<?php echo $spectators?>" name="spectators" ></input>     
                <button type="submit" value="<?php  echo $movie->getMovieId()?>" name="movieId" style=" text-align:left; border: none; background: none;"><?php echo $movie->getTitle()?></button>     
            </div>
        </div>
        <?php
        }
        ?>
        <?php
        if(!$movies){
            ?>
            <div class="card card-body ">
                <?php echo "No movies loaded yet"?>  
            </div>
        <?php
        }
        ?>  
    </form>
    <?php
    }
    ?>
