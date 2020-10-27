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

<?php
    foreach ($shows as $show) {
                ?>                
<!--container--><div class="container  mt-5">   
                    
    <!--card-->     <div class="card card-body ">
                        <ul>
                            <li>show dia: <?php echo $show->getDate() ?></li>
                            <li>show horario: <?php echo $show->getHour() ?></li>
                            <li>show spectators: <?php echo $show->getSpectators()?></li>
                            <li>show Sala: <?php echo $show->getIdRoom()?></li>
                            <li>show Movie: <?php echo $show->getRoomId()?></li>
                            
                        </ul>  


    <!--card-->     </div>
    
<!--container--></div>
                    <?php
                }
                ?>
<form action="<?php echo FRONT_ROOT?>Show/addShowView" method="POST">
        <input type ="submit" class="btn btn-primary bg-danger text-black mt-5 col-md-2 offset-md-5 " value="Agregar Función" data-toggle="collapse" href="#collapseCinema" role="button" aria-expanded="false" aria-controls="collapseExample"> 
        </input>
    </form>
</p>


