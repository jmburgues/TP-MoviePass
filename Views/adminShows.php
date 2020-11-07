<div class="text-center mt-5 mb-3">
        <h3 class="text-white">Manage Shows:</h3>
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'"> Go Back </button> 
</div>


<!-- COLLAPSE CARD NEW SHOW-->
<p style="margin-left:10%;">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#new" aria-expanded="false" aria-controls="collapseExample">
    Add new show
  </button>
</p>

<div class="collapse" id="new">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white">Add new Show:</h3>
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
</div>
</div>





<p style="margin-left:10%;">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#active" aria-expanded="false" aria-controls="collapseExample">
    Active Shows:
  </button>
</p>

<div class="collapse" id="active">
    <div class="text-center mt-5 mb-3">
        <h3 class="text-white">Active shows: </h3>
    </div>
    <?php
        if (isset($activeShows)) {
            foreach ($activeShows as $aShow) {
                ?>                
                <div class="container  mt-5">           
                    <div class="card card-body ">
                        <ul>
                            <li><strong>Date:</strong> <?php echo $aShow->getDate() ?></li>
                            <li><strong>Starting hour:</strong> <?php echo $aShow->getStart() ?></li>
                            <li><strong>Ending hour:</strong> <?php echo $aShow->getEnd() ?></li>
                            <li><strong>Spectators:</strong> <?php echo $aShow->getSpectators()?></li>
                            <li><strong>Room:</strong> <?php echo $aShow->getRoom()->getName();?></li>
                            <li><strong>Movie:</strong> <?php echo $aShow->getMovie()->getTitle();?></li>
                            <li><strong>Cinema:</strong> <?php echo $aShow->getRoom()->getCinema()->getName();?></li>
                        
                        </ul>  
                    </div>
                </div>
            <?php
            }
        }
        if(!$activeShows){
            ?>
            <div class="container  mt-5">   
                <div class="card card-body ">
                    <ul>
                        <li><?php echo "No Shows loaded yet" ?></li>                                
                    </ul>  
            </div>
    </div>
        <?php 
        }
        ?>
    </div>
    </p>
</div>



<!-- COLLAPSE CARD EXISTENT SHOW-->
<p style="margin-left:10%;">
  <button class="btn btn-primary bg-danger text-black mt-3" type="button" data-toggle="collapse" data-target="#existent" aria-expanded="false" aria-controls="collapseExample">
    Manage existent Shows:
  </button>
</p>

<div class="collapse" id="existent">


    <div class="text-center mt-5 mb-3">
        <h3 class="text-white">Manage existent shows (billboard):</h3>
    </div>

    <?php
        if (isset($shows)) {
            foreach ($shows as $show) {
                ?>                
    <!--container--><div class="container  mt-5">   
                        
        <!--card-->     <div class="card card-body ">
                            <ul>
                                <li><strong>Date:</strong> <?php echo $show->getDate() ?></li>
                                <li><strong>Starting hour:</strong> <?php echo $show->getStart() ?></li>
                                <li><strong>Ending hour:</strong> <?php echo $show->getEnd() ?></li>
                                <li><strong>Spectators:</strong> <?php echo $show->getSpectators()?></li>
                                <li><strong>Room:</strong> <?php echo $auxRoom->getById($show->getRoom()->getRoomID())->getName();?></li>
                                <li><strong>Movie:</strong> <?php echo $auxMovie->getById($show->getMovie()->getMovieID())->getTitle();?></li>
                                <li><strong>Cinema:</strong> <?php echo $auxCinemaName->getCinemaNameFromShows($show->getIdShow());?></li>
                                
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
</div>

