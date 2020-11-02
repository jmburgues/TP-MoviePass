
<div class="container " style="height:850px">
    <div class="row mt-5">
        <div class="col mt-5">
            <form action="<?php echo FRONT_ROOT?>Cinema/showCinemas" method="POST">
                <input type ="submit" class="btn btn-primary bg-danger text-black mt-5 col-md-7 offset-md-3" value="Manage Cinemas" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
                </input>
            </form>
        </div>

        <div class="col mt-5">       
            <form action="<?php echo FRONT_ROOT?>Show/showShows" method="POST">
                <input type ="submit" class="btn btn-primary bg-danger text-black mt-5 col-md-7 offset-md-3 " value="Manage Shows" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
                </input>
            </form>
        </div>
        <div class="w-100"></div>

        <div class="col mt-5"> 
            <form action="<?php echo FRONT_ROOT?>Sale/showSales" method="POST">
                <input style="font-style: italic" type ="submit" disabled class="btn btn-primary bg-danger  text-black mt-5 col-md-7 offset-md-3  " value="Sale Stats (Coming soon)" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
                </input>
            </form>
        </div>

        <div class="col mt-5"> 
            <form action="<?php echo FRONT_ROOT?>Movie/selectMoviesView" method="POST">
                <input type ="submit" class="btn btn-primary bg-danger  text-black mt-5 col-md-7 offset-md-3  " value="Add Movie" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
                </input>
            </form>
        </div>
    </div>
</div>