


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