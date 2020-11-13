<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Select show:</h3>
</div>

<div class="container border p-4 col-md-6 form loginCard" >
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
              foreach ($moviesForShows as $show) {
                  ?>
              <option value="<?php echo $show->getIdShow(); ?>"  >
              <?php echo $show->getRoom()->getCinema()->getName(), ", room: " , $show->getRoom()->getName(), ", DATE  "  , $show->getDate(), ", SHOW TIME: " ,substr($show->getStart(), 0, -3), " - " , substr($show->getEnd(), 0, -3)?>
              </option> 
                  <?php
              }
            ?>
                    <?php if($moviesForShows ==null){
                    ?> <option value="Out stock">Out stock </option> 
                    <?php
                    }  ?>
                    
          </select>
        </div>
        <br>
        <div style="float: right; padding:10px;">
          <input type="submit" class="btn btn-secondary bg-danger text-black mt-3" <?php echo $moviesForShows!=null ? " " : "disabled" ?>  class=" btn btn-primary bg-danger text-white mt-3 col-md-3" value="Next"></input>
        </div>
    </form>
    <div style="float: left; padding:10px;">
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Previous </button> 
    </div>
  </div>
</div>