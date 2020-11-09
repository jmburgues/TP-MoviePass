
<div class="text-center mt-5 mb-3">
        <h3 class="text-white">Manage Sales:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'"> Go Back </button> 
    </div>
<br>



<!------------------------>
<p class="p-ml-10">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#existentCinema" aria-expanded="false" aria-controls="collapseExample">
        Total sales per Shows
  </button>
</p>

<div class="collapse" id="existentCinema">
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
                            <li><strong>Tickets sold:  </strong><?php echo $notShow['ticketSold'] ?></li>
                            <li><strong>Total income:  </strong><?php echo  $notShow['ticketAmount'] ?></li>
                            <li><strong>Total unsold:  </strong><?php echo  $notShow['unsoldTickets'] ?></li>
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
                            <?php echo "No cinemas loaded yet"?>  
                        </div>
                    </div>
                <?php
                }   ?>
</div>


