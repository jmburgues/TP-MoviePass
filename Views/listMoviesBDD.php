<div class="text-center mt-5 mb-3">
        <h3 class="text-white">Movies on Data Base:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Movie/selectMoviesView'"> Continue adding </button> 
    </div>
<?php 
    if (isset($moviesBDD)) {
        foreach ($moviesBDD as $movie) {
?>             
    <form action="<?php echo FRONT_ROOT?>Movie/selectIdMovie" method="POST" class= " mt-5 mb-5">
        <div class= "container">            
            <div class="card card-body mt-1">

                    <ul>
                        <li style="list-style:none">Movie Title: <?php echo $movie->getTitle(); ?></li>
                        <li style="list-style:none">Movie Duration: <?php echo  $movie->getDuration(); ?></li>
                        <li style="list-style:none">Movie Description: <?php echo $movie->getDescription();?></li>

                    </ul>  

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
