<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/userStyle.css">

<script language="Javascript">
function imprSelec(nombre) {
    var ficha = document.getElementById(nombre);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}
</script>

<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Congratulations on your purchase <?php echo $user->getUserName(); ?>!</h3>
    <h6 class="text-white">Your tickets have been sent to <?=$user->getEmail();?></h6>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back"
        onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Home </button>
</div>
<?php  if(!empty($transaction) && !empty($tickets)){
        $i = 1;
        foreach($tickets as $oneTicket) { ?>
<h3 class="text-white text-center">Ticket <?=$i?>/<?=$ticketAmount?>:</h3>
<div class="container  mt-5 mb-5" id="seleccion">
    <div class="card card-body  border-dark ">
        <ul>
            <li><strong>USER: </strong><?php echo $transaction->getUser()->getUserName() ?></li>
            <li><strong>SHOW: </strong>Title: <?=$oneTicket->getShow()->getMovie()->getTitle();?>, date:
                <?=$oneTicket->getShow()->getDate()?> at <?=$oneTicket->getShow()->getStart()?> hours.</li>
            <li><strong>QR CODE: </strong></li>
            <li class="liStyleNone aDropCards"><img src="<?php echo $oneTicket->getQRCode()?>" /></li>
            <a href="javascript:imprSelec('seleccion')">Print</a>
        </ul>
    </div>
</div>
<?php
            $i++;
        }
    }
    ?>