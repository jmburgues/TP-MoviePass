
<?php
    require_once('nav.php');
    require_once('header.php');
    ?>

<!--<div>
<p>
    <input type="submit" class="offset-md-1 mt-5  col-md-2 btn btn-secondary bg-danger text-black btn-block" value="Agregar Cine" onclick="location='cine-modify.php'"/> 
    <input type="submit" class="offset-md-1 mt-4 col-md-2 btn btn-secondary bg-danger text-black btn-block" value="Agregar Película" onclick="location='film-modify.php'"/> 
</div>
</p>    
-->
<p>
    <a class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-1 " data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample"> 
    Listar Cines
    </a>
</p>
<!---->
<form action="cine-action.php" method="POST">
<div class="collapse offset-md-1 col-md-5" id="collapseExample1">
    <div class="card card-body">Cine 1    
    <ul>
    <li>
    <div class="btn-group" role="group" aria-label="Basic example">
        <input type="submit" class="btn btn-secondary bg-danger text-black" value="Modificar"   name="cine1" /> 
        <input type="submit" class="btn btn-secondary bg-danger text-black" value="Eliminar"    name="cine1"/>    
    </div>
    </li>
        <li>Nombre del primer Cine:</li>
        <li>Dirección del primer Cine:</li>
        <li>Horario del primer Cine:</li>
    </ul>  
    </div>

<!---->

<!---->

<div class="collapse" id="collapseExample1">
    <div class="card card-body">
    Cine 2
<ul>
<li>
<div class="btn-group" role="group" aria-label="Basic example">
<input type="submit" class="btn btn-secondary bg-danger text-black" value="Modificar"   name="cine2" /> 
        <input type="submit" class="btn btn-secondary bg-danger text-black" value="Eliminar"    name="cine2"/> 
</div>
</li>

    <li>Nombre del segundo Cine:
	
	</li>
    <li>Dirección del segundo Cine:</li>
    <li>Horario del segundo Cine:</li>
</ul>  
</div>
<!---->

<!---->
<div class="collapse" id="collapseExample1">
    <div class="card card-body">
    Cine 3
<ul>
<li>
<div class="btn-group" role="group" aria-label="Basic example">
<input type="submit" class="btn btn-secondary bg-danger text-black" value="Modificar"   name="cine3" /> 
        <input type="submit" class="btn btn-secondary bg-danger text-black" value="Eliminar"    name="cine3"/> 
</div>
</li>
    <li>Nombre del tercer Cine:</li>
    <li>Dirección del tercer Cine:</li>
    <li>Horario del tercerCine:</li>
</ul>  
</div>

<div class="collapse" id="collapseExample1">
<li>
<br>
  <hr class="my-4">
<form class="mt-5 offset-md-1 col-md-5">
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

</li>
</div>



</div>
</div>
</div>
</form>
<p>
<!---->

<!---->
    <a class="btn btn-primary bg-danger text-black col-md-2 offset-md-1 mt-2" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
        Listar Películas
    </a>
</p>
<form action="cine-action.php" method="POST">
<div class="collapse offset-md-1 col-md-5" id="collapseExample2">
    <div class="card card-body">
	Pelicula 1    
    <ul>
<li>
<div class="btn-group" role="group" aria-label="Basic example">
<input type="submit" class="btn btn-secondary bg-danger text-black" value="Modificar"   name="pelicula1" /> 
        <input type="submit" class="btn btn-secondary bg-danger text-black" value="Eliminar"    name="pelicula1"/> 
</div>
</li>
    <li>Nombre del primer Película:</li>
    <li>Dirección del primer Película:</li>
    <li>Horario del primer Película:</li>
</ul>  
</div>


<div class="collapse" id="collapseExample2">
    <div class="card card-body">
    Pelicula 2
<li>
<div class="btn-group" role="group" aria-label="Basic example">
<input type="submit" class="btn btn-secondary bg-danger text-black" value="Modificar"   name="pelicula2" /> 
        <input type="submit" class="btn btn-secondary bg-danger text-black" value="Eliminar"    name="pelicula2"/> 
</div>
</li>
<ul>
    <li>Nombre del segundo Película:</li>
    <li>Dirección del segundo Película:</li>
    <li>Horario del segundo Película:</li>
</ul>  
</div>


<div class="collapse" id="collapseExample2">
    <div class="card card-body">
    Pelicula 3
<ul>
<li>
<div class="btn-group" role="group" aria-label="Basic example">
<input type="submit" class="btn btn-secondary bg-danger text-black" value="Modificar"   name="pelicula3" /> 
        <input type="submit" class="btn btn-secondary bg-danger text-black" value="Eliminar"    name="pelicula3"/> 
</div>
</li>
    <li>Nombre del tercer Película:</li>
    <li>Dirección del tercer Película:</li>
    <li>Horario del tercerPelícula:</li>
</ul>  
</div>
</div>
</div>
</div>
</form>
<p>
    <a class="btn btn-primary bg-danger text-black col-md-2 offset-md-1 mt-2" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
    Ver Ventas
    </a>
</p>

<div class="collapse offset-md-1 col-md-5" id="collapseExample3">
    <div class="card card-body">
	Venta1    
<ul>
<li>
<div class="btn-group" role="group" aria-label="Basic example">
</div>
</li>
    <li>Nombre del primer Venta:</li>
    <li>Dirección del primer Venta:</li>
    <li>Horario del primer Venta:</li>
</ul>  
</div>

<div class="collapse" id="collapseExample3">
    <div class="card card-body">
    Venta 2
<ul>
<li>
<div class="btn-group" role="group" aria-label="Basic example">
</div>
</li>
    <li>Nombre del segundo Venta:</li>
    <li>Dirección del segundo Venta:</li>
    <li>Horario del segundo Venta:</li>
</ul>  
</div>
<div class="collapse" id="collapseExample3">
    <div class="card card-body">
    Venta 3
<ul>
<li>
<div class="btn-group" role="group" aria-label="Basic example">
</div>
</li>
    <li>Nombre del tercer Venta:</li>
    <li>Dirección del tercer Venta:</li>
    <li>Horario del tercer Venta:</li>
</ul>  
</div>
</div>
</div>
</div>



<?php
   // require_once('footer.php');
    ?>

<p>


