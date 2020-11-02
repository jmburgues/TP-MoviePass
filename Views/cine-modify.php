<div class="text-center mt-5 mb-3">
        <h3 class="text-white">Cinema to modify :</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/showCinemas'"> Go Back </button> 
    </div>
<div class="container mt-5" >   
    <div class="card card-body border-dark ">
        <form action="<?php echo FRONT_ROOT ?>Cinema/modifyCinema" method="POST">
            <div class="form-group row"> 
                <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="id" value=<?php echo $currentCinema->getId() ?> >
                </div>
            </div>
            <div class="form-group row ">
                <label for="inputName" class="col-sm-2 col-form-label"><strong>Name</strong></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value=<?php echo $currentCinema->getName() ?> required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Address</strong></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" value=<?php echo $currentCinema->getAddress() ?> required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputNumber" class="col-sm-2 col-form-label"><strong>Number</strong></label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="number" value=<?php echo $currentCinema->getNumber() ?> required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputHorario" class="col-sm-2 col-form-label"><strong>Openning</strong></label>
                <div class="col-sm-10">
                    <input type="time" min="00:00" max="23:59" class="form-control" name="openning" value=<?php echo $currentCinema->getOpenning() ?> required>
                </div>
            </div>  
            <div class="form-group row">
                <label for="inputHorario" class="col-sm-2 col-form-label"><strong>Closing</strong></label>
                <div class="col-sm-10">
                    <input type="time" min="00:00" max="23:59" class="form-control" name="closing" value=<?php echo $currentCinema->getClosing() ?>  required>
                </div>
            </div>
            <button type="submit" name="idCinema" class="btn btn-secondary bg-danger text-black col-2  float-right" value="<?php echo $currentCinema->getId()?>" >Send</button>
        </form>
    </div>
</div></div>
</div>
    <br>
