<?php session_start();
require_once('nav.php');?>


<!--Primer vista al entrar a la página-->
<!--Jumbotron-->
<div class="jumbotron mb-5 mt-5 text-center bg-dark text-white homeTitle" style="opacity:0.9; background-image: url(https://i.imgur.com/FK6VxlJ.jpg); height:230px;">
  <h1 class="display-4">Movie Pass</h1>
  <h2 class="lead">Where movies come true!</h2>
</div>

<div class="container" style="max-width:1600px">
  <div class="row row-cols-5">
    <?php
      foreach ($movies as $movie) {
    ?>
      <div class="col">
        <div class="card" style="margin-top:30px; height:720px">
          <img class="card-img-top" src="https://image.tmdb.org/t/p/w400/.<?php echo $movie->getPoster()?>">
          <div class="card-body  ">
            <h4 class="card-title mb-2"><?php echo $movie->getTitle()?></h4>   
            <input value="Buy" class="btn btn-secondary bg-danger text-white mb-2 col-md-4 " type="button" onclick="location='<?= FRONT_ROOT?>User/showPurchase'" />
            <p class="card-text" style="margin-bottom:0px;">
              <?php 
                if ($movie->getDescription()) {
                    if (strlen($movie->getDescription()) < 155) {
                        echo $movie->getDescription();
                    } else {
                        echo substr($movie->getDescription(), 0, 155);
                    }
                }else{
                  echo $movie->getTitle();
                }
              ?>
            </p>
          </div>
          <?php if($movie->getDescription() && strlen($movie->getDescription()) >= 155){?>
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
                <?php echo $movie->getDescription(); ?>
              </div>
            </div>
          <?php
        }
        ?>
        </div>
      </div>
    <?php
    }
    ?>
  </div>


  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end mt-3">
      <li class="page-item"><a class="page-link  text-dark" href="#" tabindex="-1">Previous</a></li>
      <li class="page-item"><a class="page-link  text-dark" href="#">1</a></li>
      <li class="page-item"><a class="page-link  text-dark" href="#">2</a></li>
      <li class="page-item"><a class="page-link  text-dark" href="#">3</a></li>
      <li class="page-item"><a class="page-link  text-dark" href="#">Next</a> </li>
    </ul>
  </nav>
</div>

<hr class=" mt-4 mb-1 bg-danger text-dark">
