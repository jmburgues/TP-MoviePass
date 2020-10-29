<?php
    if (isset($shows)) {
        foreach ($shows as $show) {
            ?>                
<!--container--><div class="container  mt-5">   
                    
    <!--card-->     <div class="card card-body ">
                        <ul>
                            <li>Show date: <?php echo $show->getDate() ?></li>
                            <li>Show start: <?php echo $show->getStart() ?></li>
                            <li>Show end: <?php echo $show->getEnd() ?></li>
                            <li>Show spectators: <?php echo $show->getSpectators()?></li>
                            <li>Show Room: <?php echo $auxRoom->getById($show->getIdRoom())->getName();?></li>
                            <li>Show Movie: <?php echo $auxMovie->getById($show->getIdMovie())->getTitle();?></li>
                            <li>Show Cinema: <?php echo $auxCinema->getById($auxRoom->getById($show->getIdRoom())->getRoomID())->getName();?></li>

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


