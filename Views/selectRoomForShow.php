<style>
.container {
  height: 100px;
  position: relative;
  border-bottom: 1px solid #DC3B3B;
}

.center {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
</style>

<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">

<!-- Page Title -->
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center" style="color:white;" >Select Room:<h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
<!-- Go back button -->

<div style="height: 100px; position: relative;">
  <div class="center">
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="history.back(-1)"> Go Back </button> 
  </div>
</div>

<!-- SHOW CARD -->

<div class="card mb-3" style="max-width: 400px; margin: auto;">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="https://image.tmdb.org/t/p/w400/.<?php echo $selectedMovie->getPoster()?>" class="card-img" alt="...">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Show details:</h5>           
                <ul>
                    <li><strong>Film:  </strong><?php print_r($selectedMovie->getTitle()); ?></li>
                    <li><strong>Date: </strong><?php echo $date ?></li>
                    <li><strong>Starting hour: </strong><?php print_r($start);?> <?php ?></li>
                    <li><strong>Ending hour: </strong> <?php print_r($ends);?><?php ?></li>
                </ul> 
            </div>
        </div>
    </div>
</div>

<!-- CINEMA AND ROOMS TABLE -->
<table class="table table-dark table-hover">
        <tr>
            <th style="text-align:center" scope="col">CINEMA</td>
            <th style="text-align:center" scope="col">ROOMS</td>
        </tr>
        <!-- FORM PARA ENVIAR EL ROOM -->
        <form action="<?php echo FRONT_ROOT?>Show/createNewShow" method="POST" class= " mt-5 mb-5">
            <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
            <input type="hidden"  value="<?php echo $dateToInsert?>" name="dateToInsert" ></input>   
            <input type="hidden"  value="<?php echo $dateToInsertEnd?>" name="dateToInsertEnd" ></input>    
            <input type="hidden"  value="<?php echo $selectedMovie->getMovieID() ?>" name="selectedMovieId" ></input>     
        
        <?php foreach ($cinemas as $oneCinema){ ?>
        <tr>
            <td style="text-align:center" ><?php echo $oneCinema->getName()?></td>
            <td style="text-align:center">
                <?php foreach ($rooms as $oneRoom) {
                    if($oneRoom->getCinema()->getId() == $oneCinema->getId()){ ?>
                        
                        <button type="submit" value="<?php echo $oneRoom->getId()?>" name="roomId" ><?php echo $oneRoom->getName()?></button>

                    <?php }
                    } ?>
            </td>
        </tr>
            <?php } ?>
        
        </form>
</table>








