<?php
    require_once('nav.php');
    echo "<br>";
    echo ROOT;
  echo "<br>";
  echo FRONT_ROOT;
  echo "<br>";
  echo VIEWS_PATH;
  echo "<br>";
  ?>
<!--Primer vista al entrar a la página-->
<div class="jumbotron mb-5 mt-5 text-center bg-dark text-white homeTitle" style="opacity:0.9;">
    <h1 class="display-4">Movie Pass</h1>
    <br>
    <p class="lead">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid, hic repellendus. Harum, dolores aliquam! Tenetur sunt illo quis nulla architecto minima! Ipsam, veritatis? Quaerat explicabo error et at corrupti? Totam.</p>
    <hr class="my-4"> 
<input value="Admin tools" type="button" onclick="location='<?php VIEWS_PATH?>User/adminView'"/>
</div>
<hr>


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


<hr class=" mt-4 mb-1 bg-danger text-dark">


<?php
 //   require_once('footer.php');
?>