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

<form class="mt-5 offset-md-1 col-md-5"  action="<?php echo FRONT_ROOT?> Cinema/Add" method="POST">
<div class="form-group row ">
    <label for="inputName" class="col-sm-2 col-form-label">Nombre del Cine</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputName" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputDireccion" class="col-sm-2 col-form-label">Dirección</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputDireccion" placeholder="Dirección">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputHorario" class="col-sm-2 col-form-label">Horario</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputHorario" placeholder="Horario">
    </div>
  </div>
  <button type="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
</form>
<br>
  <hr class="mt-5 my-4 ">
