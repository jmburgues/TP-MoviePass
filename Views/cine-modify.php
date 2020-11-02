<hr class="my-4">
<div class="container mt-5"  style="height:850px">   
    <div class="card card-body border-dark ">


    <form class="mt-5 offset-md-2 col-md-6" action="<?php echo FRONT_ROOT ?>Cinema/modifyCinema" method="POST">
        <div class="form-group row"> 
            <div class="col-sm-10">
                <input type="hidden" class="form-control" name="id" value=<?php echo $currentCinema->getId() ?> >
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value=<?php echo $currentCinema->getName() ?> required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputDireccion" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address" value=<?php echo $currentCinema->getAddress() ?> required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputNumber" class="col-sm-2 col-form-label">Number</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="number" value=<?php echo $currentCinema->getNumber() ?> required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputHorario" class="col-sm-2 col-form-label">Openning</label>
            <div class="col-sm-10">
                <input type="time" min="00:00" max="23:59" class="form-control" name="openning" value=<?php echo $currentCinema->getOpenning() ?> required>
            </div>
        </div>  
        <div class="form-group row">
            <label for="inputHorario" class="col-sm-2 col-form-label">Closing</label>
            <div class="col-sm-10">
                <input type="time" min="00:00" max="23:59" class="form-control" name="closing" value=<?php echo $currentCinema->getClosing() ?>  required>
            </div>
        </div>
        <!--<button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button> -->
        <button type="submit" name="idCinema" class="btn btn-secondary bg-danger text-black col-2  float-right" value="<?php echo $currentCinema->getId()?>" >Send</button>
    </form>
    </div>
</div></div>
</div>
    <br>
