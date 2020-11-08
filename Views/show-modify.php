
<div class="text-center mt-5 mb-3">
    <h3 class="text-center text-white">Modify Show :</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Show/showShows'"> Back</button>
</div>

<div class="container mt-5 mb-5">   
    <div class="card card-body m-1">    
        <form class="offset-md-1" action="<?php echo FRONT_ROOT ?>Show/modifyShow" method="POST">
            <div class="form-group row"> 
                <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="idShow" value=<?php echo $currentShow->getIdShow() ?> >
                </div>
            </div>
            <div class="form-group row"> 
                <label for="idRoom" class="col-sm-1 col-form-label"><strong>Room:</strong></label>
                    <div class="col-sm-10">
                        <select class="custom-select"  name="idRoom" id="idRoom">
                        <?php foreach($rooms as $room){
                        ?>
                        <option <?php if($room->getRoomID() == $currentShow->getRoom()->getRoomID()) echo "selected" ?> value="<?php echo $room->getRoomID()?>"><?php echo $room->getName()?></option> 
                        <?php } ?>    
                        </select>
                    </div>
            </div>
            <div class="form-group row"> 
                <label for="idMovie" class="col-sm-1 col-form-label"><strong>Movie:</strong></label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="idMovie" id="idMovie">
                        <?php foreach($movies as $movie){
                        ?>
                        <option <?php if($movie->getMovieID() == $currentShow->getMovie()->getMovieID()) echo "selected" ?> value="<?php echo $movie->getMovieID()?>"><?php echo $movie->getTitle()?></option> 
                        <?php } ?>    
                        </select>
                    </div>
            </div>
            <div class="form-group row ">
                <label for="inputName" class="col-sm-1 col-form-label"><strong>Date:</strong></label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="date" value=<?php echo $currentShow->getDate() ?> required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputDireccion" class="col-sm-1 col-form-label"><strong>Hour:</strong></label>
                <div class="col-sm-10">
                    <input type="time" class="form-control" name="start" value=<?php echo $currentShow->getStart() ?> required>
                </div>
            </div>
            <!--<button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button> -->
            <button type="submit" name="idShow" class="btn btn-secondary bg-danger text-black col-2  float-right" value="<?php echo $currentShow->getIdShow()?>" >Send</button>
        </form>
    </div>
</div>
<br>
