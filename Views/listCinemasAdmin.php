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
            <li><strong>Ending hour:</strong> <?php echo $ends ?></li>
            <li><strong>Movie title: </strong><?php echo $selectedMovie->getTitle() ?></li>
        </ul>
    </div>
</div>

<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Select Room :</h3>
</div>
        <?php
        if (isset($rooms)) {
            foreach ($rooms as $room) {
                ?>                
            <form action="<?php echo FRONT_ROOT?>Show/addCurrentShow" method="POST" class= " mt-5 mb-5">
            <div class="container  mt-5">           
                <div class="card card-body ">
                    
                        <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                        <input type="hidden"  value="<?php echo $dateToInsert?>" name="dateToInsert" ></input>   
                        <input type="hidden"  value="<?php echo $dateToInsertEnd?>" name="dateToInsertEnd" ></input>    
                        <input type="hidden"  value="<?php echo $selectedMovie->getMovieID() ?>" name="selectedMovieId" ></input>     
                        <button class="font-weight-bold text-center text-uppercase mb-2 bg-danger col-md-2 offset-md-5 text-white buttonList"  type="submit" value="<?php echo $room->getRoomId()?>" name="roomId" >Add to: <?php echo $room->getName()?></button>
                        <hr class="marginTop2">
                    <ul>
                        <li class="liStyleNone"><strong>Room Name:</strong> <?php echo $room->getName() ?></li>
                        <li class="liStyleNone"><strong>Room Capacity:</strong> <?php echo $room->getCapacity() ?></li>
                        <li class="liStyleNone"><strong>Room Price:</strong> <?php echo $room->getPrice() ?></li>
                        <li class="liStyleNone"><strong>Room Cinema: </strong><?php echo $room->getCinema()->getName() //var($this->DAORoom->getByCinema($room->getCinema()->getId())[0]->getName())?></li>

                    </ul>  
                </div>
            </div>
            </form>
        <?php
            }
        }
        if($rooms == null){?>
            <div class= "container">    
                <div class="card card-body ">
                    <?php echo "No rooms loaded yet"?>  
                </div>
                </div>
        <?php
        }
        ?>






