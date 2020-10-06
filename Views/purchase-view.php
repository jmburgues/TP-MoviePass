<?php
require_once('header.php');
    require_once('nav.php');
?>
<!--Estilo de la página-->
<style type="text/css">
            body {
                background-color: white; 
                    
            }
            </style>


 
<div class="container border p-4 col-md-4 form" style="background-color:#FFFFFF; margin-top:6%;">
  <div class="abs-center">
    <form action="#" class="">
    <div class="form-group">
    <select class="custom-select">
  <option selected>Pelicula</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select>
      </div>
      <div class="form-group">
      <select class="custom-select">
  <option selected>Cine</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select>
      </div>
      <div class="form-group">
      <select class="custom-select">
  <option selected>Función</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select>
      </div>
      <div class="form-group">
      <label for="validationTooltip01">Cantidad Entradas</label>
      <input type="number" class="form-control" id="validationTooltip01" placeholder="Cantidad Entradas" value="Mark" required>
      </div>

      <input type="button" class="btn btn-primary bg-danger text-dark mt-3 col-md-3" onclick="location='payment-view.php'" value="comprar"></input>
    </form>
  </div>
</div>
