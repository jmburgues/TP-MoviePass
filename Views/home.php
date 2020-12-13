<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/userStyle.css">

  <?php
    $total = count($movies);
    $articlePerPage = 5;
    $pages = ($total / $articlePerPage );
    $pages = ceil($pages);
    $init = ($page-1)*$articlePerPage;
    ?>


  <!--Primer vista al entrar a la página-->
  <!--Jumbotron-->
  <div>
    <img height="155" width="200" style="display: block; margin-left: auto; margin-right: auto;" src="<?php echo FRONT_ROOT?>/Views/img/MoviePass-noBgW.png">
  </div>

  <div>
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-white text-center" ><?php echo $title;?><h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
  </div>
    
  <div class="container text-center"  id="maxWidth1600" >
    
    <div class="row row-cols-5">

        <?php for($i = $init; $i < $init+5; $i++ ){
            if (isset($movies[$i])) { ?>
    
    <div class="col">
    <div class="card " id="cardsStyle" >

<?php
  if($movies[$i]->getPoster() == null){
        ?><img id="notFoundImageCard" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">
      <?php
      }else{
        ?>
        <img class="card-img-top" src="https://image.tmdb.org/t/p/w400/.<?php echo $movies[$i]->getPoster()?>">
        <?php
      }
      
      ?>
          
      <div class="card-body  ">
      <div class="centerImageHome">
        <?php if(strlen($movies[$i]->getTitle()<40)){ ?>
          <h4 class="card-title  mb-2 text-center"><?php echo $movies[$i]->getTitle();?></h4>
        <?php } else { ?>
          <h5 class="card-title  mb-2 text-center"><?php echo $movies[$i]->getTitle();?></h5>
        <?php } ?>  
      </div>                    

          <?php if(!isset($_SESSION['loggedUser'])){ ?> 
            <form action="<?php echo FRONT_ROOT?>User/showLoginForm" method="POST" >
            <?php }else{ ?>
            <form action="<?php echo FRONT_ROOT?>Ticket/selectShow" method="POST" >
            <?php } ?>
            <button value="<?php echo $movies[$i]->getMovieID()?>" name="movieId" class="btn btn-secondary bg-danger text-black mb-2"  type="submit">Buy Tickets</button>   
            </form>

        <p style=text-align:justify;>
        <?php
            if ($movies[$i]->getDescription()) {
                if (strlen($movies[$i]->getDescription()) < 150) {
                    echo $movies[$i]->getDescription();
                } else {
                    echo substr($movies[$i]->getDescription(), 0, 150);
                    echo "...";
                }
            } else {
                echo $movies[$i]->getTitle();
            } ?>
        </p>
      </div> 
      <?php if ($movies[$i]->getDescription() && strlen($movies[$i]->getDescription()) >= 150) {?>
        <div class="dropdown show"  >
          <a class="btn dropdown-toggle card-text aDropCards" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <small class="text-muted" >Read more</small>
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
  
  <?php if ($movies != null) { ?>
  <div class ="marginTop100" >
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
      <li class="page-item <?php echo $page <= 1 ? "disabled" : "" ?>"><a class="page-link  " href="<?php echo FRONT_ROOT?>Home/Index/<?php echo $page-1 ?>">Previous</a></li>
      
      <?php for($i=0; $i<$pages; $i++) {?>
        <li class="page-item <?php echo $page == $i+1 ? "active" : ""?>"><a class="page-link"  href="<?php echo  FRONT_ROOT?>Home/Index/<?php echo $i+1?>"> <?php echo $i+1?></a></li>
      <?php }?>

      <li class="page-item <?php echo $page >= $pages ? "disabled" : "" ?>"><a class="page-link  " href="<?php echo FRONT_ROOT?>Home/Index/<?php echo $page+1 ?>">Next</a></li>
    </ul>
  </nav>

  <hr class=" mt-4 mb-1 bg-danger text-dark">
  </div >
  <?php }else{
    ?><img id="noMovieImg" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">   <?php
    ?><p class="text-white text-center font-weight-bold fontWeight">NO LOADED MOVIES YET</p>
    <p class="text-muted text-center"> <?php echo "PLEASE TRY AGAIN LATER"?><p><?php
  } ?>
</div >