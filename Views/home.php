<?php session_start();
require_once('nav.php');

?>


<!--Primer vista al entrar a la página-->
<!--Jumbotron-->
<div class="jumbotron mb-5 mt-5 text-center bg-dark text-white homeTitle" style="opacity:0.9; background-image: url(https://i.imgur.com/FK6VxlJ.jpg); height:230px;">
  <h1 class="display-4">Movie Pass</h1>
  <h2 class="lead">Where movies come true!</h2>

</div>

<div>
  <hr class=" mt-2 mb-4 bg-danger text-dark">
  <h1 class="text-muted text-center" >LATEST<h1>
  <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
    
    <?php
    $total = count($movies);
    $articulosXPagina = 5;
    $paginas = ($total / $articulosXPagina );
    $paginas = ceil($paginas);
    echo $paginas;
?>

  <?php 
    $iniciar = ($_GET["pagina"]-1)*$articulosXPagina;
  ?>
  <div class="container" style="max-width:1600px">
  
  <div class="row row-cols-5">
  <?php for($i = $iniciar; $i<$iniciar+5; $i++ ){?>
      <div class="col">
    <div class="card" style="margin-top:30px; height:720px">
    <img class="card-img-top" src="https://image.tmdb.org/t/p/w400/.<?php echo $movies[$i]->getPoster()?>">
    <div class="card-body  ">
      <h4 class="card-title mb-2"><?php echo $movies[$i]->getTitle()?></h4>   
      <input value="Buy " class="btn btn-secondary bg-danger text-white mb-2 col-md-4 " type="button" onclick="location='<?= FRONT_ROOT?>User/showPurchase'" />
      <p class="card-text" style="margin-bottom:0px;">
        <?php 
          if ($movies[$i]->getDescription()) {
              if (strlen($movies[$i]->getDescription()) < 150) {
                  echo $movies[$i]->getDescription();
              } else {
                  echo substr($movies[$i]->getDescription(), 0, 150);
              }
          }else{
            echo $movies[$i]->getTitle();
          }
        ?>
      </p>
      </div> 
      <?php if($movies[$i]->getDescription() && strlen($movies[$i]->getDescription()) >= 155){?>
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
          <?php
        }
        ?>


      </div>
</div> 
 <?php }
?>
</div>
</div> 
</div>

  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end mt-3">
    <li class="page-item <?php echo $_GET['pagina']<= 1 ? "disabled" : "" ?>"><a class="page-link  " href="<?php FRONT_ROOT?>index.php?pagina=<?php echo $_GET['pagina']-1 ?>">Previous</a></li>
      <?php for($i=0; $i<$paginas; $i++) {?>
      <li class="page-item <?php echo $_GET['pagina']==$i+1 ? "active" : ""?>"><a class="page-link"  href="<?php FRONT_ROOT?>index.php?pagina=<?php echo $i+1?>"> <?php echo $i+1?></a></li>

  <?php }?>

  <li class="page-item <?php echo $_GET['pagina']>= $paginas ? "disabled" : "" ?>"><a class="page-link  " href="<?php FRONT_ROOT?>index.php?pagina=<?php echo $_GET['pagina']+1 ?>">Next</a></li>
    </ul>
  </nav>
  


</div>

<hr class=" mt-4 mb-1 bg-danger text-dark">
