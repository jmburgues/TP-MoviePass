<?php
    $total = count($moviesBDD);
    $articlePerPage = 5;
    $pages = ($total / $articlePerPage );
    $pages = ceil($pages);
    $init = ($page-1)*$articlePerPage;
    ?>

<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Movies on Data Base:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Movie/selectMoviesView'"> Keep adding </button> 
</div>

<div class="container text-center" style="max-width:1600px">
  
  <div class="row row-cols-5">
  
      <?php for($i = $init; $i < $init+5; $i++ ){
          if (isset($moviesBDD[$i])) { ?>
  
  <div class="col">
  
  <div class="card" style="margin-top:30px; height:720px;  background-color:#FFEDFA; ">
    <img class="card-img-top" src="https://image.tmdb.org/t/p/w400/.<?php echo $moviesBDD[$i]->getPoster()?>">
    <div class="card-body  ">
    <div style=" display: flex;
  justify-content: center;
  align-items: center;
  height: 100px;
  border: red 5px dotted;
  margin-bottom:5%;
  " >
      <h4 class="card-title  mb-2 text-center"><?php echo $moviesBDD[$i]->getTitle()?></h4>   
      </div>
     
      
      <p class="card-text" style="margin-bottom:0px;">
      <?php
          if ($moviesBDD[$i]->getDescription()) {
              if (strlen($moviesBDD[$i]->getDescription()) < 100) {
                  echo $moviesBDD[$i]->getDescription();
              } else {
                  echo substr($moviesBDD[$i]->getDescription(), 0, 100);
              }
          } else {
              echo $moviesBDD[$i]->getTitle();
          } ?>
      </p>
    </div> 
    <?php if ($moviesBDD[$i]->getDescription() && strlen($moviesBDD[$i]->getDescription()) >= 155) {?>
      <div class="dropdown show"  >
        <a class="btn dropdown-toggle card-text"  style="margin-left:65%; margin-bottom:0; " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <small class="text-muted" >Leer más</small>
        </a>
        <div class="dropdown-menu dropdown-menu-right p-2" 
            style="width:500px; border-radius: 15px 15px 15px 15px;
                  -moz-border-radius: 15px 15px 15px 15px;
                  -webkit-border-radius: 15px 15px 15px 15px;
                  border: 1px solid #000000;
                  background-color:#FFEDFA; " 
            aria-labelledby="dropdownMenuLink">
          <strong> <?php echo $moviesBDD[$i]->getDescription(); ?> </strong>
        </div>
      </div>   
      <?php } } ?>
    </div>
  </div> 
 <?php } ?>
</div>

<!-- 
  MODIFICAR LAS REFERENCIAS EN LOS BOTONES DEL PAGINADO, USAR EL HOME VIEW ENVIANDO $moviesBDD PAGINA Y TITULO.
 -->

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center mt-3">
    <li class="page-item <?php echo $page <= 1 ? "disabled" : "" ?>"><a class="page-link  " href="<?php echo FRONT_ROOT?>Movie/selectMoviesFromBDD/<?php echo $page-1 ?>">Previous</a></li>
    
    <?php for($i=0; $i<$pages; $i++) {?>
      <li class="page-item <?php echo $page == $i+1 ? "active" : ""?>"><a class="page-link"  href="<?php echo  FRONT_ROOT?>Movie/selectMoviesFromBDD/<?php echo $i+1?>"> <?php echo $i+1?></a></li>
    <?php }?>

    <li class="page-item <?php echo $page >= $pages ? "disabled" : "" ?>"><a class="page-link  " href="<?php echo FRONT_ROOT?>Movie/selectMoviesFromBDD/<?php echo $page+1 ?>">Next</a></li>
  </ul>
</nav>

<hr class=" mt-4 mb-1 bg-danger text-dark">





