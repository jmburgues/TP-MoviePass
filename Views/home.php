<?php
    require_once('nav.php');
    echo "<br>";
    echo ROOT;
  echo "<br>";
  echo FRONT_ROOT;
  echo "<br>";
  echo VIEWS_PATH;
  echo "<br>";
  use Controllers\MovieController as MovieController;
use DAO\DAOMovie;

$mc = new MovieController;
  $moviesList = $mc->getLatestMoviesFromApi();
  //print_r($moviesList);
  
  $daoMovies = new DAOMovie();
  $movies = $daoMovies->getAll();

  ?>
<!--Primer vista al entrar a la página-->
<div class="jumbotron mb-5 mt-5 text-center bg-dark text-white homeTitle" style="opacity:0.9;">
    <h1 class="display-4">Movie Pass</h1>
    <br>
    <p class="lead">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid, hic repellendus. Harum, dolores aliquam! Tenetur sunt illo quis nulla architecto minima! Ipsam, veritatis? Quaerat explicabo error et at corrupti? Totam.</p>
    <hr class="my-4"> 
<input value="Admin tools" type="button" onclick="location='Views/adminView.php'" />
</div>
<!--Últimas películas traídas desde la API-->
<hr>
<hr class=" mt-5 mb-1 bg-danger text-dark">
<h3  class="text-white bg-dark text-center">Últimas</h3>
<hr class=" mt-1 mb-1 bg-danger text-dark">
<div class="card-group" style="margin:40px;">
<?php
  foreach ($movies as $movie) {
?>
  <div class="card" style="margin-right:4px;">
    <img class="card-img-top" src="Views/img/Logo.bmp" alt="Card image cap">
    <div class="card-body ">
      <h5 class="card-title"><?= $movie->getTitle();?> </h5>
      
 
      <input value="Buy" class="btn btn-secondary bg-danger text-dark mb-2 col-md-4" type="button" onclick="location='Views/purchase-view.php'" />
     
      <p class="card-text"><?= $movie->getDescription();?></p>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
<?php
  }
?>
</div>

<!--Pŕoximas películas traídas desde la API-->
<br>
<hr class=" mt-4 mb-1 bg-danger text-dark">
<h3  class="text-white bg-dark text-center">Próximamente</h3>
<hr class=" mt-1 mb-1 bg-danger text-dark">

<div class="card-group" style="margin:40px;">
<?php
  for ($i = 1; $i <= 5; $i++) {
?>
  <div class="card" style="margin-right:4px;">
    <img class="card-img-top" src="Views/img/Logo.bmp" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <input value="Buy" class="btn btn-secondary bg-danger text-dark mb-2 col-md-4" type="button" onclick="location='Views/purchase-view.php'" />
     
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
<?php
  }
?>
</div>
<hr class=" mt-1 mb-1 bg-danger text-dark">
<?php
    require_once('footer.php');
?>