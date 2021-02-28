<style>
.container {
  height: 40px;
  position: relative;
}

.center {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
</style>

<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">


<!-- Page Title -->
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center" style="color:white;" >Select movie:<h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>

<!-- Navigation buttons -->

<div class="container">
  <div class="center">
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="history.back(-1)"> Go Back </button> 
  </div>
</div>

<?php if (isset($moviesDB)) {
        foreach ($moviesDB as $movie) { ?>      

    <form action="<?php echo FRONT_ROOT?>Show/selectRoomForShow" method="POST" class= " mt-5 mb-5">
        <div class= "container">            
            <div class="card card-body p-2 ">
                <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                <input type="hidden"  value="<?php echo $start?>" name="start" ></input>   
                <button type="submit" value="<?php  echo $movie->getMovieId()?>" name="movieId" class="buttonList btn-light"><?php echo $movie->getTitle()?></button>     
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

