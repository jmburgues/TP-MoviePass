<?php
    require_once('nav.php');
    require_once('header.php');
    
?>
<!--Estilo de la página-->
    <style type="text/css">
            body {
                background-color: white; 
                background-image: none; 
            }
            </style>
<?php 
/*    echo $date;
    echo $time;
    echo "<pre>";
    print_r($selectedMovie);
    echo "</pre>";
    echo "<pre>";
    print_r($rooms);
    echo "</pre>";
*/?>             
    
    <?php 
    
?>             
<hr class="my-4">
    <div class="container  mt-3">   
        <div class="card card-body ">
            <ul>
                <li>Dia elegido: <?php echo $date ?></li>
                <li>Hora elegido: <?php echo $time ?></li>
                <li>Película elegido: <?php echo $selectedMovie->getTitle() ?></li>
            </ul>
        </div>
    </div>
<hr class="my-4">
        <?php
        foreach ($rooms as $room) {
            ?>                
            <form action="<?php echo FRONT_ROOT?>Show/addCurrentShow" method="POST" class= " mt-5">
            <div class="container  mt-5">           
                <div class="card card-body ">
                        <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                        <input type="hidden"  value="<?php echo $time?>" name="time" ></input>     
                        <input type="hidden"  value="<?php echo $spectators?>" name="spectators" ></input>     
                        <input type="hidden"  value="<?php echo $selectedMovie->getMovieId() ?>" name="selectedMovie" ></input>     
                        <button class="font-weight-bold text-center text-uppercase mb-2"  type="submit" value="<?php echo $room->getRoomId()?>" name="roomId" style=" text-align:left; border: none; background: none;"><?php echo $room->getName()?></button>
                        <hr style="margin-top: 2px">
                    <ul>
                        <li style="list-style:none">room Name: <?php echo $room->getName() ?></li>
                        <li style="list-style:none">room Capacity: <?php echo $room->getCapacity() ?></li>
                        <li style="list-style:none">room Price: <?php echo $room->getPrice() ?></li>
                    </ul>  
                </div>
            </div>
            </form>
        <?php
        }
        ?>






