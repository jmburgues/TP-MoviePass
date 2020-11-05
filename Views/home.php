<style type="text/css">
          body {
              background-color: black; 
              background-image: none; 
          }
</style>

<?php
  $total = count($movies);
  $articlePerPage = 5;
  $pages = ($total / $articlePerPage );
  $pages = ceil($pages);
  $init = ($page-1)*$articlePerPage;

  ?>


<!--Primer vista al entrar a la página-->
<!--Jumbotron-->
<div >
  <img style="width:400px; height:300px; margin-left: auto; margin-right: auto; display:block;" src="https://i.ibb.co/84W4VgT/Logo-Black.png">
</div>

<div>
  <hr class=" mt-2 mb-4 bg-danger text-dark">
  <h1 class="text-muted text-center" ><?php echo $title;?><h1>
  <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
  
<div class="container text-center" style="max-width:1600px">
  
  <div class="row row-cols-5">
  
      <?php for($i = $init; $i < $init+5; $i++ ){
          if (isset($movies[$i])) { ?>
  
  <div class="col">
  
  <div class="card" style="margin-top:30px; height:720px;  background-color:#FFEDFA; ">
    <img class="card-img-top" src="https://image.tmdb.org/t/p/w400/.<?php echo $movies[$i]->getPoster()?>">
    <div class="card-body  ">
    <div style=" display: flex;
  justify-content: center;
  align-items: center;
  height: 100px;
  border: red 5px dotted;
  margin-bottom:5%;
  " >
      <h4 class="card-title  mb-2 text-center"><?php echo $movies[$i]->getTitle()?></h4>   
      </div>                    

        <?php if(!isset($_SESSION['loggedUser'])){ ?> 
          <form action="<?php echo FRONT_ROOT?>User/showLoginForm" method="POST" >
          <?php }else{ ?>
          <form action="<?php echo FRONT_ROOT?>Ticket/showPurchase" method="POST" >
          <?php } ?>
          <button value="<?php echo $movies[$i]->getMovieID()?>" name="movieId" class="btn btn-secondary bg-danger text-black mb-2"  type="submit">Buy Tickets</button>   
          </form>

      <p class="card-text" style="margin-bottom:0px;">
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
          <strong> <?php echo $movies[$i]->getDescription(); ?> </strong>
        </div>
      </div>   
      <?php } } ?>
    </div>
  </div> 
 <?php } ?>
</div>

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
