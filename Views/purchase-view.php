<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Select the options for your purchase:</h3>
    <h3 class="text-white">Welcome <?php echo  $userName ?> ! </h3> 
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Back </button> 
</div>

<div class="container border p-4 col-md-6 form" style="background-color:#FFFFFF; margin-top:6%;">
  <div class="mt-3">
    <div class="form-group">
      <label for="idRoom" ><strong>Movie</strong></label>
      <input readonly type="text" class="form-control font-weight-bold"  placeholder="<?php echo $selectedMovie->getTitle()?>" name="movie">
    </div>

    <form  action="<?php echo FRONT_ROOT ?>Ticket/getMinMax" method="POST"  name="show" id="show" >
      <div class="form-group" >
        <label ><strong>Function</strong></label>
        <select class="custom-select" name="idShow" id="idShow" >
          <?php 
          foreach($moviesForShows as $show ){ 
            ?>
            <option value="<?php echo $show->getIdShow();?>"  >
            <?php echo "ROOM: " , $show->getIdRoom(),  " DATE "  , $show->getDate(), " START " , $show->getStart(), " END " , $show->getEnd() ?>
            </option> 
                <?php
            }?>
          </select>
        </div>

      <div class="text-center">
        <input type="submit" class="btn btn-primary bg-danger text-white mt-3 col-md-3" value="Next"></input>
      </div>

    </form>
  </div>
</div>