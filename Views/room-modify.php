<style>
.container {
    height: 100px;
    position: relative;
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
<!-- Alert Message Popup -->
<?php  if(!empty($message)) echo "<script type='text/javascript'>alert('$message');</script>";?>

<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">

<!-- Page Title -->
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center" style="color:white;">Modify <?php echo $currentRoom->getCinema()->getName()?>'s room:
        <?php echo $currentRoom->getName()?><h3>
            <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
<!-- Nav Menu -->
<div class="container">
    <div class="center">
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3 mb-2" value="back"
            onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/manageCinemas'"> Go Back </button>
    </div>
</div>

<div class="container mt-2 mb-5">
    <div class="card card-body m-1 ">
        <form action="<?php echo FRONT_ROOT ?>Room/modifyRoom" method="POST">
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="roomID" value=<?php echo $currentRoom->getId() ?>>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="IDCinema"
                        value=<?php echo $currentRoom->getCinema()->getId() ?>>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="active"
                        value=<?php echo $currentRoom->getActive() ?>>
                </div>
            </div>
            <div class="form-group row ">
                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" maxlength="49" name="name"
                        value=<?php echo $currentRoom->getName() ?> required>
                </div>
            </div>
            <div class="form-group row ">
                <label for="inputName" class="col-sm-2 col-form-label">Capacity</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" min='0' max='9999' name="capacity"
                        value=<?php echo $currentRoom->getCapacity() ?> required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputDireccion" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" min='0' max='9999' name="price"
                        value=<?php echo $currentRoom->getPrice() ?> required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputDireccion" class="col-sm-2 col-form-label">Room Type</label>
                <div class="col-sm-10">
                    <select name="roomType" id="roomType">
                        <option value="2DMovie">2D Movie</option>
                        <option value="3DMovie">3D Movie</option>
                        <option value="Atmos">ATMOS</option>
                    </select>
                </div>
            </div>
            <!--<button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button> -->
            <button type="submit" name="idRoom"
                class="btn btn-secondary bg-danger text-black col-2 btn-resp-general float-right"
                value="<?php echo $currentRoom->getId()?>">Send</button>
        </form>
    </div>
</div>