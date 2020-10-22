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


                                    <!--Botones con las opciones del administrador-->

<!--LISTAR CINES
    Muestra un form con una lista de todos los cines guardados en el JSON.
    Cada cine muestra su información y tienen un botón de eliminar o modificar.
    Estos botones envían al controlador del cine al método action. 
-->
<p>
    <a class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-1 " data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
        Cinemas List
    </a>
</p>
<?php
        if (isset($cinemas)) {
            foreach ($cinemas as $cinema) {
                ?>                 
                <div class="collapse offset-md-1 col-md-5" id="collapseCinema">   
                    <div class="card card-body ">
                        <?php echo $cinema->getName() ?>  
                    <ul>
                        <li>Cinema Name: <?php echo $cinema->getName() ?></li>
                        <li>Cinema Adress: <?php echo $cinema->getAddress() ?></li>
                        <li>Cinema Number: <?php echo $cinema->getNumber() ?></li>
                        <li>Cinema Opening: <?php echo $cinema->getOpenning() ?></li>
                        <li>Cinema Closing: <?php echo $cinema->getClosing() ?></li>
                        <li>Cinema Ticket Value: <?php echo $cinema->getTicketValue() ?></li>


                        <li style="list-style:none">
                            <div class="btn-group" role="group" aria-label="Basic example">
                            
                            <form action="<?php echo FRONT_ROOT?>Cinema/modifyCinemaView" method="POST">
                                <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $cinema->getId()?>"   name="idCinemaM">Modify</button> 
                            </form>
                                
                            <form action="<?php echo FRONT_ROOT?>Cinema/deleteCinema" method="POST">
                                <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $cinema->getId()?>"   name="idCinemaD">Delete</button> 
                            </form>
                        </div>
                    </li> 


                    </ul>  
                    </div>
                    </div>
                    <?php
                }
                ?>
                    <?php
                }
                if(!$cinemas){
                    ?>
                    <div class="collapse offset-md-1 col-md-5" id="collapseCinema">   
                    <div class="card card-body ">
                        <?php echo "No cinemas loaded yet"?>  
                    </div>
                    </div>
                <?php
                }
                ?>  
            </div>
           


<!---->
<!--Agregar cine
    Se muestra un formulario donde el administrador ingresará los datos requeridos: nombre, dirección, horario de apertura, horario de cierre y valor de a entrada.
    Al enviar el formulario de agregará en el JSON en caso de que todos los datos se encuentren validados.
    Al enviarlo dirige al controlador de cine al método AddCinema.
-->
<br>
<hr class="my-4">
<form class="mt-5 offset-md-1 col-md-5" action="<?php echo FRONT_ROOT ?>Cinema/AddCinema" method="POST">
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
        <label for="inputNumber" class="col-sm-2 col-form-label">Number</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" name="number" placeholder="Number" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputHorario" class="col-sm-2 col-form-label">Openning</label>
        <div class="col-sm-10">
        <input type="time"   min="00:00" max="23:59" class="form-control" name="openning" placeholder="Openning" required>

        </div>
    </div>  
    <div class="form-group row">
        <label for="inputHorario" class="col-sm-2 col-form-label">Closing</label>
        <div class="col-sm-10">
        <input type="time"   min="00:00" max="23:59" class="form-control" name="closing" placeholder="Closing" required>
        
        </div>
    </div>
    <div class="form-group row">
        <label for="inputHorario" class="col-sm-2 col-form-label">Ticket value</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" min="0" max="9999" name="ticketValue" placeholder="Ticket value" required>
        </div>
    </div>
    <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
</form>
<br>

<hr class="mt-5 my-4 ">
</form>


<!---->
<!--LISTAR PELICULAS-->
<!---->

<p>
    <a class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-1 " data-toggle="collapse" href="#collapseMovies" role="button" aria-expanded="false" aria-controls="collapseExample"> 
        Movie Showtimes 
    </a>
</p>
<?php
    if (isset($movies)) {
        foreach ($movies as $movie) {
            ?>                 
            <form action="<?php echo FRONT_ROOT?>Movie/selectMovie" method="POST">
                <div class="collapse offset-md-1 col-md-5" id="collapseMovies">   
                    <div class="card card-body ">
                    
                        <button type="submit"  value="<?php echo $movie->getMovieId()?>" name="titleMovie" style=" text-align:left; border: none; background: none;"><?php echo $movie->getTitle()?></button>     
                    </div>
                </div>
                
            <?php
            }
            ?><?php
                if(!$movies){
                    ?>
                    <div class="collapse offset-md-1 col-md-5" id="collapseCinema">   
                    <div class="card card-body ">
                        <?php echo "No movies loaded yet"?>  
                    </div>
                    </div>
                <?php
                }
                ?>  
            </form>
            <?php
            }
            ?>




<?php
    if(isset($selectedId)){
?>
    
        <div class="container">
            <p class="lead"><?php print_r($selectedId) ?></p>
            <?php //print_r($listAdminMovies);
            ?>
        </div>



<?php  }
?>

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

