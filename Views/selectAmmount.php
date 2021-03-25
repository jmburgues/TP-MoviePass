<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/userStyle.css">
<br>
<div class="text-center mt-5 mb-5">
    <h3 class="text-white">Tickets & Payment:</h3>
</div>  
<div class="container border p-4 col-md-6 form loginCard selectShow mt-3" >
    <div class="mt-3">
        <form  action="<?php echo FRONT_ROOT ?>Ticket/payment" method="POST">
            <input type="hidden" class="form-control" name="idShow" value=<?php echo $idShow?> >
            <div class="form-group ">
                <label for="ticket" ><strong>Number of Tickets </strong></label>
                    <input 
                <?php
                    if(!isset($min) && !isset($max)){
                        echo "disabled";
                    }
                ?>
                
            type="number" min = "<?php echo $min ?>" max ="<?php echo $max ?>" class="form-control"  placeholder="<?=$max?> tickets aviable" name="ticketAmount" required>
            </div>
            
            <label for="ticket" class="mt-3" ><strong>Select a payment method</strong></label>
            <div class="custom-control custom-radio mt-1">
                        <input type="radio" value="Visa" id="customRadio1" name="cardBank" class="custom-control-input" required>
                        <img id= "imgCardType" src="<?php echo FRONT_ROOT ?>/Views/img/visa.png">
                        <label class="custom-control-label mt-4 ml-3" for="customRadio1">Visa</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" value="Master" id="customRadio2" name="cardBank" class="custom-control-input" required>
                        <img id= "imgCardType" src="<?php echo FRONT_ROOT ?>/Views/img/master.svg">
                        <label class="custom-control-label  mt-4 ml-3" for="customRadio2">Mastercard</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" value="American" id="customRadio3" name="cardBank" class="custom-control-input" required>
                        <img id= "imgCardType" src="<?php echo FRONT_ROOT ?>/Views/img/american.svg">
                        <label class="custom-control-label  mt-4 ml-3" for="customRadio3">American Express</label>
                    </div>

            <input type="submit" class="btn btn-primary bg-danger text-white mt-5 col-md-3  float-right " value="Next"></input>
        </form>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-5 col-md-3 " value="back" onclick="history.back(-1)"> Previous </button> 
