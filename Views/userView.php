<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Hi <?php echo $userName ?> !</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Back </button> 
</div>  

<div class="container  mt-5 mb-5">       
    <div class="card card-body  border-dark ">
        <ul>
            <li><strong>Name:  </strong><?php print_r($movie); ?></li>
            <li><strong>Show:  </strong><?php print_r($show); ?></li>
            <li><strong>Tickets:  </strong><?php print_r($ticket);?></li>
        </ul>  
    </div>
</div>