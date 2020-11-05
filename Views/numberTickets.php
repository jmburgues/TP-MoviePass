<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Select the options for your purchase:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Back </button> 
</div>  


<div class="container border p-4 col-md-6 form" style="background-color:#FFFFFF; margin-top:6%;">
    <div class="mt-3">
        <form  action="<?php echo FRONT_ROOT ?>Ticket/addTicket" method="POST">
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
        <div class="text-center">
            <input type="submit" class="btn btn-primary bg-danger text-white mt-3 col-md-3" value="Buy"></input>
        </div>
        </form>
    </div>
</div>


