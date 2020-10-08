<?php
    require_once('nav.php');
    require_once('header.php');
    define("F_R", "/TP-MoviePass/");
    require_once dirname(__FILE__)."/../DAO/DAOCinema.php";
    use DAO\DAOCinema as DAOCinema;
?>
<!--Estilo de la página-->
    <style type="text/css">
            body {
                background-color: white; 
                background-image: none; 
            }
            </style>
<!--Botones con las opciones del administrador-->
<!--LISTAR CINES-->

<p>
    <a class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-1 " data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
    Listar Cines
    </a>
</p>

<?php
    $dac = new DAOCinema;
        $dc = $dac->GetAll();  
        //var_dump($dc);
        $id = 0;
        if (isset($dc)) {
            foreach ($dc as $cinema) {
                $id++;
            
                ?>                 
                <form action="<?php echo F_R?>Cinema/action" method="POST">
                <div class="collapse offset-md-1 col-md-5" id="collapseCinema">   
                    <div class="card card-body ">
                        <?php echo $cinema->getName() ?>  
                        <li>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <input type="submit" class="btn btn-secondary bg-danger text-black" value="Modificar"   name="<?php echo $cinema->getName()?>" /> 
                                <input type="submit" class="btn btn-secondary bg-danger text-black" value="Eliminar"    name="<?php echo $cinema->getName()?>" /> 
                            </div>
                        </li> 
                    <ul>
                        <li><?php echo $cinema->getName() ?></li>
                        <li><?php echo $cinema->getAddress() ?></li>
                        <li><?php echo $cinema->getOpenning() ?></li>
                        <li><?php echo $cinema->getClosing() ?></li>
                        <li><?php echo $cinema->getTicketValue() ?></li>
                    </ul>  
                    </div>
                    </div>
                    <?php
                }
                ?>
                    <?php
                }
                ?>
                
                </div>
                
                </form>

<!---->
<!---->
<!--Agregar cine-->
<!--<div class="collapse" id="collapseCinema">-->
<li>
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
<!--LISTAR PELICULAS-->
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
<!--LISTAR VENTAS-->
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

