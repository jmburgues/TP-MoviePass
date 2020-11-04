<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Manage <?php echo $cinemaName?>'s Rooms:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/showCinemas'"> Go Back </button> 
</div>

<!-- COLLAPSE CARD EXISTENT ROOM -->

<p style="margin-left:10%;">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#new" aria-expanded="false" aria-controls="collapseExample">
    Add new room
  </button>
</p>

<div class="collapse" id="new">

    <div class="text-center mt-5 mb-3">
        <h3 class="text-white">New room:</h3>
    </div>
    <div class="container mt-5  mb-3" >   
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

<!-- COLLAPSE CARD NEW ROOM -->

<p style="margin-left:10%;">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#existent" aria-expanded="false" aria-controls="collapseExample">
    Show existent rooms
  </button>
</p>

<div class="collapse" id="existent">

    <div class="text-center mt-5 mb-3">
        <h3 class="text-white">Existent Rooms:</h3>    
    </div>

    <?php 
        if(is_array($rooms)){
        foreach ($rooms as $room) {
            ?>
            <div class="container mt-5  mb-3">   
                <div class="card card-body ">
                <ul>
                    <li><strong>Name: </strong><?php echo $room->getName() ?></li>
                    <li><strong>Capacity:</strong> <?php echo $room->getCapacity() ?></li>
                    <li><strong>Ticket price:</strong> <?php echo $room->getPrice() ?></li>
                    <li><strong>Type:</strong> <?php echo $room->getRoomType() ?></li>
                    <li><strong>Cinema:</strong> <?php echo $cinema->getName() ?></li>
                    <li style="list-style:none">
                 <div class="btn-group" role="group" aria-label="Basic example">     
                        <form action="<?php echo FRONT_ROOT?>Room/modifyRoomView" method="POST">
                            <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $room->getRoomID()?>"   name="idRoomM">Modify</button> 
                        </form>
                        <form action="<?php echo FRONT_ROOT?>Room/deleteRoom" method="POST">
                            <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $room->getRoomID()?>"   name="idRoomD">Delete</button> 
                        </form>
                        </div>
                
                    </li>         
                </ul>
                </div>
            </div>
    <?php } }
        else{
            $room = $rooms;
            ?>
            <div class="container mt-5  mb-3">   
                <div class="card card-body ">
                <ul>
                    <li><strong>Room Name: </strong><?php echo $room->getName() ?></li>
                    <li><strong>Room capacity:</strong> <?php echo $room->getCapacity() ?></li>
                    <li><strong>Room price:</strong> <?php echo $room->getPrice() ?></li>
                    <li><strong>Nombre cinema: </strong><?php echo $cinema->getName(); ?></li>
                    <li style="list-style:none">
            <!--     <div class="btn-group" role="group" aria-label="Basic example">     
                        <form action="<?php echo FRONT_ROOT?>Room/modifyRoomView" method="POST">
                            <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $room->getRoomID()?>"   name="idRoomM">Modify</button> 
                        </form>
                        <form action="<?php echo FRONT_ROOT?>Room/deleteRoom" method="POST">
                            <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $room->getRoomID()?>"   name="idRoomD">Delete</button> 
                        </form>
                        </div>
                -->
                    </li>         
                </ul>
                </div>
                </div>
       <?php }
        ?> <?php if(!$rooms){
            ?>
            <div class="container mt-5">   
                <div class="card card-body ">
                    <?php echo "No room loaded yet"?>  
                </div>
            </div>
        <?php
        }   ?>
    

