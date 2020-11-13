
<div class="text-center mt-5 mb-3">
        <h3 class="text-white">Manage Sales:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'"> Go Back </button> 
    </div>
<br>

<div class="container  mt-5 mb-5" id="seleccion">       
    <div class="card card-body  border-dark ">
        <ul>
            <li><strong>Total income:  </strong><?php echo $totalCostSold ?></li>
            <li><strong>Total ticket sold:  </strong><?php echo $totalTicketsAmount ?></li>
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
            <form  action="<?php echo FRONT_ROOT ?>Sale/showSales" method="POST">
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
            <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
            </form>
        </div>
    </div>

</div>

<!------------------------>
<?php if(isset($ticketByShow)){ ?>
<p class="p-ml-10">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#existentShow" aria-expanded="false" aria-controls="collapseExample">
        Total sales per Shows
  </button>
</p>

<div class="collapse" id="existentShow">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white"> Sales per Shows:</h3>
    </div>
    <?php
        if (isset($ticketByShow)) {    
            foreach ($ticketByShow as $notShow) {
                ?>                
                <div class="container  mt-5 mb-5">       
                    <div class="card card-body  border-dark ">
                        
                        <ul>
                            <li><strong>Name:  </strong><?php echo $notShow['nameShow']?></li>
                            <li><strong>Date:  </strong><?php echo $notShow['dateShow']?></li>
                            <li><strong>Tickets sold:  </strong><?php echo $notShow['ticketAmount'] ?></li>
                            <li><strong>Total income:  </strong><?php echo $notShow['ticketSold'] ?></li>
                            <li><strong>Total unsold:  </strong><?php echo $notShow['unsoldTickets'] ?></li>
                        </ul>  
    <!--card-->     </div>
    <!--container--></div>
                    <?php
                }
                ?>
                    <?php
                }
                if(!$ticketByShow){
                    ?>
                    <div class="container mt-5 mb-5">   
                        <div class="card card-body ">
                            <?php echo "No tickets per shows sold yet"?>  
                        </div>
                    </div>
                <?php
                }   }?>
</div>

<!------------------------>
<p class="p-ml-10">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#existentCinema" aria-expanded="false" aria-controls="collapseExample">
        Total sales per Cinema
  </button>
</p>

<div class="collapse" id="existentCinema">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white"> Sales per Cinema:</h3>
    </div>
    <?php
        if (isset($ticketByCinema)) {    
            foreach ($ticketByCinema as $notCinema) {
                ?>                
                <div class="container  mt-5 mb-5">       
                    <div class="card card-body  border-dark ">
                        
                        <ul>
                            <li><strong>Name:  </strong><?php echo $notCinema['nameCinema']?></li>
                            <li><strong>Tickets sold:  </strong><?php echo $notCinema['ticketAmount'] ?></li>
                            <li><strong>Total income:  </strong><?php echo $notCinema['ticketSold'] ?></li>
                            <li><strong>Total unsold:  </strong><?php echo  $notCinema['unsoldTickets'] ?></li>
                        </ul>  
    <!--card-->     </div>
    <!--container--></div>
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
</div>

<!------------------------>
<p class="p-ml-10">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#existentRoom" aria-expanded="false" aria-controls="collapseExample">
        Total sales per Room
  </button>
</p>

<div class="collapse" id="existentRoom">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white"> Sales per Room:</h3>
    </div>
    <?php
        if (isset($ticketByRoom)) {    
            foreach ($ticketByRoom as $notRoom) {
                ?>                
                <div class="container  mt-5 mb-5">       
                    <div class="card card-body  border-dark ">
                        
                        <ul>
                            <li><strong>Name cinema:  </strong><?php echo $notRoom['nameCinema']?></li>
                            <li><strong>Name room:  </strong><?php echo $notRoom['nameRoom']?></li>
                            <li><strong>Tickets sold:  </strong><?php echo $notRoom['ticketAmount'] ?></li>
                            <li><strong>Total income:  </strong><?php echo $notRoom['ticketSold'] ?></li>
                            <li><strong>Total unsold:  </strong><?php echo  $notRoom['unsoldTickets'] ?></li>
                        </ul>  
    <!--card-->     </div>
    <!--container--></div>
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
</div>