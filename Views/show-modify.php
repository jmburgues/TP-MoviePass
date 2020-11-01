<form class="mt-5 offset-md-3 col-md-5" action="<?php echo FRONT_ROOT ?>Show/modifyShow" method="POST">
    <div class="form-group row"> 
        <div class="col-sm-10">
            <input type="hidden" class="form-control" name="idShow" value=<?php echo $currentShow->getIdShow() ?> >
        </div>
    </div>
    <div class="form-group row"> 
    <label for="idRoom" class="col-sm-2 col-form-label">Room</label>
        <div class="col-sm-10">
            <select name="idRoom" id="idRoom">
            <?php foreach($rooms as $room){
               ?>
               <option <?php if($room->getRoomID() == $currentShow->getIdRoom()) echo "selected" ?> value="<?php echo $room->getRoomID()?>">"<?php echo $room->getName()?>"</option> 
               <?php } ?>    
            </select>
        </div>
    </div>
    <div class="form-group row"> 
    <label for="idMovie" class="col-sm-2 col-form-label">Movie</label>
        <div class="col-sm-10">
            <select name="idMovie" id="idMovie">
            <?php foreach($movies as $movie){
               ?>
               <option <?php if($movie->getMovieID() == $currentShow->getIdMovie()) echo "selected" ?> value="<?php echo $movie->getMovieID()?>">"<?php echo $movie->getTitle()?>"</option> 
               <?php } ?>    
            </select>
        </div>
    </div>
    <div class="form-group row"> 
        <div class="col-sm-10">
            <input type="hidden" class="form-control" name="spectators" value=<?php echo $currentShow->getSpectators() ?> >
        </div>
    </div>
    <div class="form-group row"> 
        <div class="col-sm-10">
            <input type="hidden" class="form-control" name="active" value=<?php echo $currentShow->getActive() ?> >
        </div>
    </div>
    <div class="form-group row ">
        <label for="inputName" class="col-sm-2 col-form-label">Date</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" name="date" value=<?php echo $currentShow->getDate() ?> required>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputDireccion" class="col-sm-2 col-form-label">Start</label>
        <div class="col-sm-10">
            <input type="time" class="form-control" name="start" value=<?php echo $currentShow->getStart() ?> required>
        </div>
    </div>
    <!--<button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button> -->
    <button type="submit" name="idShow" class="btn btn-secondary bg-danger text-black col-2  float-right" value="<?php echo $currentShow->getIdShow()?>" >Send</button>
</form>
<br>
