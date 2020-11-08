</script>
<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Select the options for your purchase:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Back </button> 
</div>  


<div class="container border p-4 col-md-6 form loginCard" >
    <div class="mt-3">
        <form  action="<?php echo FRONT_ROOT ?>Ticket/addTicket" method="POST">
            <input type="hidden" class="form-control" name="show" value=<?php echo $idShow?> >
            <div class="form-group ">
                <label for="ticket" ><strong>Number of Tickets </strong></label>
                    <input 
                <?php
                    if(!isset($min) && !isset($max)){
                        echo "disabled";
                    }
                ?>
                
            type="number" min = "<?php echo $min ?>" max ="<?php echo $max ?>" class="form-control"  placeholder="Number of Tickets" name="tickets" required>
            </div>
            
            <label for="ticket" class="mt-2" ><strong>Select a payment method</strong></label>
            <div class="custom-control custom-radio mt-1">
                        <input type="radio" value="Visa" id="customRadio1" name="customRadio" class="custom-control-input" required>
                        <img id= "imgCardType" src="<?php echo FRONT_ROOT ?>/Views/img/visa.png">
                        <label class="custom-control-label mt-4" for="customRadio1">Visa</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" value="Master" id="customRadio2" name="customRadio" class="custom-control-input" required>
                        <img id= "imgCardType" src="<?php echo FRONT_ROOT ?>/Views/img/master.svg">
                        <label class="custom-control-label  mt-4" for="customRadio2">Mastercard</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" value="American" id="customRadio3" name="customRadio" class="custom-control-input" required>
                        <img id= "imgCardType" src="<?php echo FRONT_ROOT ?>/Views/img/american.svg">
                        <label class="custom-control-label  mt-4" for="customRadio3">American Express</label>
                    </div>
                    
        <div class="text-center">
            <input type="submit" class="btn btn-primary bg-danger text-white mt-3 col-md-3" value="Buy"></input>
        </div>
        </form>