<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center" style="color:white;" >Administrative Tools<h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
<div class="container ">
    <div class="row mt-2">
        <div class="col mt-5">
            <form action="<?php echo FRONT_ROOT?>Cinema/manageCinemas" method="POST">
                
                <input type="submit" class="btn btn-primary btn-lg btn-block bg-danger" value="Manage Cinemas" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
                </input>
            </form>
        </div>

        <div class="col mt-5">       
            <form action="<?php echo FRONT_ROOT?>Show/showShows" method="POST">
                <input type ="submit" class="btn btn-primary btn-lg btn-block bg-danger" value="Manage Shows" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> </input>
            </form>
        </div>
        <div class="w-100"></div>

        <div class="col mt-5"> 
            <form action="<?php echo FRONT_ROOT?>Sale/showSales" method="POST">
                <input type ="submit" class="btn btn-primary btn-lg btn-block bg-danger" value="Manage Sales" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
                </input>
            </form>
        </div>

        <div class="col mt-5"> 
            <form action="<?php echo FRONT_ROOT?>Movie/listAPIMovies" method="POST">
                <input type ="submit" class="btn btn-primary btn-lg btn-block bg-danger" value="Add Movies" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"></input>
            </form>
        </div>
    </div>
</div>
    
  