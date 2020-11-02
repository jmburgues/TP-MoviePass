<div class="text-center mt-5 mb-3">
        <h3 class="text-white">New Show:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'"> Go Back </button> 
    </div>

<div class="container mt-5 mb-5 " >
    <div class="card card-body m-3 ">
        <form action="<?php echo FRONT_ROOT?>Show/addShow" method="POST" >
            <div class="row">
            <div class="col mt-2 "><strong>Date: </strong></div>
            <div class="col mt-2"><input type="date" name="date" step="1" min="<?php echo date("Y-m-d");?>" max="2027-12-31" value="<?php echo date("Y-m-d");?>" required></div>
            <div class="w-100"></div>
            
            <div class="col mt-2"><strong>Starting hour:</strong> </div>
            <div class="col mt-2"><input type="time" name="start" min="00:00" max="23:59" required/></div>
            <div class="w-100"></div>

        
            <button type="submit" class="btn btn-secondary bg-danger text-black col-2 mt-2" style="margin-left:80%"  >Send</button>
        </form>         
    </div>
</div>

<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Billboard:</h3>
</div>

<?php
    if (isset($shows)) {
        foreach ($shows as $show) {
            ?>                
<!--container--><div class="container  mt-5">   
                    
    <!--card-->     <div class="card card-body ">
                        <ul>
                            <li><strong>Show date: </strong><?php echo $show->getDate() ?></li>
                            <li><strong>Show start: </strong><?php echo $show->getStart() ?></li>
                            <li><strong>Show end: </strong><?php echo $show->getEnd() ?></li>
                            <li><strong>Show spectators: </strong><?php echo $show->getSpectators()?></li>
                            <li><strong>Show Room: </strong><?php echo $auxRoom->getById($show->getIdRoom())->getName();?></li>
                            <li><strong>Show Movie: </strong><?php echo $auxMovie->getById($show->getIdMovie())->getTitle();?></li>
                            <li><strong>Show Cinema: </strong><?php echo $auxCinema->getById($auxRoom->getById($show->getIdRoom())->getRoomID())->getName();?></li>
                            
                            <li style="list-style:none; padding-left:70%">
                                <div class="btn-group" role="group" aria-label="Basic example">    
                                    <form action="<?php echo FRONT_ROOT?>Show/modifyShowView" method="POST">
                                        <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $show->getIdShow()?>"   name="idCinemaM">Modify</button> 
                                    </form>
                                    <form action="<?php echo FRONT_ROOT?>Show/deleteShow" method="POST">
                                        <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $show->getIdShow()?>" disabled  name="idCinemaD">Delete</button> 
                                    </form>
                                </div>
                            </li> 
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
</p>


