<?php
    $total = count($movies);
    $articlePerPage = 5;
    $pages = ($total / $articlePerPage );
    $pages = ceil($pages);
    $init = ($page-1)*$articlePerPage;
    ?>

<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Select the movies for Data Base:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'"> Go Back </button>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="<?php ?>" onclick="window.location.href='<?php echo FRONT_ROOT?>Movie/addToSelectMoviesView'"> Add more Movies </button> 
</div>

<div class="container text-center" id="maxWidth1600">
  
  <div class="row row-cols-5">
  
      <?php for($i = $init; $i < $init+5; $i++ ){
          if (isset($movies[$i])) { ?>
  
  <div class="col">
    <div class="card" id="cardsStyle">
      <img class="card-img-top" src="https://image.tmdb.org/t/p/w400/.<?php echo $movies[$i]->getPoster()?>">
      <div class="card-body  ">
      <div class ="centerImageHome">
      <h4 class="card-title  mb-2 text-center"><?php echo $movies[$i]->getTitle()?></h4>   
      </div>
      <form class="form-inline my-2 my-lg-2 " action="<?php echo FRONT_ROOT?>Movie/selectIdMovie/<?php echo $movies[$i]->getMovieID(); ?>" method=GET>
            <button type="submit" value="<?php echo $movies[$i]->getMovieID();?>"  class=" marginl30 btn btn-secondary bg-danger text-black mb-2"> Add Movie </button>
        </form>
      <p>
      <?php
          if ($movies[$i]->getDescription()) {
              if (strlen($movies[$i]->getDescription()) < 100) {
                  echo $movies[$i]->getDescription();
              } else {
                  echo substr($movies[$i]->getDescription(), 0, 100);
              }
          } else {
              echo $movies[$i]->getTitle();
          } ?>
      </p>
    </div> 
    <?php if ($movies[$i]->getDescription() && strlen($movies[$i]->getDescription()) >= 155) {?>
      <div class="dropdown show"  >
        <a class="btn dropdown-toggle card-text aDropCards"  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <small class="text-muted" >Leer más</small>
        </a>
        <div class="dropdown-menu dropdown-menu-right p-2 dropDownCard" id="dropDownCard" aria-labelledby="dropdownMenuLink">
          <strong> <?php echo $movies[$i]->getDescription(); ?> </strong>
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





