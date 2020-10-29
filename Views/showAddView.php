<?php
    require_once('nav.php');
    require_once('header.php');
    
?>

<div class="container mt-5 mb-5 " >
    <div class="card card-body ">
        <form name="formulario" class="text-justify m-2" action="<?php echo FRONT_ROOT?>Show/addShow" method="POST" >
            <div class="row">
            <div class="col mt-2">Fecha de la función</div>
            <div class="col mt-2"><input type="date" name="date" step="1" min="<?php echo date("Y-m-d");?>" max="2027-12-31" value="<?php echo date("Y-m-d");?>" required></div>
            <div class="w-100"></div>
            
            <div class="col mt-2">Inicio de la función</div>
            <div class="col mt-2"><input type="time" name="start" min="00:00" max="23:59" required/></div>
            <div class="w-100"></div>
<!--  <div class="col mt-2">Fin de la función</div>
            <div class="col mt-2"><input type="time" name="end" min="00:00" max="23:59" required/></div>
            <div class="w-100"></div>
    -->        

            <div class="col mt-2">Cantidad de espectadores</div>
            <div class="col mt-2"><input type="number" name="spectators" min="0" max="325" required/></div>
            <div class="w-100"></div>
            
            <button type="submit" class="btn btn-secondary bg-danger text-black col-2 mt-2" style="margin-left:80%"  >Send</button>
        </form>         
    </div>
</div>

