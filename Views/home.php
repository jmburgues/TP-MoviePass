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
  use DAO\DAOMovie as DAOMovie;

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
<input value="Admin tools" type="button" onclick="location='Views/genres-list.php'" />
</div>
<!--Últimas películas traídas desde la API-->
<hr>
<!--<hr class=" mt-5 mb-1 bg-danger text-dark">
<h3  class="text-white bg-dark text-center">Últimas</h3>
<hr class=" mt-1 mb-1 bg-danger text-dark">
<div class="card-group" style="margin:1px;">
-->

<div class="container">
<div class="row row-cols-3">
<?php
  foreach ($movies as $movie) {
    ?>
      <div class="col"><div class="card" style="margin-top:10px;">
        <img class="card-img-top" src="https://image.tmdb.org/t/p/w400/.<?php echo $movie->getPoster()?>">
        <div class="card-body">
          <h5 class="card-title"><?php echo $movie->getTitle()?></h5>
          <input value="Buy" class="btn btn-secondary bg-danger text-dark mb-4 col-md-4" type="button" onclick="location='Views/purchase-view.php'" />
          <p class="card-text"><?php echo $movie->getDescription()?></p>
        </div>
      </div></div>
  <?php
  }
?>
  </div>
  </div>

<!--Pŕoximas películas traídas desde la API-->

<hr class=" mt-4 mb-1 bg-danger text-dark">


<?php
    require_once('footer.php');
?>