<div class="panel-heading">
    <br><h3 style="text-align: center; margin-top:20px">Select movie:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black  mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Movie/adminView'"> Go Back </button> 
</div>
<?php if (isset($moviesDB)) {
        foreach ($moviesDB as $movie) { ?>      

    <form action="<?php echo FRONT_ROOT?>Show/selectMovie" method="POST" class= " mt-5 mb-5">
        <div class= "container">            
            <div class="card card-body ">
                <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                <input type="hidden"  value="<?php echo $start?>" name="start" ></input>   
                <button type="submit" value="<?php  echo $movie->getMovieId()?>" name="movieId" style=" text-align:left; border: none; background: none;"><?php echo $movie->getTitle()?></button>     
            </div>
        </div>
        
        <?php } 
            if(!$movies){ ?>
                <div class="card card-body ">
                    <?php echo "No movies loaded yet"?>  
                </div>
        <?php } 
            } ?>  
    </form>

