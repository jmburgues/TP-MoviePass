
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">
<hr class=" mt-2 mb-4 bg-danger text-dark">
<div class="text-center mt-5 mb-3">
        <h3 class="text-white">Sale statistics:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'"> Go Back </button> 
    </div>
<br>
<hr class=" mt-2 mb-4 bg-danger text-dark">

<div class="container  mt-5 mb-5" id="seleccion">       
    <div class="card card-body  border-dark  ">
        <ul>
            <li class="liStyleNone"><strong>Total income:  </strong><?php echo $totalCostSold ?></li>
            <li class="liStyleNone"><strong>Total ticket sold:  </strong><?php echo $totalTicketsAmount ?></li>
        </ul>   
    </div>  
</div>




<p class="text-center mt-5 mb-3">
    <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#betweenDates" aria-expanded="false" aria-controls="collapseExample">
        Check between dates
    </button>
</p>



<div class="collapse" id="betweenDates">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white">Choose the dates:</h3>
    </div>
    <div class="container mt-5"  >   
        <div class="card card-body border-dark ">
            <form  action="<?php echo FRONT_ROOT ?>Sale/statistics" method="POST">
                <div class="form-group row">
                    <label for="inputHorario" class="col-sm-2 col-form-label"><strong>First date:</strong></label>
                    <div class="col-sm-10">
                    <input  type="date" class="form-control" name="openning">

                    </div>
                </div>  
                <div class="form-group row">
                    <label for="inputHorario" class="col-sm-2 col-form-label"><strong>Last date:</strong></label>
                    <div class="col-sm-10">
                    <input  type="date"  class="form-control" name="closing">
                    
                    </div>
                </div>
            <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2 btn-resp-sales float-right" >Send</button>
            </form>
        </div>
    </div>
</div>




<!------------------------>
<?php if(isset($ticketByShow)){ ?>
<p class="text-center">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#existentShow" aria-expanded="false" aria-controls="collapseExample">
        Total sales per Shows
  </button>
</p>

<div class="collapse" id="existentShow">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white"> Sales per Shows:</h3>
    </div>
    

    <div class="container mt-5 mb-5" >
    <table class="table" style="background-color:white;">
    <thead class="thead-dark">
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Date</th>
        <th scope="col">Tickets sold</th>
        <th scope="col">Total income</th>
        <th scope="col">Total unsold</th>
        </tr>
    </thead>
    </div>
    <?php
        if (isset($ticketByShow)) {
            foreach ($ticketByShow as $notShow) {
                ?>                
                <tbody>
                <tr>
                    <td><?php echo $notShow['nameShow']?></td>
                    <td><?php echo $notShow['dateShow']?></td>
                    <td><?php echo $notShow['ticketAmount'] ?></td>
                    <td><?php echo $notShow['ticketSold'] ?></td>
                    <td><?php echo $notShow['unsoldTickets'] ?></td>
                </tr>
            <?php
            } 
        }
    }
        ?>
</tbody>
</table>

</div>


</div>

<!------------------------>
<p class="text-center">
  <button class="btn btn-primary bg-danger text-black mt-3 " type="button" data-toggle="collapse" data-target="#existentCinema" aria-expanded="false" aria-controls="collapseExample">
        Total sales per Cinema
  </button>
</p>

<div class="collapse" id="existentCinema">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white"> Sales per Cinema:</h3>
    </div>

    <div class="container mt-5 mb-5" >
    <table class="table" style="background-color:white;">
    <thead class="thead-dark">
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Tickets sold</th>
        <th scope="col">Total income</th>
        <th scope="col">Total unsold</th>
        </tr>
    </thead>
    </div>

    <?php
        if (isset($ticketByCinema)) {    
            foreach ($ticketByCinema as $notCinema) {
                ?>          
                <tbody>      
                    <tr>
                        <td><?php echo $notCinema['nameCinema']?></td>
                        <td><?php echo $notCinema['ticketAmount'] ?></td>
                        <td><?php echo $notCinema['ticketSold'] ?></td>
                        <td><?php echo  $notCinema['unsoldTickets'] ?></td>
                    </tr>
                    <?php
                }
                ?>
                    <?php
                }
                if(!$ticketByCinema){
                    ?>
                    <div class="container mt-5 mb-5">   
                        <div class="card card-body ">
                            <?php echo "No tickets per cinemas sold yet"?>  
                        </div>
                    </div>
                <?php
                }   ?>
            </tbody>
        </table>
    </div>

</div>

<!------------------------>
<p class="text-center">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#existentRoom" aria-expanded="false" aria-controls="collapseExample">
        Total sales per Room
  </button>
</p>

<div class="collapse" id="existentRoom">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white"> Sales per Room:</h3>
    </div>

    <div class="container mt-5 mb-5" >
    <table class="table" style="background-color:white;">
    <thead class="thead-dark">
        <tr>
        <th scope="col">Name Cinema</th>
        <th scope="col">Name Room</th>
        <th scope="col">Tickets sold</th>
        <th scope="col">Total income</th> 
        <th scope="col">Total unsold</th>
        </tr>
    </thead>
    </div>

    <?php
        if (isset($ticketByRoom)) {    
            foreach ($ticketByRoom as $notRoom) {
                ?>                
                <tbody>      
                    <tr>
                        <td><?php echo $notRoom['nameCinema']?></td>
                        <td><?php echo $notRoom['nameRoom']?></td>
                        <td><?php echo $notRoom['ticketAmount'] ?></td>
                        <td><?php echo $notRoom['ticketSold'] ?></td>
                        <td><?php echo  $notRoom['unsoldTickets'] ?></td>
                    </tr>
                    <?php
                }
                ?>
                    <?php
                }
                if(!$ticketByRoom){
                    ?>
                    <div class="container mt-5 mb-5">   
                        <div class="card card-body ">
                            <?php echo "No tickets per room sold yet"?>  
                        </div>
                    </div>
                <?php
                }   ?>
  </tbody>
        </table>
    </div>

</div>