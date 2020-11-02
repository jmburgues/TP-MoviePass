
    <?php
    $total = count($movies);
    $articlePerPage = 5;
    $pages = ($total / $articlePerPage );
    $pages = ceil($pages);
    $init = ($page-1)*$articlePerPage;

    ?>
    <div style="text-align:center; margin-top:20px">
        <h3>Select Movie you would like to add:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Movie/selectmoviesView'"> Go Back </button> 
    </div>

    <div class="container" style="max-width:1600px">
    
    <div class="row row-cols-5">
    
        <?php for($i = $init; $i < $init+5; $i++ ){
            if (isset($movies[$i])) { ?>
    
    <div class="col">
    
    <div class="card" style="margin-top:30px; height:720px">
        <img class="card-img-top" src="https://image.tmdb.org/t/p/w400/.<?php echo $movies[$i]->getPoster()?>">
        <div class="card-body  ">
        
        <h4 class="card-title mb-2"><?php echo $movies[$i]->getTitle()?></h4>

        <form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>Movie/selectIdMovie/<?php echo $movies[$i]->getMovieID(); ?>" method=GET>
            <button type="submit" value="<?php echo $movies[$i]->getMovieID();?>" class="btn btn-secondary"> Select Movie </button>
        </form>

        <p class="card-text" style="margin-bottom:0px;">
        <?php
            if ($movies[$i]->getDescription()) {
                if (strlen($movies[$i]->getDescription()) < 150) {
                    echo $movies[$i]->getDescription();
                } else {
                    echo substr($movies[$i]->getDescription(), 0, 150);
                }
            } else {
                echo $movies[$i]->getTitle();
            } ?>
        </p>
        </div> 
        <?php if ($movies[$i]->getDescription() && strlen($movies[$i]->getDescription()) >= 155) {?>
        <div class="dropdown show"  >
            <a class="btn dropdown-toggle card-text"  style="margin-left:65%; margin-bottom:0; " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <small class="text-muted" >Leer más</small>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-2" 
                style="width:500px; border-radius: 15px 15px 15px 15px;
                    -moz-border-radius: 15px 15px 15px 15px;
                    -webkit-border-radius: 15px 15px 15px 15px;
                    border: 1px solid #000000; " 
                aria-labelledby="dropdownMenuLink">
            <?php echo $movies[$i]->getDescription(); ?>
            </div>
        </div>   
        <?php } } ?>
        </div>
    </div> 
    <?php } ?>
    </div>

    <!-- 
    MODIFICAR LAS REFERENCIAS EN LOS BOTONES DEL PAGINADO, USAR EL HOME VIEW ENVIANDO $movies PAGINA Y TITULO.
    -->

    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        <li class="page-item <?php echo $page <= 1 ? "disabled" : "" ?>"><a class="page-link  " href="<?php echo FRONT_ROOT?>Movie/selectMoviesView/<?php echo $page-1 ?>">Previous</a></li>
        
        <?php for($i=0; $i<$pages; $i++) {?>
        <li class="page-item <?php echo $page == $i+1 ? "active" : ""?>"><a class="page-link"  href="<?php echo  FRONT_ROOT?>Movie/selectMoviesView/<?php echo $i+1?>"> <?php echo $i+1?></a></li>
        <?php }?>

        <li class="page-item <?php echo $page >= $pages ? "disabled" : "" ?>"><a class="page-link  " href="<?php echo FRONT_ROOT?>Movie/selectMoviesView/<?php echo $page+1 ?>">Next</a></li>
    </ul>
    </nav>

    <hr class=" mt-4 mb-1 bg-danger text-dark">
