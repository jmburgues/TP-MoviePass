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


<div class="container  mt-5 mb-5">       
    <div class="card card-body  border-dark ">
        <div class="form-group ">
            <div class="creditCardForm">
                <h1 class="text-center">Confirm Purchase</h1>
                <p class="text-center" ><strong>Credit Card</strong></p>
                    <form action="<?php echo FRONT_ROOT ?>Ticket/confirmTicket" method="POST">
                        <div class="form-group font-weight-bold">
                            <label for="owner">Owner</label>
                            <input type="text" class="form-control" id="owner">
                        </div>
                        <div class="form-group font-weight-bold">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control" id="cvv">
                        </div>
                        <div class="form-group font-weight-bold" id="card-number-field">
                            <label for="cardNumber">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber">
                        </div>
                        <div class="form-group font-weight-bold" id="expiration-date">
                            <label>Expiration Date</label>
                            <select class="custom-select">
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

                            <select class="custom-select mt-2">
                                <option value="16"> 2016</option>
                                <option value="17"> 2017</option>
                                <option value="18"> 2018</option>
                                <option value="19"> 2019</option>
                                <option value="20"> 2020</option>
                                <option value="21"> 2021</option>
                            </select>
                        </div>
                        <div >
                            <img style="width:90px; height:80px; " src="https://cdn.icon-icons.com/icons2/1186/PNG/512/1490135017-visa_82256.png">
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary bg-danger text-white col-md-3" value="Confirm"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>