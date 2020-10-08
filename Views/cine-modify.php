<?php
    require_once('nav.php');
    require_once('header.php');
    if  (isset($cine)) echo $cine;
?>
<!--Estilo de la página-->
<style type="text/css">
            body {
                background-color: white; 
                background-image: none; 
                    
            }
            </style>
<br>
<hr class="my-4">
<form class="mt-5 offset-md-1 col-md-5" action="<?php echo F_R ?>Cinema/AddCinema" method="POST">
    <div class="form-group row ">
        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="Name" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="inputDireccion" class="col-sm-2 col-form-label">Address</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="address" placeholder="Address" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="inputHorario" class="col-sm-2 col-form-label">Openning</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="openning" placeholder="Openning" required>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="inputHorario" class="col-sm-2 col-form-label">Closing</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="closing" placeholder="Closing" required>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="inputHorario" class="col-sm-2 col-form-label">Ticket value</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="ticketValue" placeholder="Ticket value">
        </div>
    </div>

    <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>

</form>
