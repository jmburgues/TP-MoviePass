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
  <div class="jmb-home"> </div>
  
</div>

<div>
  <hr class=" mt-2 mb-4 bg-danger text-dark">
  <h3 class="text-white text-center" ><?php echo $title;?><h3>
  <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
  
<div class="container text-center"  id="maxWidth1600" >
  <div class="row row-home row-cols-5 col-5-resp">
      <?php for($i = $init; $i < $init+5; $i++ ){
          if (isset($movies[$i])) { ?>
    <div class="col col-home">
    <div class="card " id="cardsStyle" >

    <?php
      if($movies[$i]->getPoster() == null){
            ?><div class="notFoundImageCard container"> </div>
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
                if (strlen($movies[$i]->getDescription()) < 100) {
                    echo $movies[$i]->getDescription();
                } else {
                    echo substr($movies[$i]->getDescription(), 0, 100);
                    echo "...";
                }
            } else {
                echo $movies[$i]->getTitle();
            } ?>
        </p>
      </div> 
      <?php if ($movies[$i]->getDescription() && strlen($movies[$i]->getDescription()) >= 100) {?>
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

  
  <?php if($page > $pages){
  ?> 
  <div class="mt-5 notFoundImageCard container"> </div>
    <?php
  }else{
  ?>
  
  <?php if ($movies != null) { ?>

  <div class ="marginTop100" >
  <nav aria-label="Page navigation example">
    <ul class="pagination pag-resp justify-content-center mt-3 ">
      <li class="page-item border-0 <?php echo $page <= 1 ? "disabled" : "" ?>"><a class="page-link text-dark btn btn-danger " href="<?php echo FRONT_ROOT?>Home/Index/<?php echo $page-1 ?>">Previous</a></li>
      
      <?php for($i=0; $i<$pages; $i++) {?>
        <li class="page-item border-0 <?php echo $page == $i+1 ? "active" : ""?>"><a style="background-color: <?php echo $page == $i+1 ? "red" : ""?>" class="page-link text-dark btn btn-danger" href="<?php echo  FRONT_ROOT?>Home/Index/<?php echo $i+1?>"> <?php echo $i+1?></a></li>
      <?php }?>

      <li class="page-item border-0 <?php echo $page >= $pages ? "disabled " : "" ?>"><a class="page-link text-dark btn btn-danger" href="<?php echo FRONT_ROOT?>Home/Index/<?php echo $page+1 ?>">Next</a></li>
    </ul>
  </nav>

  <hr class=" mt-4 mb-1 bg-danger text-dark">
  </div >
  <?php }else{
    ?><div class="mt-5 notFoundImageCard container"> </div> <?php
    ?><p class="text-white text-center font-weight-bold fontWeight">NO LOADED MOVIES YET</p>
    <p class="text-muted text-center mb-5"> <?php echo "PLEASE TRY AGAIN LATER"?><p><?php
  } ?>
</div ><?php } ?>