<hr class="my-4">

<hr class="my-4">
<form class="mt-5 offset-md-3 col-md-5" action="<?php echo FRONT_ROOT ?>Show/modifyShow" method="POST">
    <div class="form-group row"> 
        <div class="col-sm-10">
            <input type="hidden" class="form-control" name="idShow" value=<?php echo $currentShow->getIdShow() ?> >
        </div>
    </div>
    <div class="form-group row"> 
        <div class="col-sm-10">
            <input type="hidden" class="form-control" name="idRoom" value=<?php echo $currentShow->getIdRoom() ?> >
        </div>
    </div>
    <div class="form-group row"> 
        <div class="col-sm-10">
            <input type="hidden" class="form-control" name="idMovie" value=<?php echo $currentShow->getIdMovie() ?> >
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
