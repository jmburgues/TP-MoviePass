<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Modify Room :</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/showCinemas'"> Go Back </button> 
</div>


<div class="container mt-5 mb-5">   
    <div class="card card-body m-1 ">
    <form  action="<?php echo FRONT_ROOT ?>Room/modifyRoom" method="POST">
        <div class="form-group row"> 
            <div class="col-sm-10">
                <input type="hidden" class="form-control" name="roomID" value=<?php echo $currentRoom->getRoomID() ?> >
            </div>
        </div>
        <div class="form-group row"> 
            <div class="col-sm-10">
                <input type="hidden" class="form-control" name="IDCinema" value=<?php echo $currentRoom->getCinema()->getId() ?> >
            </div>
        </div>
        <div class="form-group row"> 
            <div class="col-sm-10">
                <input type="hidden" class="form-control" name="active" value=<?php echo $currentRoom->getActive() ?> >
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value=<?php echo $currentRoom->getName() ?> required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Capacity</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="capacity" value=<?php echo $currentRoom->getCapacity() ?> required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputDireccion" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" value=<?php echo $currentRoom->getPrice() ?> required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputNumber" class="col-sm-2 col-form-label">Room Type</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="roomType" value=<?php echo $currentRoom->getRoomType() ?> required>
            </div>
        </div>
        <!--<button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button> -->
        <button type="submit" name="idRoom" class="btn btn-secondary bg-danger text-black col-2  float-right" value="<?php echo $currentRoom->getRoomID()?>" >Send</button>
    </form>
    </div>
    </div>
