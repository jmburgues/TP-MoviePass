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


<div class="container mt-5" id="collapseExample3">
    <div class="card card-body mt-5"> Funcion1    
    </div>
    <div class="card card-body mt-5"> Funcion2    
    </div>
    <div class="card card-body mt-5"> Funcion3    
    </div>
</div>
<p>
<form action="<?php echo FRONT_ROOT?>Show/addShowView" method="POST">
        <input type ="submit" class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-5 " value="Agregar Función" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
        </input>
    </form>
</p>


