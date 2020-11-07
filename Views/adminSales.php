
<div class="text-center mt-5 mb-3">
        <h3 class="text-white">Manage Sales:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'"> Go Back </button> 
    </div>
<br>

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
                        <li class="liStyleNone"><strong>User:</strong> <?php print_r($trans['username']) ?></li>
                        <li class="liStyleNone"><strong>Date:</strong> <?php print_r($trans['transacctionDate']) ?></li>
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


<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Tickets:</h3>
</div>
        <?php
        if (isset($tickets)) {
        foreach ($tickets as $tick) {
            ?>                
            <div class="container  mt-5">           
                <div class="card card-body ">
                    <ul>
                        <li class="liStyleNone"><strong>QR:</strong> <?php print_r($tick['qrCode'])?></li>
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
                <?php echo "No tickets loaded yet"?>  
            </div>
        </div>
    <?php
    }   
    ?>
