<div style="text-align:center;">
    <h3>Select Movie you would like to add:</h3>
</div>
<?php 
//PELÍCULAS TRAIDAS DE LA API PARA HABILITARLAS
    if (isset($movies)) {
        foreach ($movies as $movie) {
?>             
    <form action="<?php echo FRONT_ROOT?>Movie/selectIdMovie" method="POST" class= " mt-5 mb-5">
        <div class= "container">            
            <div class="card card-body ">
                <button type="submit" value="<?php  echo $movie->getMovieId()?>" name="movieId" style=" text-align:left; border: none; background: none;"><?php echo $movie->getTitle()?></button>     
            </div>
        </div>
        <?php
        }
        ?>
        <?php
        if(!$movies){
            ?>
            <div class="container mt-5">   
                <div class="card card-body ">
                    <?php echo "No Movies loaded yet"?>  
                </div>
            </div>
        <?php
        }
        ?>  
    </form>
    <?php
    }
    ?>
