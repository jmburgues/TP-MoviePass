<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>Views/css/userStyle.css">

<script language="Javascript">
	function imprSelec(nombre) {
	  var ficha = document.getElementById(nombre);
	  var ventimp = window.open(' ', 'popimpr');
	  ventimp.document.write( ficha.innerHTML );
	  ventimp.document.close();
	  ventimp.print( );
	  ventimp.close();
	}
</script>

<div class="text-center mt-5 mb-3">
    <h3 class="text-white text-uppercase"><?php echo $userName ?>'s profile:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Back </button> 
</div>  

<?php
if(isset($transaction)) { ?>
    <h3 class="text-white text-center">Shopping history:</h3> 
    <?php
    if(!is_array($transaction)){
      $transaction = array($transaction);
    }
      foreach ($transaction as $oneTransaction) {
    ?>
    <div class="container  mt-5 mb-5" id="seleccion">       
        <div class="card card-body  border-dark ">
            <ul>
                <li><strong>Name:  </strong><?php echo $oneTransaction->getUser()->getUserName()?></li>
                <li><strong>Date purchase:  </strong><?php echo $oneTransaction->getDate() ?></li>
                <li><strong>Tickets amount:  </strong><?php echo $oneTransaction->getTicketAmount() ?></li>
                <li><strong>Cost per ticket:  </strong><?php echo $oneTransaction->getCostPerTicket() ?></li>
                <li><strong>Total Cost:  </strong><?php echo $oneTransaction->getCostPerTicket() * $oneTransaction->getTicketAmount() ?></li>
                <li><strong>Qr:  </strong></li>
                <?php $i = 1;
                
                $tickets = $ticketsPerTT[$oneTransaction->getIdTransaction()];   

                foreach($tickets as $oneTT){ ?>
                    
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-<?=$oneTT->getIdTicket()?>">
                      Ticket <?=$i?>
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal-<?=$oneTT->getIdTicket()?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">QR Code:</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                        
                            <img src="<?=$oneTT->getQRCode()?>">
                          </div>
                        </div>
                      </div>
                    </div>
                <? $i++;
                      } ?>

            </ul>   
        </div>  
    </div>

    <?php
    }
}
if ($transaction == null){
?>

<div class="container  mt-5 mb-5" id="seleccion">       
    <div class="card card-body  border-dark ">
      <p><?php echo "No tickets loaded yet";?></p>
    </div>  
</div>
<img style="height:200px; margin-left:45%;"  src="<?=IMG_CART?>" alt="Empy Cart">
<?php }  ?>
