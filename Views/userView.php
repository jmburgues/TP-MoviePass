
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
    <h3 class="text-white">Personal profile:</h3> <h3 class="text-white text-uppercase"><?php echo $userName ?></h3>
</div>  

<div class="text-left mt-5 mb-3" style="margin-top:0px;">
    <h3 class="text-white">Shopping History:</h3>
        </div>
        <?php
        if($transaction == null){
            echo "<h5 class=\"text-white text-left\">No transactions yet, take a look at our latest movies!</h5>";
        }
        foreach($transaction as $t => $value ){
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
?>
