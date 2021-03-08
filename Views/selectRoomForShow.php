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
<!-- Movie already being broadcasted alert -->
<?php if(!empty($rooms) && !is_array($rooms)){
     echo "<script type='text/javascript'>alert('TITLE ALREADY BEING PROJECTED THIS DAY: Displaying only one aviable room: ".$rooms->getName().".');</script>";
     echo "<script>window.history.go(-2)</script>";
} ?>




<?php




    $start = $start.':00';
    $ends = $ends.':00';
    
    $start = new DateTime($start.'M');
    $ends = new DateTime($ends.'M');

    ?>


<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">

<!-- Page Title -->
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center" style="color:white;" >Select Room:<h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
<!-- Go back button -->

<div style="height: 100px; position: relative;">
  <div class="center">
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-1 mb-2" value="back" onclick="history.back(-1)"> Go Back </button> 
  </div>
</div>

<!-- SHOW CARD -->

<div class="card mb-5 " style="max-width: 500px; margin: auto;">
    <div class="row no-gutters">
        <div class="col-md-4 ">
            <?php
                if($selectedMovie->getPoster() == null){
                    ?><img id="notFoundImageCard" class="mt-4" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">
                    <?php
                }else{
                        ?>
                    <img src="https://image.tmdb.org/t/p/w400/.<?php echo $selectedMovie->getPoster()?>" class="card-img" alt="...">
                    <?php
                }?>

        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Show details:</h5>           
                <ul>
                    <li><strong>Film:  </strong><?php print_r($selectedMovie->getTitle()); ?></li>
                    <li><strong>Date: </strong><?php echo $date ?></li>
                    <li><strong>Starting hour: </strong><?php echo date_format($start, 'H:i');;?> <?php ?></li>
                    <li><strong>Ending hour: </strong> <?php echo date_format($ends, 'H:i');;?><?php ?></li>
                </ul> 
            </div>
        </div>
    </div>
</div>

<!-- CINEMA AND ROOMS TABLE -->
<div class="container-fluid">
    <table class="table table-dark table-hover ">
            <tr>
                <th style="text-align:center" scope="col">CINEMA</td>
                <th style="text-align:center" scope="col">ROOMS</td>
            </tr>
            <form action="<?php echo FRONT_ROOT?>Show/createNewShow" method="POST" class= " mt-5 mb-5">
                <input type="hidden"  value="<?php echo $date?>" name="date" ></input>     
                <input type="hidden"  value="<?php echo $dateToInsert?>" name="dateToInsert" ></input>   
                <input type="hidden"  value="<?php echo $dateToInsertEnd?>" name="dateToInsertEnd" ></input>    
                <input type="hidden"  value="<?php echo $selectedMovie->getMovieID() ?>" name="selectedMovieId" ></input>     
            
            <?php foreach ($cinemas as $oneCinema){ ?>
            <tr>
                <td style="text-align:center" >
                <?php 

                echo 'asdads';
                print_r($oneCinema->getOpenning());
                
                $cinemaStart = new DateTime($oneCinema->getOpenning().'M');
                $cinemaEnd = new DateTime($oneCinema->getClosing().'M');
                echo '<pre>';
                echo '</pre>';
                echo $oneCinema->getName()."<br><i>(". date_format($cinemaStart, 'H.i')." - 
                ". date_format($cinemaEnd,  'H.i')." hrs)</i>"?></td>
                
                <td style="text-align:center">
                    <?php $cinemaFlag = false;
                if(!empty($rooms)){
                    if(is_array($rooms)){
                        
                        foreach ($rooms as $oneRoom) {
                            
                            if($oneRoom->getCinema()->getId() == $oneCinema->getId()){ ?>
                                    
                                    <button type="submit" value="<?php echo $oneRoom->getId()?>" name="roomId" 
                                    <?php 
                                    
                                    
                                    /* if($cinemaEnd < $cinemaStart) { 
                                        $cinemaEnd->modify('+1 day');
                                    } */
                                    $md = '00:00:00';
                                    $midNight = new DateTime('00:00:00'.'M');
                                    //$midNight->format('Y-m-d 00:00:00');
                                   // echo date_format($midNight, 'Y-M-d, H:i:s');
                                    
                                     if(($cinemaStart > $cinemaEnd) && ($cinemaEnd > $midNight)) { 
                                        $start->modify('+12 hours');
                                    }
 

                                          if(($cinemaEnd < $cinemaStart)) { 
                                            $cinemaEnd->modify('+1 day');
                                            
                                        }  


                                        if($ends < $start) { 
                                            $ends->modify('+1 day');
                                        }  



                                    $aux = false;
                                    
                                    if($cinemaStart >= $cinemaEnd) { 
                                        if(($start >= $cinemaStart) && ($ends <= $cinemaEnd)){
                                            $aux = true;
                                        }
                                    }
                                    
                                    if($cinemaStart < $cinemaEnd) { 
                                        if(($start > $cinemaStart) && ($ends < $cinemaEnd)){
                                            $aux = true;
                                        }
                                    }
                                                ?>
                                    <?php if(!$aux) {echo "disabled";}?>

                                    >
                                    
                                    <?php
                                    /* echo date_format($start, 'H:i');
                                        echo '<br>';
                                        echo date_format($ends, 'H:i');
                                        echo '<br>';
                                        echo date_format($cinemaStart, 'H:i');
                                        echo '<br>';
                                        echo date_format($cinemaEnd, 'H:i');
                                        echo '<br>';
                                    */
                                    ;?>
                                    <?php 
                                    
                                          echo date_format($midNight, 'Y-M-d, H:i:s');
                                          echo '<br>';
                                          echo '<br>';
                                       echo date_format($cinemaStart, 'Y-M-d, H:i:s');
                                        echo '<br>';
                                        echo date_format($start, 'Y-M-d, H:i:s');
                                        echo '<br>';
                                        echo date_format($ends, 'Y-M-d, H:i:s');
                                        echo '<br>';
                                        echo date_format($cinemaEnd, 'Y-M-d, H:i:s');
                                        echo '<br>';
                                    
                                    ;?>
                                    <?php echo $oneRoom->getName()?>
                            
                                
                                </button>                               
                
                <?php $cinemaFlag = true;
                            }
                        }
                        if($cinemaFlag == false){ ?>
                            <p><i> No rooms aviable </i></p>
                            
                        <?php }
                    }
                    else{
                        if($rooms->getCinema()->getId() == $oneCinema->getId()){ ?>
                            
                            <button type="submit" value="<?php echo $rooms->getId()?>" name="roomId" ><?php echo $rooms->getName()?></button>

                    <?php }

}
                }
                else{ ?>
                <p><i> No rooms aviable <i></p>
                    
                <?php print_r($oneCinema->getOpenning()); ?> 
                - <?php
          
                print_r($oneCinema->getClosing()); }    ?>
                </td>
            </tr>
                <?php } ?>
            
            </form>
    </table>
</div>
<?php 
                var_dump($cinemaStart); ?> <br>
                - <?php
                var_dump($start);?> <br>
                - <?php
                var_dump($ends);?> <br>
                - <?php
                var_dump($cinemaEnd);     ?><br>


