<div class="text-center mt-5 mb-3">
    <h3 class="text-white text-uppercase">Hi <?php echo $userName ?> !</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Back </button> 
</div>  

<div class="text-center mt-5 mb-3">
    <h3 class="text-white ">Cart:</h3>
        </div>
        <?php

        foreach($transaction as $t => $value ){
            ?>

        <div class="container  mt-5 mb-5">       
            <div class="card card-body  border-dark ">
                <ul>
                    <li><strong>Name:  </strong><?php echo $value['username'] ?></li>
                    <li><strong>Ddate:  </strong><?php echo $value['transacctionDate'] ?></li>
                    <li><strong>Amount ticket:  </strong><?php echo $value['ticketAmount'] ?></li>
                    <li><strong>Cost per ticket:  </strong><?php echo $value['costPerTicket'] ?></li>
                </ul>   
            </div>
        </div>

        <?php
}
?>