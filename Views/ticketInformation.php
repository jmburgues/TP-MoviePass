

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
    <h3 class="text-white text-uppercase">Hi <?php echo $userName ?> !</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Home </button> 
</div>  
<?php       
        if (isset($currentTransaction)) {           
                ?>
                <h3 class="text-white text-center">Ticket information:</h3>
            <div class="container  mt-5 mb-5" id="seleccion">       
                <div class="card card-body  border-dark ">
                    <ul>
                    <li><strong>Name:  </strong><?php echo $currentTransaction->getUser()->getUserName() ?></li>
                        <li><strong>Date purchase:  </strong><?php echo $currentTransaction->getDate() ?></li>
                        <li><strong>Tickets amount:  </strong><?php echo $currentTransaction->getTicketAmount() ?></li>
                        <li><strong>Cost per ticket:  </strong><?php echo $currentTransaction->getCostPerTicket() ?></li>
                        <li><strong>Total Cost:  </strong><?php echo $currentTransaction->getCostPerTicket() * $currentTransaction->getTicketAmount() ?></li>
                        <li><strong>Qr:  </strong></li>
                        <li class="liStyleNone aDropCards"><?php echo $currentQr ?></li>
                        <a href="javascript:imprSelec('seleccion')" >Print</a>
                    </ul>   
                </div>  
            </div>
            <?php
        }