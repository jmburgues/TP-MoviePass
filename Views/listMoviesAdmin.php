<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Select the movie for the show :</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Show/showShows'"> Go to Shows List </button> 
</div>  


<?php if (isset($moviesDB)) {
        foreach ($moviesDB as $movie) { ?>      

    <form action="<?php echo FRONT_ROOT?>Show/selectMovie" method="POST" class= " mt-5 mb-5">
        <div class= "container">            
            <div class="card card-body ">
                <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                <input type="hidden"  value="<?php echo $start?>" name="start" ></input>   
                <button type="submit" value="<?php  echo $movie->getMovieId()?>" name="movieId" class="buttonList"><?php echo $movie->getTitle()?></button>     
            </div>
        </div>
        
        <?php } 
            if(!$moviesDB){ ?>
             <div class= "container">    
                <div class="card card-body ">
                    <?php echo "No movies loaded yet"?>  
                </div>
                </div>
        <?php } 
            } ?>  
    </form>

