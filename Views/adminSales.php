
<div class="text-center mt-5 mb-3">
        <h3 class="text-white">Manage Sales:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'"> Go Back </button> 
    </div>
<br>

<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Total sold:</h3>
</div>
    <div class="container  mt-5">           
        <div class="card card-body ">
            <ul>
                <li class="liStyleNone"><strong>Total Sold: $ </strong> <?php print_r($costs)?></li>
                <li class="liStyleNone"><strong>Total tickets sold:  </strong> <?php print_r($tickets)?></li>
            </ul>  
        </div>
    </div>
            

<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Transactions:</h3>
</div>
        <?php
        if (isset($transactions)) {
            foreach ($transactions as $trans) {
                ?>               
            <div class="container  mt-5">           
                <div class="card card-body ">
                    <ul>
                        <li class="liStyleNone"><strong>User purchase:</strong> <?php print_r($trans->getUser()->getUserName()); ?></li>
                        <li class="liStyleNone"><strong>Date:</strong> <?php print_r($trans->getDate()); ?></li>
                        <li class="liStyleNone"><strong>Ticket amount:</strong> <?php print_r($trans->getTicketAmount()); ?></li>
                        <li class="liStyleNone"><strong>Cost per Ticket:</strong> <?php print_r($trans->getCostPerTicket()); ?></li>
                    </ul>  
                </div>
            </div>
        <?php
            }
        }
        if(!$transactions){
            ?>
            <div class="container mt-5 mb-5">   
                <div class="card card-body ">
                    <?php echo "No transactions loaded yet"?>  
                </div>
            </div>
        <?php
        }   
        ?>


<br><br>
       
        
