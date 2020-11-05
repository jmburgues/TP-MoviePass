


<div class="text-center mt-5 mb-3">
    <h2 class="text-white">Purchase</h2>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Home </button> 
</div>  

<div class="container  mt-5 mb-5">       
    <div class="card card-body  border-dark ">
        <ul>
            <li><strong>Film:  </strong><?php print_r($movieForShows[0]->getTitle()); ?></li>
            <li><strong>Show:  </strong><?php print_r($showToString); ?></li>
            <li><strong>Tickets:  </strong><?php print_r($ticketAmount);?></li>

        </ul>  
    </div>
</div>

<div class="container  mt-5 mb-5">       
    <div class="card card-body  border-dark ">
        <ul>
            
            <li><strong>Cost per ticket: </strong><?php print_r($costPerTicket);?> <?php ?></li>
            <li><strong>Total cost: </strong> <?php print_r($totalCost);?><?php ?></li>
            <li><strong>Card Type: </strong> <?php print_r($card);?><?php ?></li>
    
        </ul>  
    </div>
</div>

<div class="container  mt-5 mb-5">       
    <div class="card card-body  border-dark ">
        <div class="form-group ">
    
                <h1 class="text-center">Confirm Purchase</h1>
                <p class="text-center" ><strong>Credit Card</strong></p>
                    
                <form action="<?php echo FRONT_ROOT ?>Ticket/confirmTicket" method="POST">
                <div readolny class="form-group font-weight-bold pt-2" >
                        <label for="cardNumber">Card </label>
                        <input readonly type="text" placeholder= <?php echo $card?> class="form-control" name="cardNumber" required
                    >                       
                    </div>
                    <div class="form-group font-weight-bold pt-2" >
                        <label for="cardNumber">Card Number </label>
                        <span class="text-muted"> No signs or space</span>
                        <input type="text"   pattern=<?php echo $pattern?> min="1" max="9" class="form-control" name="cardNumber" required>
                    </div>
                    <div class="form-group font-weight-bold">
                        <label for="owner">Owner</label>
                        <span class="text-muted"> Full name and surname</span>
                        <input type="text" class="form-control" name="owner" required>
                    </div>
                    <div class="form-group font-weight-bold pt-2">
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
                            <option value="2016"> 2016</option>
                            <option value="2017"> 2017</option>
                            <option value="2018"> 2018</option>
                            <option value="2019"> 2019</option>
                            <option value="2020"> 2020</option>
                            <option value="2021"> 2021</option>
                        </select>
                    </div>
    
                
                    
            
                        <br>
                        
                </div>
                <input type="hidden" class="form-control" name="show" value=<?php echo $idShow ?> >
                <input type="hidden" class="form-control" name="card" value=<?php echo $card ?> >
                <div class="text-center">
                    <input type="submit" class="btn btn-primary bg-danger text-white col-md-3" value="Confirm"></input>
                </div>
            </form>
        
        </div>
    </div>
</div>


<hr>

