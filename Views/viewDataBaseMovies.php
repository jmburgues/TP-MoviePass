<!-- Alert Message Popup -->
<?php  if(!empty($message)) echo "<script type='text/javascript'>alert('$message');</script>";?>

<!-- Pagination -->
<?php
  $total = count($moviesBDD);
  $articlePerPage = 5;
  $pages = ($total / $articlePerPage );
  $pages = ceil($pages);
  $init = ($page-1)*$articlePerPage;

?>

<!-- Page Title -->
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center text-white">Movies loaded on DataBase:<h3>
            <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>

<!-- Navigation buttons -->

<div class="container">
    <div class="center  mt-2 mb-4 text-center">
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back"
            onclick="history.back(-1)"> Go Back </button>
    </div>
</div>

<div class="container text-center" id="maxWidth1600">

    <div class="row row-home row-cols-5 col-5-resp">

        <?php for($i = $init; $i < $init+5; $i++ ){
          if (isset($moviesBDD[$i])) { ?>

        <div class="col col-home">
            <div class="card" id="cardsStyle">

                <?php
  if($moviesBDD[$i]->getPoster() == null){
        ?> <div class="mt-5 notFoundImageCardDB container"> </div>
                <?php
      }else{
        ?>
                <img class="card-img-top"
                    src="https://image.tmdb.org/t/p/w400/.<?php echo $moviesBDD[$i]->getPoster()?>">
                <?php
      }
      
      ?>

                <div class="card-body">
                    <div class="centerImageHome">
                        <?php if(strlen($moviesBDD[$i]->getTitle()<40)){ ?>
                        <h4 class="card-title  mb-2 text-center"><?php echo $moviesBDD[$i]->getTitle();?></h4>
                        <?php } else { ?>
                        <h5 class="card-title  mb-2 text-center"><?php echo $moviesBDD[$i]->getTitle();?></h5>
                        <?php } ?>
                    </div>
                    <p>
                        <?php
          if ($moviesBDD[$i]->getDescription()) {
              if (strlen($moviesBDD[$i]->getDescription()) < 100) {
                  echo $moviesBDD[$i]->getDescription();
              } else {
                  echo substr($moviesBDD[$i]->getDescription(), 0, 100);
                  echo "...";
              }
          } else {
              echo $moviesBDD[$i]->getTitle();
          } ?>
                    </p>
                </div>
                <?php if ($moviesBDD[$i]->getDescription() && strlen($moviesBDD[$i]->getDescription()) >= 100) {?>
                <div class="dropdown show">
                    <a class="btn dropdown-toggle card-text aDropCards" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <small class="text-muted">Leer más</small>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-2 " id="dropDownCard"
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



    <?php if($page > $pages){
   ?>
    <div class="mt-5 notFoundImageCardDB container"> </div>
    <?php
    
    echo $pages ;
    echo '<br>';
    echo $page ;
    echo '<br>';
    
  }else{
  
  ?>


    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-5">

            <li class="page-item border-0 <?php echo $page <= 1 ? "disabled" : "" ?>"><a
                    class=" page-link text-dark btn btn-danger "
                    href="<?php echo FRONT_ROOT?>Movie/viewDataBaseMovies/<?php echo $page-1 ?>">Previous</a></li>


            <?php for($i=0; $i<$pages; $i++) {
          ?>

            <li class="page-item <?php echo $page == $i+1 ? "active" : ""?>"><a
                    style="background-color: <?php echo $page == $i+1 ? "red" : ""?>" class="text-dark page-link"
                    href="<?php echo  FRONT_ROOT?>Movie/viewDataBaseMovies/<?php echo $i+1?>"> <?php echo $i+1?></a>
            </li>
            <?php 
  
  }?>
            <li class="page-item <?php echo $page >= $pages ? "disabled" : "" ?>"><a
                    class="page-link  text-dark btn btn-danger "
                    href="<?php echo FRONT_ROOT?>Movie/viewDataBaseMovies/<?php echo $page+1 ?>">Next</a></li>
        </ul>
    </nav>
    <?php } ?>

    <hr class=" mt-4 mb-1 bg-danger text-dark">