<?php
    require_once('nav.php');
    require_once('header.php');
?>
<br>
  <hr class="my-4">
<form class="mt-5 offset-md-1 col-md-5">
<div class="form-group row ">
    <label for="inputName" class="col-sm-2 col-form-label">Nombre Película</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputName" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputDuracion" class="col-sm-2 col-form-label">Duración</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputDuracion" placeholder="Duracion">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputGenero" class="col-sm-2 col-form-label">Genero</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputGenero" placeholder="Genero">
    </div>
  </div>
  <button type="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
</form>
<br>
  <hr class="mt-5 my-4 ">
