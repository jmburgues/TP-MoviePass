<style>
.container {
  height: 100px;
  position: relative;
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
<?php  if(!empty($message)) echo "<script type='text/javascript'>alert('$message');</script>";?>

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
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-1" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView/'"> Go Back </button>   
    <button class="btn btn-primary bg-danger text-black mt-1" type="button" data-toggle="collapse" data-target="#newShow" aria-expanded="false" aria-controls="collapseExample">Add new show</button>
  </div>
</div>

<!-- New Show collapse -->

<div class="collapse" id="newShow">
    <div class="text-center mt-2 mb-2">
        <h4 class="text-white">Add new Show:</h3>
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

<table class="table table-dark" style="width: 100%">
    <colgroup>
       <col span="1" style="width: 15%;">
       <col span="1" style="width: 15%;">
       <col span="1" style="width: 70%;">
    </colgroup>
    <thead>
        <tr>
            <th style="text-align:center;" scope="col">CINEMA</td>
            <th style="text-align:center;" scope="col">ROOM</td>
            <th style="text-align:center;" scope="col">SHOWS</td>
        </tr>
    </thead>

    <tbody>

    <?php foreach($cinemas as $oneCinema){ ?>
        <tr> 
        <!-- TENGO QUE CONTAR LAS ROOMS QUE PERTENECEN AL CINEMA EN EL QUE ESTOY -->
            
            <?php
            $value = 1;
            foreach ($rooms as $oneRoom){ 
                if($oneRoom->getCinema()->getId() == $oneCinema->getId()){ 
                    $value++;
                }
            } ?>
            <td style="text-align:center;" rowspan="<?php echo $value?>"><?php echo $oneCinema->getName()?></td>
            <td hidden></td>              
            <td hidden></td>
        </tr>
            
        <?php foreach ($rooms as $oneRoom){ 
                if($oneRoom->getCinema()->getId() == $oneCinema->getId()){ ?>

        <tr>
            <td stye="text-align:center;" scope="row"><?php echo $oneRoom->getName()?></td>
                            
            <?php 
            if(empty($shows)) {
                echo "<td><p> No active shows </h4></p>";
            }
            else{
                foreach ($shows as $oneShow){
                    if($oneShow->getRoom()->getId() == $oneRoom->getId()) { ?>

            <td style="display:inline-block">
            
                <!-- BEGINS Table with Show modal buttons -->
 
                        <button type="button" data-toggle="modal" data-target="#myModal-<?php echo $oneShow->getIdShow();?>">
                        <?php echo $oneShow->getDate().": ".$oneShow->getMovie()->getTitle();?>
                        </button>

                        <!-- The Modal -->
                        <div class="modal fade" id="myModal-<?php echo $oneShow->getIdShow();?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title text-dark"><?php echo "Date: ".$oneShow->getDate();?></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body text-dark"">
                                    <ul>
                                        <li><strong>Starting hour:</strong> <?php echo $oneShow->getStart() ?></li>
                                        <li><strong>Ending hour:</strong> <?php echo $oneShow->getEnd() ?></li>
                                        <li><strong>Spectators:</strong> <?php echo $oneShow->getSpectators()?></li>
                                        <li><strong>Movie:</strong> <?php echo $oneShow->getMovie()->getTitle();?></li>  
                                    </ul>
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer text-dark"">
                                    <button type="submit" class="btn btn-secondary" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Show/modifyShowView/<?php echo $oneShow->getIdShow()?>'"> Modify </button>
                                    <button type="submit" class="btn btn-secondary" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Show/removeShow/<?php echo $oneShow->getIdShow()?>'"> Delete </button>
                                </div>
                                
                            </div>
                            </div>
                        </div>    
                <!-- END Table with Show modal buttons -->       
            </td>
                    <?php }
                        } 
                    } ?>    
        </tr>
            <?php }
            } 
        } ?>
    </tbody>

</table>
