<hr class="my-4">
    <div class="container  mt-3">   
        <div class="card card-body ">
            <ul>
                <li>Dia elegido: <?php echo $date ?></li>
                <li>Hora elegido: <?php echo $start ?></li>
                <li>Espectadores: <?php echo $spectators ?></li>
                <li>Movie elegido: <?php echo $selectedMovie->getTitle()  ?></li>


                </ul>
        </div>
    </div>
<hr class="my-4">
        <?php
        foreach ($rooms as $room) {
            ?>                
            <form action="<?php echo FRONT_ROOT?>Show/addCurrentShow" method="POST" class= " mt-5 mb-5">
            <div class="container  mt-5">           
                <div class="card card-body ">
                        <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                        <input type="hidden"  value="<?php echo $start?>" name="start" ></input>
                        <input type="hidden"  value="<?php echo $spectators?>" name="spectators" ></input>     
                        <input type="hidden"  value="<?php echo $selectedMovie->getMovieID() ?>" name="selectedMovieId" ></input>     
                        <button class="font-weight-bold text-center text-uppercase mb-2"  type="submit" value="<?php echo $room->getRoomId()?>" name="roomId" style=" text-align:left; border: none; background: none;"><?php echo $room->getName()?></button>
                        <hr style="margin-top: 2px">
                    <ul>
                        <li style="list-style:none">room Name: <?php echo $room->getName() ?></li>
                        <li style="list-style:none">room Capacity: <?php echo $room->getCapacity() ?></li>
                        <li style="list-style:none">room Price: <?php echo $room->getPrice() ?></li>
                        <li style="list-style:none">room id cinema: <?php echo $room->getIDCinema() //var($this->DAORoom->getByCinema($room->getIDCinema())[0]->getName())  ?></li>

                    </ul>  
                </div>
            </div>
            </form>
        <?php
        }
        ?>






