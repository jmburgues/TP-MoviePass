
<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Transactions:</h3>
</div>
        <?php
        foreach ($transactions as $trans) {
            ?>               
            <div class="container  mt-5">           
                <div class="card card-body ">
                    <ul>
                        <li style="list-style:none"><strong>User:</strong> <?php print_r($trans['username']) ?></li>
                        <li style="list-style:none"><strong>Date:</strong> <?php print_r($trans['transacctionDate']) ?></li>
                    </ul>  
                </div>
            </div>
        <?php
        }
        ?>


<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Tickets:</h3>
</div>
        <?php
        foreach ($tickets as $tick) {
            ?>                
            <div class="container  mt-5">           
                <div class="card card-body ">
                    <ul>
                        <li style="list-style:none"><strong>QR:</strong> <?php print_r($tick['qrCode'])?></li>
                    </ul>  
                </div>
            </div>
            
        <?php
        }
        ?>
