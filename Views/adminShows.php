<?php
    if (isset($shows)) {
        foreach ($shows as $show) {
            ?>                
<!--container--><div class="container  mt-5">   
                    
    <!--card-->     <div class="card card-body ">
                        <ul>
                            <li>show dia: <?php echo $show->getDate() ?></li>
                            <li>show horario start: <?php echo $show->getStart() ?></li>
                            <li>show horario end: <?php echo $show->getEnd() ?></li>
                            <li>show spectators: <?php echo $show->getSpectators()?></li>
                            <li>show Sala: <?php echo $show->getIdRoom()?></li>
                            <li>show Movie: <?php echo $show->getIdMovie()?></li>
                            
                        </ul>  


    <!--card-->     </div>
    
<!--container--></div>
                    <?php
        }
    }
    if(!$shows){
        ?>
        <div class="container  mt-5">   
                    
    <!--card-->     <div class="card card-body ">
                        <ul>
                            <li><?php echo "No Shows loaded yet" ?></li>
                            
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


