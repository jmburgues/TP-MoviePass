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

<form>
    <div class="container">
        <?php   
            foreach($listAdminMovies as $movie){
                ?> <p class="lead text-center mt-5 mb-5"> <?php echo "SELECTED: " .$movie->getTitle();?></p> <?php
        };
        foreach ($cinemas as $cinema) {
            ?>
            <div class="card card-body "> 
            <button type="submit"   value="<?php echo $cinema->getName()?>" name="nameCinema" style=" text-align:left; border: none; background: none;"><?php  echo $cinema->getName()?></button>     
            </div> 
        <?php
    } ?>
    </div>
</form>