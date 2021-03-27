<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/userStyle.css">
<br>
<div class="text-center mt-4 mb-5">
    <h2 class="text-white">Payment:</h2>
</div>  

<div class="card mb-3 responsive-payment" style="max-width: 1200px; margin: auto; margin-top:20px; ">
    <div class="row no-gutters ">
    <div class="col-md-4">
    <?php
            if($movieForShows[0]->getPoster() == null){
                ?><img class="notFoundImageCard" style="height:620px; width:100%; background-color:#ffe4ec" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">
            <?php
            }else{
                ?>
            <img src="https://image.tmdb.org/t/p/w400/.<?php echo $movieForShows[0]->getPoster()?>" class="card-img card-img-respons" alt="...">
            <?php
            }    
            ?>
    </div>

    <div class="col-md-8">
        <div class="card-body ">
        <ul class = "card-body-resp">
            <li><strong>Movie:  </strong><?php print_r($movieForShows[0]->getTitle()); ?></li>
            <li><strong>Show date:</strong> <?=$showSelected->getDate();?> <strong>Starts at:</strong> <?= $showSelected->getStart();?> <strong>Ends At:</strong> <?=$showSelected->getEnd();?></li>
            <li><strong>Tickets:  </strong><?php print_r($ticketAmount);?></li>
            <li><strong>Price per ticket: $</strong><?php print_r($costPerTicket);?> <?php ?></li>
            <li><strong>Total cost: $</strong> <?php print_r($totalCost);?><?php ?></li>
        </ul> 

        <div style="height:100px;" class="mt-4"><hr>
        <h4 class="text-center credit-resp"><strong>Credit Card:</strong></h4>

        <form action="<?php echo FRONT_ROOT ?>Ticket/confirmTicket" method="POST">
    
        <table style="text-align:center;" class="mt-4 table-resp">
            <tr>
                <td>

        <input hidden type="number" value= <?php echo $costPerTicket?> class="form-control" name="costPerTicket" >
        <input hidden type="number" value= <?php echo $totalCost?> class="form-control" name="totalCost" >
        <input hidden type="number" value= <?php echo $ticketAmount?> class="form-control" name="ticketAmount" >
        <div style="margin-left:40px">
        <div readolny class="form-group font-weight-bold pt-2" >
        <label for="cardNumber">Card </label>
        <input readonly type="text" placeholder= <?php echo $cardBank?> class="form-control" name="cardNumber" required
    >                       
    </div>
    <div class="form-group font-weight-bold pt-2">
        <label for="cardNumber">Card Number </label>
        <span class="text-muted muted-resp">No signs or space</span>
        <input type="text"   pattern=<?php echo $pattern?> min="1" max="9" class="form-control" name="cardNumber" required>
    </div>
    <div class="form-group font-weight-bold">
        <label for="owner">Owner</label>
        <span class="text-muted muted-resp">Name that appears on the card</span>
        <input type="text" class="form-control" name="owner" required>
    </div>
</td>   
<td>
    <div>
    <div style="margin-left:60px; margin-top:-40px">
    <div class="form-group font-weight-bold pt-2 cvc-resp" >
        <label for="cvv">CVC</label>
        <span class="text-muted muted-resp"> security code behind the card</span>
        <input type="number" min="100" max="999" placeholder= "123" class="form-control" name="cvv" required>
    </div>
        <div class="form-group font-weight-bold pt-2" >
        <label>Expiration Date</label>
        <select class="custom-select" name="date">
            <option value="01">January</option>
            <option value="02">February </option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>

        <select class="custom-select mt-2" name="year">
            <option value="2021"> 2021</option>
            <option value="2022"> 2022</option>
            <option value="2023"> 2023</option>
            <option value="2024"> 2024</option>
            <option value="2025"> 2025</option>
            <option value="2026"> 2026</option>
        </select>
    </div>
</div>
</div>
<input type="hidden" class="form-control" name="idShow" value=<?php echo $idShow ?> >
<input type="hidden" class="form-control" name="cardBank" value=<?php echo $cardBank ?> >
</td>
</tr>
</table>

<div class="text-center mt-resp">
    <input type="submit" class=" but-resp btn btn-primary bg-danger text-white  mt-4 col-md-3" value="Confirm"></input>
</div>
</form>
      </div>
    </div>
  </div>
</div>
</div>
