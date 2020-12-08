<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/userStyle.css">

<div class="text-center mt-5 mb-5">
    <h2 class="text-white">Purchase</h2>
</div>  

<div class="card mb-3" style="max-width: 1200px; margin: auto; margin-top:20px;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="https://image.tmdb.org/t/p/w400/.<?php echo $movieForShows[0]->getPoster()?>" class="card-img" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Purchase details:</h5>
        <ul>
            <li><strong>Film:  </strong><?php print_r($movieForShows[0]->getTitle()); ?></li>
            <li><strong>Show:  </strong><?php print_r($showToString); ?></li>
            <li><strong>Tickets:  </strong><?php print_r($ticketAmount);?></li>
            <li><strong>Cost per ticket: </strong><?php print_r($costPerTicket);?> <?php ?></li>
            <li><strong>Total cost: </strong> <?php print_r($totalCost);?><?php ?></li>
        </ul> 

        <div style="height:100px; margin-top:-10px">
        <h4 class="text-center">Confirm Purchase</h4>
        <p class="text-center" ><strong>Credit Card</strong></p>
        
        <form action="<?php echo FRONT_ROOT ?>Ticket/confirmTicket" method="POST">
       
        <table style="text-align:center;">
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
        <span class="text-muted">No signs or space</span>
        <input type="text"   pattern=<?php echo $pattern?> min="1" max="9" class="form-control" name="cardNumber" required>
    </div>
    <div class="form-group font-weight-bold">
        <label for="owner">Owner</label>
        <span class="text-muted">Name that appears on the card</span>
        <input type="text" class="form-control" name="owner" required>
    </div>
</td>   
<td>
    <div>
    <div style="margin-left:60px; margin-top:-40px">
    <div class="form-group font-weight-bold pt-2" >
        <label for="cvv">CVC</label>
        <span class="text-muted"> security code behind the card</span>
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
<input type="hidden" class="form-control" name="show" value=<?php echo $idShow ?> >
<input type="hidden" class="form-control" name="card" value=<?php echo $cardBank ?> >
</td>
</tr>
</table>

<div class="text-center">
    <input type="submit" class="btn btn-primary bg-danger text-white  mt-2 col-md-3" value="Confirm"></input>
</div>
</form>
      </div>
    </div>
  </div>
</div>
</div>
