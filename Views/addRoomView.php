<?php
    require_once('nav.php');
    require_once('header.php');
    
?>

    <?php 
        if(is_array($rooms)){
        foreach ($rooms as $room) {
            ?>
            <div class="container mt-5">   
                <div class="card card-body ">
                <ul>
                    <li>Room Name: <?php echo $room->getName() ?></li>
                    <li>Room capacity: <?php echo $room->getCapacity() ?></li>
                    <li>Room price: <?php echo $room->getPrice() ?></li>
                    <li>Nombre cinema: <?php echo $cinema->getName(); ?></li>
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
                <?php
        }
        }else{
            $room = $rooms;
            ?>
            <div class="container mt-5">   
                <div class="card card-body ">
                <ul>
                    <li>Room Name: <?php echo $room->getName() ?></li>
                    <li>Room capacity: <?php echo $room->getCapacity() ?></li>
                    <li>Room price: <?php echo $room->getPrice() ?></li>
                    <li>Nombre cinema: <?php echo $cinema->getName(); ?></li>
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
                    <?php echo "No cinemas loaded yet"?>  
                </div>
            </div>
        <?php
        }   ?>
        <div class="container mt-5" >   

<form  action="<?php echo FRONT_ROOT ?>Room/addRoom" method="POST">
        <input type="hidden" class="form-control" name="id" value=<?php echo $idCinema?> >
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputDireccion" class="col-sm-2 col-form-label">Capacity</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="capacity" placeholder="Capacity" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputDireccion" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="price" placeholder="Price" required>
            </div>
        </div>
        <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
    </form>
<!--container--></div>
<br>


<br>
<br>
<br>
