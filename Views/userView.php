
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
        if (isset($transaction)) {?>
            <h3 class="text-white text-center">Cart:</h3> <?php
            foreach ($transaction as $t => $value) {
                ?>
            <div class="container  mt-5 mb-5" id="seleccion">       
                <div class="card card-body  border-dark ">
                    <ul>
                        <li><strong>Name:  </strong><?php echo $value['username'] ?></li>
                        <li><strong>Date purchase:  </strong><?php echo $value['transacctionDate'] ?></li>
                        <li><strong>Tickets amount:  </strong><?php echo $value['ticketAmount'] ?></li>
                        <li><strong>Cost per ticket:  </strong><?php echo $value['costPerTicket'] ?></li>
                        <li><strong>Total Cost:  </strong><?php echo $value['costPerTicket'] * $value['ticketAmount'] ?></li>
                        <li><strong>Qr:  </strong></li>
                        <li class="liStyleNone aDropCards"><?php echo $value['qrCode'] ?></li>
                        <a href="javascript:imprSelec('seleccion')" >Print</a>
                    </ul>   
                </div>  
            </div>

            <?php
            }
        }
    if ($transaction == null){
        ?>
        <h3 class="text-white ">Cart:</h3>   
        <div class="container  mt-5 mb-5" id="seleccion">    
            
            <div class="card card-body  border-dark ">
                <?php echo "No tickets loaded yet"?>  
                </div>  
            </div>
            <img style="height:200px; margin-left:45%;"  src="<?php echo FRONT_ROOT ?>/Views/img/carrito.png">
    <?php
    } 
    ?>
