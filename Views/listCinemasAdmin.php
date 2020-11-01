<hr class="my-4">
    <div class="container  mt-3">   
        <div class="card card-body ">
        <div class="panel-heading">
            <br><h3 style="text-align: center;">Show info:</h3>
        </div>
            <ul>
                <li>Date: <?php echo $date ?></li>
                <li>Starting hour: <?php echo $start ?></li>
                <li>Closing hour: <?php echo $dateToInsertEnd ?></li>
                <li>Movie title: <?php echo $selectedMovie->getTitle() ?></li>
            </ul>
        </div>
    </div>
<hr class="my-4">
        <div class="panel-heading">
            <br><h4 style="text-align: center;">Select Room:</h4>
        </div>
        <?php
        foreach ($rooms as $room) {
            ?>                
            <form action="<?php echo FRONT_ROOT?>Show/addCurrentShow" method="POST" class= " mt-5 mb-5">
            <div class="container  mt-5">           
                <div class="card card-body ">
                    
                        <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                        <input type="hidden"  value="<?php echo $dateToInsert?>" name="dateToInsert" ></input>   
                        <input type="hidden"  value="<?php echo $dateToInsertEnd?>" name="dateToInsertEnd" ></input>    
                        <input type="hidden"  value="<?php echo $selectedMovie->getMovieID() ?>" name="selectedMovieId" ></input>     
                        <button class="font-weight-bold text-center text-uppercase mb-2 bg-danger col-md-2 offset-md-5 text-white"  type="submit" value="<?php echo $room->getRoomId()?>" name="roomId" style=" text-align:left; border: none; background: none;">Add to: <?php echo $room->getName()?></button>
                        <hr style="margin-top: 2px">
                    <ul>
                        <li style="list-style:none">Room Name: <?php echo $room->getName() ?></li>
                        <li style="list-style:none">Room Capacity: <?php echo $room->getCapacity() ?></li>
                        <li style="list-style:none">Room Price: <?php echo $room->getPrice() ?></li>
                        <li style="list-style:none">Room Cinema: <?php echo $room->getIDCinema() //var($this->DAORoom->getByCinema($room->getIDCinema())[0]->getName())  ?></li>

                    </ul>  
                </div>
            </div>
            </form>
        <?php
        }
        ?>






