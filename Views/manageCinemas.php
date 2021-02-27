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

<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>Views/css/adminStyle.css">

<!-- Message Popup -->

<?php 
if (isset($message)){
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
?>

<!-- Page Title -->
<div style="margin-top:10px;">
    <hr class=" mt-2 mb-4 bg-danger text-dark">
    <h3 class="text-center" style="color:white;" >Manage Cinemas<h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
</div>
<!-- New Cinema button -->
<div class="container">
  <div class="center">
  <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView/'"> Go Back </button>   
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#newCinema" aria-expanded="false" aria-controls="collapseExample">
        Add new cinema
    </button>
  </div>
</div>

<!-- New Cinema collapse -->

<div class="collapse" id="newCinema">
    <div class="text-center mt-2 mb-2">
        <h3 class="text-white">Add new Cinemas:</h3>
    </div>
    <div class="container mt-2"  >   
        <div class="card card-body border-dark ">
            <form  action="<?php echo FRONT_ROOT ?>Cinema/AddCinema" method="POST">
                <div class="form-group row ">
                    <label for="inputName" class="col-sm-2 col-form-label"><strong>Name</strong></label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="29" class="form-control" name="name" placeholder="Example Cinema" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDireccion" class="col-sm-2 col-form-label"><strong>Street:</strong></label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="49" class="form-control" name="address" placeholder="Example Street" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputNumber" class="col-sm-2 col-form-label"><strong>St. Number:</strong></label>
                    <div class="col-sm-10">
                        <input type="number" max="99999" min="0" class="form-control" name="number" placeholder="1234" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputHorario" class="col-sm-2 col-form-label"><strong>Openning hour:</strong></label>
                    <div class="col-sm-10">
                    <input type="time"   min="00:00" max="23:59" class="form-control" name="openning" placeholder="00:00" value="00:00">

                    </div>
                </div>  
                <div class="form-group row">
                    <label for="inputHorario" class="col-sm-2 col-form-label"><strong>Closing hour:</strong></label>
                    <div class="col-sm-10">
                    <input type="time"   min="00:00" max="23:59" class="form-control" name="closing" placeholder="23:59" value="23:59">
                    
                    </div>
                </div>
            <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
            </form>
        </div>
    </div>

</div>

<!-- Table with cinema modal buttons -->
<table style="margin-left: auto; margin-right: auto; border:1px solid black;">
    <tr>
        <?php 
        if(empty($cinema)){ ?>
            <h4 class="text-center" style="color:grey;">no cinemas added</h4>";
        <?php }else{?>
        <td>
            <?php foreach($cinema as $oneCinema) { ?>
        
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal-<?php echo $oneCinema->getId();?>">
            <?php echo $oneCinema->getName();?>
            </button>

            <!-- The Modal -->
            <div class="modal fade" id="myModal-<?php echo $oneCinema->getId();?>">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title"><?php echo $oneCinema->getName()." cinema";?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    <ul>
                        <li><strong>Street: </strong><?php echo $oneCinema->getAddress(); echo " ".$oneCinema->getNumber(); ?></li>
                        <li><strong>Opening hour:  </strong><?php echo $oneCinema->getOpenning(); ?></li>
                        <li><strong>Closing hour:  </strong><?php echo $oneCinema->getClosing(); ?></li>    
                    </ul>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Room/manageRooms/<?php echo $oneCinema->getId()?>'"> Rooms </button>
                    <button type="submit" class="btn btn-secondary" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/modifyCinemaForm/<?php echo $oneCinema->getId()?>'"> Modify </button>
                    <button type="submit" class="btn btn-secondary" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>Cinema/deleteCinema/<?php echo $oneCinema->getId()?>'"> Delete </button>
                    </div>
                    
                </div>
                </div>
            </div>
        
        
        <?php } }?>
        </td>
    </tr>
</table>
