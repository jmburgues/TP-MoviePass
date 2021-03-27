<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">

<!-- Page Title -->
<div class="mt-3">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center text-white">Manage <?php echo $cinema->getName()?>'s rooms:<h3>
            <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>

<!-- New Cinema button -->
<div class="container-cinema">
    <div class="center-cinema">
        <button type="submit" class="btn-resp-cine-back btn btn-secondary bg-danger text-black mt-3" value="back"
            onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/manageCinemas/'"> Go Back </button>
        <button class="btn-resp-cine-new btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse"
            data-target="#newRoom" aria-expanded="false" aria-controls="collapseExample">
            Add new room
        </button>
    </div>
</div>

<!-- New Cinema collapse -->

<div class="collapse" id="newRoom">
    <div class="text-center mt-2 mb-3">
        <h3 class="text-white">New room:</h3>
    </div>
    <div class="container mt-2  mb-3">
        <div class="card card-body ">
            <form action="<?php echo FRONT_ROOT ?>Room/addRoom" method="POST">
                <input type="hidden" class="form-control" name="id" value=<?php echo $idCinema?>>
                <div class="form-group row ">
                    <label for="inputName" class="col-sm-2 col-form-label"><strong>Name</strong></label>

                    <div class="col-sm-10">
                        <input type="text" maxlength="49" class="form-control" name="name" placeholder="Name" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Capacity</strong></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" min="0" max="9999" name="capacity"
                            placeholder="Capacity" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Price</strong></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" min="0" max="9999" name="price" placeholder="Price"
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Room Type</strong></label>
                    <div class="col-sm-10">
                        <select name="roomType" id="roomType">
                            <option value="2DMovie">2D Movie</option>
                            <option value="3DMovie">3D Movie</option>
                            <option value="Atmos">ATMOS</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="button"
                    class="btn-resp-general btn btn-secondary bg-danger text-black col-2  float-right">Send</button>
            </form>
        </div>
    </div>
</div>

<!-- Table with cinema modal buttons -->
<table class="cinema-table">
    <tr>
        <?php 
        if(empty($rooms)){ ?>
        <h4 class="text-center text-secondary mt-5">No rooms added</h4>";
        <?php }else{?>
        <td>
            <?php foreach($rooms as $oneRoom) { ?>

            <button type="button" class="btn btn-info btn-resp-list btn-rooms-td mw-rooms" data-toggle="modal"
                data-target="#myModal-<?php echo $oneRoom->getId();?>">
                <?php echo $oneRoom->getName();?>
            </button>

            <!-- The Modal -->
            <div class="modal fade" id="myModal-<?php echo $oneRoom->getId();?>">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title"><?php echo $cinema->getName()."'s ".$oneRoom->getName()?></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <ul>
                                <li><strong>Capacity:</strong> <?php echo $oneRoom->getCapacity() ?></li>
                                <li><strong>Ticket price:</strong> <?php echo $oneRoom->getPrice() ?></li>
                                <li><strong>Type:</strong> <?php echo $oneRoom->getRoomType() ?></li>
                            </ul>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" value="modify"
                                onclick="window.location.href='<?php echo FRONT_ROOT?>Room/modifyRoomView/<?php echo $oneRoom->getId()?>'">
                                Modify </button>
                            <button type="submit" class="btn btn-secondary" value="delete"
                                onclick="window.location.href='<?php echo FRONT_ROOT?>Room/deleteRoom/<?php echo $oneRoom->getId()?>'">
                                Delete </button>
                        </div>

                    </div>
                </div>
            </div>
            <?php } }?>
        </td>
    </tr>
</table>