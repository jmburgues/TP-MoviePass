<!--container--><div class="container mt-5" >   
<form  action="<?php echo FRONT_ROOT ?>Cinema/AddCinema" method="POST">
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="Example Cinema" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputDireccion" class="col-sm-2 col-form-label">Street:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address" placeholder="Example Street" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputNumber" class="col-sm-2 col-form-label">St. Number:</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="number" placeholder="1234" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputHorario" class="col-sm-2 col-form-label">Openning hour:</label>
            <div class="col-sm-10">
            <input type="time"   min="00:00" max="23:59" class="form-control" name="openning" placeholder="00:00" required>

            </div>
        </div>  
        <div class="form-group row">
            <label for="inputHorario" class="col-sm-2 col-form-label">Closing hour:</label>
            <div class="col-sm-10">
            <input type="time"   min="00:00" max="23:59" class="form-control" name="closing" placeholder="23:59" required>
            
            </div>
        </div>
        <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
    </form>
<!--container--></div>
<br>
<?php
        if (isset($cinemas)) {    
            foreach ($cinemas as $cinema) {
                ?>                
                <div class="container  mt-5 mb-5">       
                    <div class="card card-body ">
                        <?php echo "<strong>".$cinema->getName()."</strong>" ?>  
                        <ul>
                            <li><strong>Name:  </strong><?php echo $cinema->getName() ?></li>
                            <li><strong>Street:  </strong><?php echo $cinema->getAddress() ?></li>
                            <li><strong>St. Number:  </strong><?php echo $cinema->getNumber() ?></li>
                            <li><strong>Opening hour:  </strong><?php echo $cinema->getOpenning() ?></li>
                            <li><strong>Closing hour:  </strong><?php echo $cinema->getClosing() ?></li>
                            
                            <li style="list-style:none; padding-left:70%">
                                <div class="btn-group" role="group" aria-label="Basic example">    
                                    <form action="<?php echo FRONT_ROOT?>Cinema/modifyCinemaView" method="POST">
                                        <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $cinema->getId()?>"   name="idCinemaM">Modify</button> 
                                    </form>
                                    <form action="<?php echo FRONT_ROOT?>Cinema/deleteCinema" method="POST">
                                        <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $cinema->getId()?>"   name="idCinemaD">Delete</button> 
                                    </form>
                                    <form action="<?php echo FRONT_ROOT?>Room/addRoomView" method="POST">
                                        <button type="submit" class="btn btn-secondary bg-danger text-black" value="<?php echo $cinema->getId()?>"   name="idCinemaD">Administrar Salas</button> 
                                    </form>
                                </div>
                            </li> 
                        </ul>  


    <!--card-->     </div>
    
<!--container--></div>
                    <?php
                }
                ?>
                    <?php
                }
                if(!$cinemas){
                    ?>
                    <div class="container mt-5 mb-5">   
                        <div class="card card-body ">
                            <?php echo "No cinemas loaded yet"?>  
                        </div>
                    </div>
                <?php
                }   ?>




