<?php
    require_once('nav.php');
    require_once('header.php');
    
?>
<!--Estilo de la página-->
    <style type="text/css">
            body {
                background-color: white; 
                background-image: none; 
            }
            </style>

<div class="container mt-5 " >
    <form name="formulario" class="text-danger" action="<?php echo FRONT_ROOT?>Show/addShow" method="POST" >
        <p>Día</p>
        <input type="date" name="date" step="1" min="<?php echo date("Y-m-d");?>" max="2027-12-31" value="<?php echo date("Y-m-d");?>" required>
        <p>Inicio funcion </p>
        <input type="time" name="start" min="00:00" max="23:59" required/>
        <p>fin funcion</p>
        <input type="time" name="end" min="00:00" max="23:59" required/>
        <p>Espectadores</p>
        <input type="number" name="spectators" min="0" max="325" required/>
    <button type="submit" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
    </form> 
</div>

