
<?php
    require_once('nav.php');
    require_once('header.php');
    
?>
<!--Estilo de la página-->
    <style type="text/css">
            body {
                background-color: #000417; 
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
    <form action="<?php echo FRONT_ROOT?>Cinema/showCinemas" method="POST">
        <input type ="submit" class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-1 " value="Cines" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
        </input>
    </form>
</p>

<p>
    <form action="<?php echo FRONT_ROOT?>Show/showShows" method="POST">
        <input type ="submit" class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-1 " value="Funciones" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
        </input>
    </form>
</p>

<p>
    <form action="<?php echo FRONT_ROOT?>Sale/showSales" method="POST">
        <input type ="submit" class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-1 " value="Ventas" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
        </input>
    </form>
</p>
