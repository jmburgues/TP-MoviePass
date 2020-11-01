<div class="container mt-5 mb-5 " >
    <div class="card card-body ">
        <form name="formulario" class="text-justify m-2" action="<?php echo FRONT_ROOT?>Show/addShow" method="POST" >
            <div class="row">
            <div class="col mt-2">Date: </div>
            <div class="col mt-2"><input type="date" name="date" step="1" min="<?php echo date("Y-m-d");?>" max="2027-12-31" value="<?php echo date("Y-m-d");?>" required></div>
            <div class="w-100"></div>
            
            <div class="col mt-2">Starting hour: </div>
            <div class="col mt-2"><input type="time" name="start" min="00:00" max="23:59" required/></div>
            <div class="w-100"></div>
<!--  <div class="col mt-2">Fin de la función</div>
            <div class="col mt-2"><input type="time" name="end" min="00:00" max="23:59" required/></div>
            <div class="w-100"></div>
    -->        

           
            <button type="submit" class="btn btn-secondary bg-danger text-black col-2 mt-2" style="margin-left:80%"  >Send</button>
        </form>         
    </div>
</div>

