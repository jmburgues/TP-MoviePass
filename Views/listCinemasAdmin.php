<div class="text-center mt-5 mb-3">
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Show/showShows'"> Go to Shows List </button>
</div>

<div class="container mt-5 mb-5">   
    <div class="card card-body m-1">
    <h3 class="text-center">Show info :</h3>
        <hr>
        <ul>
            <li><strong>Date: </strong><?php echo $date ?></li>
            <li><strong>Starting hour:</strong> <?php echo $start ?></li>
            <li><strong>Closing hour:</strong> <?php echo $dateToInsertEnd ?></li>
            <li><strong>Movie title: </strong><?php echo $selectedMovie->getTitle() ?></li>
        </ul>
    </div>
</div>

<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Select Room :</h3>
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
                        <li style="list-style:none"><strong>Room Name:</strong> <?php echo $room->getName() ?></li>
                        <li style="list-style:none"><strong>Room Capacity:</strong> <?php echo $room->getCapacity() ?></li>
                        <li style="list-style:none"><strong>Room Price:</strong> <?php echo $room->getPrice() ?></li>
                        <li style="list-style:none"><strong>Room Cinema: </strong><?php echo $room->getIDCinema() //var($this->DAORoom->getByCinema($room->getIDCinema())[0]->getName())  ?></li>

                    </ul>  
                </div>
            </div>
            </form>
        <?php
        }
        ?>






