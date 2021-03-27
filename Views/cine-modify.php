<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">

<!-- Page Title -->
<div class="mt-3">
    <hr class="mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center text-white">Modify: <?php echo $currentCinema->getName();?><h3>
            <hr class="mt-4 mb-1 bg-danger text-dark">
</div>


<div class="text-center mt-5 mb-3">
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-2 mb-2" value="back"
        onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/manageCinemas'"> Go Back </button>
</div>

<div class="container mt-5">
    <div class="card card-body border-dark ">
        <form action="<?php echo FRONT_ROOT ?>Cinema/modifyCinema" method="POST">
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="idCinema"
                        value=<?php echo $currentCinema->getId() ?>>
                </div>
            </div>
            <div class="form-group row ">
                <label for="inputName" class="col-sm-2 col-form-label"><strong>Name</strong></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" maxlength="29" name="name"
                        value="<?php echo $currentCinema->getName() ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Address</strong></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" maxlength="49" name="address"
                        value="<?php echo $currentCinema->getAddress() ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputNumber" class="col-sm-2 col-form-label"><strong>Number</strong></label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" min="0" max="99999" name="number"
                        value="<?php echo $currentCinema->getNumber() ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputHorario" class="col-sm-2 col-form-label"><strong>Openning</strong></label>
                <div class="col-sm-10">
                    <input type="time" min="00:00" max="23:59" class="form-control" name="openning"
                        value="<?php echo $currentCinema->getOpenning() ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputHorario" class="col-sm-2 col-form-label"><strong>Closing</strong></label>
                <div class="col-sm-10">
                    <input type="time" min="00:00" max="23:59" class="form-control" name="closing"
                        value="<?php echo $currentCinema->getClosing() ?>" required>
                </div>
            </div>
            <button type="submit" name="idCinema"
                class="btn btn-secondary bg-danger text-black col-2 btn-resp-general float-right"
                value="<?php echo $currentCinema->getId()?>">Send</button>
        </form>
    </div>
</div>
<br>