<style>
.container {
  height: 100px;
  position: relative;
  border-bottom: 1px solid #DC3B3B;
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

<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">

<!-- Page Title -->
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center" style="color:white;" >Manage <?php echo $cinema->getName()?>'s rooms:<h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
<!-- New Cinema button -->
<div class="container">
  <div class="center">
  <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/manageCinemas/'"> Go Back </button> 
    <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#newRoom" aria-expanded="false" aria-controls="collapseExample">
        Add new room
    </button>
  </div>
</div>

<!-- New Cinema collapse -->

<div class="collapse" id="newRoom">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white">New room:</h3>
    </div>
    <div class="container mt-2  mb-3" >   
        <div class="card card-body ">
            <form  action="<?php echo FRONT_ROOT ?>Room/addRoom" method="POST">
                <input type="hidden" class="form-control" name="id" value=<?php echo $idCinema?> >
                <div class="form-group row ">
                <label for="inputName" class="col-sm-2 col-form-label"><strong>Name</strong></label>
                
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="Name" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Capacity</strong></label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="capacity" placeholder="Capacity" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Price</strong></label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="price" placeholder="Price" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Room Type</strong></label>         
                <div class="col-sm-10">
                    <select name="roomType" id="roomType">
                        <option value="2DMovie">2D Movie</option>
                        <option value="3DMoovie">3D Movie</option>
                        <option value="Atmos">ATMOS</option>
                    </select> 
                </div>
            </div>
            <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
        </form>
    </div>
    </div>
</div>

<!-- Table with cinema modal buttons -->
<table style="margin-left: auto; margin-right: auto; border:1px solid black;">
    <tr>
        <?php 
        if(empty($rooms)){ ?>
            <h4 class="text-center" style="color:grey;">no rooms added</h4>";
        <?php }else{?>
        <td>
            <?php foreach($rooms as $oneRoom) { ?>
        
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal-<?php echo $oneRoom->getId();?>">
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
                        <button type="submit" class="btn btn-secondary" value="modify" onclick="window.location.href='<?php echo FRONT_ROOT?>Room/modifyRoomView/<?php echo $oneRoom->getId()?>'"> Modify </button>
                        <button type="submit" class="btn btn-secondary" value="delete" onclick="window.location.href='<?php echo FRONT_ROOT?>Room/deleteRoom/<?php echo $oneRoom->getId()?>'"> Delete </button>
                    </div>
                    
                </div>
                </div>
            </div>
        <?php } }?>
        </td>
    </tr>
</table>
