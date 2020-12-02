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
<!-- Alert Message Popup -->
<?php  if(!isset($message)) echo "<script type='text/javascript'>alert('$message');</script>";?>

<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">

<!-- Page Title -->
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center" style="color:white;" >Manage Shows<h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
<!-- New Show button -->
<div class="container">
  <div class="center">
  <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView/'"> Go Back </button>   
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#newShow" aria-expanded="false" aria-controls="collapseExample">
        Add new show
    </button>
  </div>
</div>

<!-- New Show collapse -->

<div class="collapse" id="newShow">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white">Add new Show:</h3>
    </div>
    <div class="container mt-5"  >   
        <div class="card card-body border-dark ">
            <form action="<?php echo FRONT_ROOT?>Show/addShow" method="POST" >
                <div class="row">
                    <div class="col mt-2 "><strong>Date: </strong></div>
                    <div class="col mt-2"><input type="date" name="date" step="1" min="<?php echo $oneDayAhead->format("Y-m-d");?>" max="2027-12-31" value="<?php echo $oneDayAhead->format("Y-m-d");?>" required></div>
                    <div class="w-100"></div>
                    
                    <div class="col mt-2"><strong>Starting hour:</strong> </div>
                    <div class="col mt-2"><input type="time" name="start" min="00:00" max="23:59" required/></div>
                    <div class="w-100"></div>
                </div>

                <button type="submit" class="btn btn-secondary bg-danger text-black col-2 mt-2" style="margin-left:80%"  >Send</button>
            </form>  
        </div>
    </div>

</div>

<!-- Table with aviable Cinema and Rooms -->

<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">CINEMA</td>
            <th scope="col">ROOM</td>
            <th scope="col">SHOWS</td>
        </tr>
    </thead>

    <tbody>
    <tr>
      <?php $firstCinema = array_shift($cinemas);
            $firstRoom = array_shift($rooms);
            $firstShow = array_shift($shows); ?>

      <td rowspan="<?php count($cinemas)+1;?>"><?php echo $oneCinema->getName()?></td>

      <!--  ################## A CONTINUAR ####################
                TENGO QUE SACAR EL PRIMER CINE, EL PRIMER ROOM Y EL PRIMER SHOW (QUE CORRESPONDA AL PRIEMR CINE)
                Y MOSTRARLOS EN LA PRIMER <TR>
                EL RESTO SE HACE CON FOREACH
       -->
      <td> </td>
      <!-- PRIMER SALA DEL CINE -->
    </tr>

    <tr>

    <!-- TODO EL FOREACH -->

    </tr>

    <?php foreach($cinemas as $oneCinema){ ?>
        
            <td rowspan="<?php count($cinemas);?>"><?php echo $oneCinema->getName()?></td>
            
            <?php foreach ($rooms as $oneRoom){ 
                    if($oneRoom->getCinema()->getId() == $oneCinema->getId()){ ?>


            <td scope="row"><?php echo $oneRoom->getName()?></td>
                
                
                <?php 
                if(empty($shows)) {
                    echo "<td><h4> No active shows </h4></td>";
                }
                else{
                    foreach ($shows as $oneShow){
                        if($oneShow->getId() == $oneRoom->getId()) { ?>

                <td>
                        <!-- BEGINS Table with Show modal buttons -->
                        <table style="margin-left: auto; margin-right: auto; border:1px solid black;">
                            <tr>
                                <td>                
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal-<?php echo $aShow->getId();?>">
                                    <?php echo $oneShow->getName();?>
                                    </button>

                                    <!-- The Modal -->
                                    <div class="modal fade" id="myModal-<?php echo $oneShow->getId();?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                            <h4 class="modal-title"><?php echo "Date: ".$oneShow->getDate();?></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                            <ul>
                                                <li><strong>Starting hour:</strong> <?php echo $show->getStart() ?></li>
                                                <li><strong>Ending hour:</strong> <?php echo $show->getEnd() ?></li>
                                                <li><strong>Spectators:</strong> <?php echo $show->getSpectators()?></li>
                                                <li><strong>Movie:</strong> <?php echo $show->getMovie()->getTitle();?></li>  
                                            </ul>
                                            </div>
                                            
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/modifyCinemaForm/<?php echo $oneCinema->getId()?>'"> Modify </button>
                                            <button type="submit" class="btn btn-secondary" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/deleteCinema/<?php echo $oneCinema->getId()?>'"> Delete </button>
                                            </div>
                                            
                                        </div>
                                        </div>
                                    </div>    
                                </td>
                            </tr>
                        </table>
                        <!-- END Table with Show modal buttons -->
                </td>
                        <?php }
                            } 
                        } 
                } 
            } ?>
             
        </tr>

    <?php 
        } ?>
    </tbody>

</table>


<!-- ################ MODELO DE TABLA QUE FUNCIONA

                MODELO DE TABLA QUE FUNCIONA:

<table>

    <tr>
    <td>CINE</td>
    <td>SALAS</td>
    <td>SHOWS</td>
    </tr>
    
    <tr>
        <td rowspan="3">1</td>
        <td>S1</td>
        <td>D1</td>
    </tr>
    
    <tr>
        <td>S2</td>
        <td>D2</td>
    </tr>

    <tr>
        <td>S3</td>
        <td>D3</td>
    </tr>

    <tr>
        <td rowspan="3">2</td>
        <td>S1</td>
        <td>D1</td>
    </tr>

    <tr>
        <td>S2</td>
        <td>D2</td>
    </tr>

    <tr>
        <td>S3</td>
        <td>D3</td>
    </tr>

</table>
 -->